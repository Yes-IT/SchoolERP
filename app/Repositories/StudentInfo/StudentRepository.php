<?php

namespace App\Repositories\StudentInfo;

use App\Models\Role;
use App\Models\User;
use App\Enums\Settings;
use App\Models\Session;
use App\Enums\ApiStatus;
use Illuminate\Support\Str;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Models\StudentInfo\SessionClassStudent;
use App\Interfaces\StudentInfo\StudentInterface;

class StudentRepository implements StudentInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;

    private $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getStudents($request)
    {
        return  SessionClassStudent::query()
            ->where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->when(request()->filled('gender'), function ($q) use ($request) {
                $q->whereHas('student', fn($q) => $q->where('gender_id', $request->gender));
            })
            ->with('student')
            ->get();
    }


    // public function getPaginateAll()
    // {
    //     return SessionClassStudent::whereHas('student')->where('session_id', setting('session'))->latest()->with('student')->paginate(Settings::PAGINATE);
    // }





    public function getPaginateAll()
    {
        // Subquery for latest form_checklist row per student
        $latestChecklist = \DB::table('form_checklist as fc1')
            ->select('fc1.*')
            ->whereRaw('fc1.id = (
            SELECT MAX(fc2.id) 
            FROM form_checklist as fc2 
            WHERE fc2.student_id = fc1.student_id
        )');

        return SessionClassStudent::where('session_id', setting('session'))
            ->join('students as s', 's.id', '=', 'session_class_students.student_id')
            ->leftJoin('school_details as sd', 'sd.student_id', '=', 's.id')
            ->leftJoin('parent_guardians as pg', 'pg.student_id', '=', 's.id')
            ->leftJoinSub($latestChecklist, 'fc', function ($join) {
                $join->on('fc.student_id', '=', 's.id');
            })
            ->select(
                'session_class_students.*',
                's.first_name',
                's.last_name',
                'sd.school_year',
                'sd.year_status',
                'sd.homeroom_class',
                'sd.group',
                'sd.division',
                'sd.floor',
                'sd.room',
                'pg.father_name',
                'fc.travel_from',
                'fc.flight_date',
                'fc.flight_info',
                'fc.checklist'
            )
            ->latest('session_class_students.id')
            ->with('student.imageUpload')
            ->paginate(Settings::PAGINATE);
    }

    public function getSessionStudent($id)
    {
        return SessionClassStudent::where('id', $id)->first();
    }


    // public function searchStudents($request)
    // {
    //     $students = SessionClassStudent::query();
    //     $students = $students->where('session_id', setting('session'));

    //     if ($request->class != "") {
    //         $students = $students->where('classes_id', $request->class);
    //     }
    //     if ($request->section != "") {
    //         $students = $students->where('section_id', $request->section);
    //     }
    //     if ($request->keyword != "") {
    //         $students = $students->whereHas('student', function ($query) use ($request) {
    //             $query->where('admission_no', 'LIKE', "%{$request->keyword}%")
    //                 ->orWhere('first_name', 'LIKE', "%{$request->keyword}%")
    //                 ->orWhere('last_name', 'LIKE', "%{$request->keyword}%")
    //                 ->orWhere('roll_no', 'LIKE', "%{$request->keyword}%")
    //                 ->orWhere('dob', 'LIKE', "%{$request->keyword}%");
    //         });
    //     }

    //     return $students->paginate(Settings::PAGINATE);
    // }

    public function searchStudents($request)
    {
        $students = SessionClassStudent::query()
            ->where('session_id', setting('session'))
            ->join('students as s', 's.id', '=', 'session_class_students.student_id')
            ->leftJoin('school_details as sd', 'sd.student_id', '=', 's.id')
            ->leftJoin('parent_guardians as pg', 'pg.user_id', '=', 's.user_id')
            ->leftJoin('form_checklist as fc', 'fc.student_id', '=', 's.id')


            ->select(
                'session_class_students.*',
                's.first_name',
                's.last_name',
                'sd.school_year',
                'sd.year_status',
                'sd.homeroom_class',
                'sd.group',
                'sd.division',
                'sd.floor',
                'sd.room',
                'pg.father_name',
                'fc.travel_from',
                'fc.flight_date',
                'fc.flight_info',
                'fc.checklist'
            )
            ->with('student.imageUpload');


        if ($request->class) {
            $students->where('classes_id', $request->class);
        }
        if ($request->section) {
            $students->where('section_id', $request->section);
        }
        if ($request->school_year) {
            $students->where('sd.school_year', $request->school_year);
        }
        if ($request->year_status) {
            $students->where('sd.year_status', $request->year_status);
        }
        if ($request->keyword) {
            $students->where(function ($query) use ($request) {
                $query->where('s.admission_no', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('s.first_name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('s.last_name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('s.roll_no', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('s.dob', 'LIKE', "%{$request->keyword}%");
            });
        }

        return $students->paginate(Settings::PAGINATE);
    }


    // public function store($request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         if ($this->model->count() >= activeSubscriptionStudentLimit() && env('APP_SAAS'))
    //             return $this->responseWithError(___('alert.Student limit is over.'), []);

    //         $role                     = Role::find(6);
    //         $user                    = new User();
    //         $user->name              = $request->first_name . ' ' . $request->last_name;
    //         $user->email             = $request->email  != "" ? $request->email :  NULL;
    //         $user->phone             = $request->mobile != "" ? $request->mobile :  NULL;
    //         $user->admission_no      = $request->admission_no;
    //         $user->password          = $request->password_type == 'default' ? Hash::make('123456') : Hash::make($request->password);
    //         $user->email_verified_at = now();
    //         $user->role_id           = $role->id;
    //         $user->permissions       = $role->permissions;
    //         $user->date_of_birth     = $request->date_of_birth;
    //         $user->username          = $request->username;
    //         $user->upload_id         = $this->UploadImageCreate($request->image, 'backend/uploads/students');
    //         $user->uuid              = Str::uuid();
    //         $user->save();

    //         $row                       = new $this->model;
    //         $row->user_id              = $user->id;
    //         $row->first_name           = $request->first_name;
    //         $row->last_name            = $request->last_name;
    //         $row->hebrew_last_name     = $request->hebrew_last_name;
    //         $row->hebrew_first_name    = $request->hebrew_first_name;
    //         $row->diploma_name         = $request->diploma_name;
    //         $row->hebrew_dob           = $request->hebrew_dob;
    //         $row->ssn                  = $request->ssn;
    //         $row->passport_no          = $request->passport_no;
    //         $row->passport_name        = $request->passport_name;
    //         $row->passport_country     = $request->passport_country;
    //         $row->passport_exp_date    = $request->passport_exp_date;
    //         $row->teudat_zehut         = $request->teudat_zehut;
    //         $row->insurance            = $request->insurance;
    //         $row->insurance_type       = $request->insurance_type;
    //         $row->cell_israel          = $request->cell_israel;
    //         $row->cell_usa             = $request->cell_usa;
    //         $row->high_school          = $request->high_school;
    //         $row->city                 = $request->city;
    //         $row->state                = $request->state;
    //         $row->zip_code             = $request->zip_code;
    //         $row->marital_status       = $request->marital_status;
    //         $row->mobile               = $request->mobile;
    //         $row->image_id             = $user->upload_id;
    //         $row->email                = $request->email;
    //         $row->dob                  = $request->date_of_birth;
    //         $row->parent_guardian_id   = $request->parent != "" ? $request->parent :  NULL;
    //         $row->place_of_birth       = $request->place_of_birth;
    //         $row->country              = $request->country;
    //         $row->residance_address    = $request->residance_address;
    //         $row->status               = $request->status;
    //         $row->upload_documents     = $this->uploadDocuments($request);
    //         $row->health_status        = $request->health_status;
    //         $row->rank_in_family       = !empty($request->rank_in_family) ? $request->rank_in_family : 0;
    //         $row->siblings             = !empty($request->siblings) ? $request->siblings : 0;
    //         $row->cpr_no               = $request->cpr_no;
    //         $row->spoken_lang_at_home  = $request->spoken_lang_at_home;
    //         $row->residance_address    = $request->residance_address;
    //         $row->department_id        = $request->department_id;

    //         $parentId = DB::table('parent_guardians')->insertGetId([
    //             'student_id' => $row->id,
    //             'father_name' => $request->father_name,
    //             'father_hebrew_name' => $request->father_hebrew_name,
    //             'father_mobile' => $request->father_mobile,
    //             'father_profession' => $request->father_profession,
    //             'mother_name' => $request->mother_name,
    //             'maiden_name' => $request->maiden_name,
    //             'mother_hebrew_name' => $request->mother_hebrew_name,
    //             'mother_mobile' => $request->mother_mobile,
    //             'mother_profession' => $request->mother_profession,
    //             'guardian_name' => $request->guardian_name,
    //             'guardian_email' => $request->guardian_email,
    //             'guardian_mobile' => $request->guardian_mobile,
    //             'guardian_profession' => $request->guardian_profession,
    //             'guardian_relation' => $request->guardian_relation,
    //             'guardian_address' => $request->guardian_address,
    //             'father_dob' => $request->father_dob,
    //             'mother_dob' => $request->mother_dob,
    //             'additional_mobile_numbers' => $request->additional_mobile_numbers,
    //             'father_email' => $request->father_email,
    //             'mother_email' => $request->mother_email,
    //             'additional_emails' => $request->additional_emails,
    //             'guardian_address' => $request->guardian_address,
    //             'guardian_home_phone' => $request->guardian_home_phone,
    //             'status'     => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         $row->parent_guardian_id = $parentId;
    //         $row->save();


    //         DB::table('school_details')->insert([
    //             'school_id' => $request->school_id,
    //             'student_id' => $row->id,
    //             'school_year' => $request->school_year,
    //             'year_status' => $request->year_status,
    //             'college' => $request->college,
    //             'withdraw_date' => $request->withdraw_date,
    //             'homeroom_class' => $request->homeroom_class,
    //             'group' => $request->group,
    //             'division' => $request->division,
    //             'floor' => $request->floor,
    //             'room' => $request->room,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         if ($request->has('request_date') && $request->has('request_destination')) {
    //             $requestDates = $request->request_date;
    //             $requestDestinations = $request->request_destination;
    //             $requestTypes = $request->payment_status;

    //             foreach ($requestDates as $index => $requestDate) {
    //                 if (empty($requestDestinations[$index])) continue;

    //                 DB::table('request_transcript')->insert([
    //                     'student_id' => $row->id,
    //                     'request_date'   => $requestDate,
    //                     'destination' => $requestDestinations[$index],
    //                     'type'     => $requestTypes[$index],
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }

    //         if ($request->has('class_id') && $request->has('teacher_id')) {
    //             $classIds = $request->class_id;
    //             $teacherIds = $request->teacher_id;

    //             foreach ($classIds as $index => $classId) {
    //                 if (empty($teacherIds[$index])) continue;

    //                 DB::table('student_class_mapping')->insert([
    //                     'student_id' => $row->id,
    //                     'class_id'   => $classId,
    //                     'teacher_id' => $teacherIds[$index],
    //                     'status'     => 1,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }


    //         $session_class                      = new SessionClassStudent();
    //         $session_class->session_id          = setting('session');
    //         $session_class->classes_id          = $request->class;
    //         $session_class->section_id          = $request->section != "" ? $request->section :  NULL;
    //         $session_class->shift_id            = $request->shift != "" ? $request->shift :  NULL;
    //         $session_class->student_id          = $row->id;
    //         $session_class->roll                = $request->roll_no;
    //         $session_class->save();

    //         DB::commit();
    //         return $this->responseWithSuccess(___('alert.created_successfully'), []);
    //     } catch (\Throwable $th) {
    //         DB::rollback();
    //         dd($th);
    //         return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
    //     }
    // }


    public function store($request)
    {
        DB::beginTransaction();
        try {
            if ($this->model->count() >= activeSubscriptionStudentLimit() && env('APP_SAAS'))
                return $this->responseWithError(___('alert.Student limit is over.'), []);
            $role                     = Role::find(6); // student role id 6
            $user                    = new User();
            $user->name              = $request->first_name . ' ' . $request->last_name;
            $user->email             = $request->email  != "" ? $request->email :  NULL;
            $user->phone             = $request->mobile != "" ? $request->mobile :  NULL;
            $user->admission_no      = $request->admission_no;
            $user->password          =   Hash::make('123456');
            $user->email_verified_at = now();
            $user->role_id           = $role->id;
            $user->permissions       = $role->permissions;
            $user->date_of_birth     = $request->date_of_birth;
            $user->username          = $request->username;
            // $user->upload_id         = $this->UploadImageCreate($request->image, 'backend/uploads/students');
            if ($request->hasFile('image')) {
                $user->upload_id = $this->UploadImageCreate($request->file('image'), 'backend/uploads/students');
            } else {
                $user->upload_id = null;
            }

            $user->uuid              = Str::uuid();
            $user->save();
            $row                       = new $this->model;
            $row->user_id              = $user->id;
            $row->student_id = $this->generateUniqueStudentId();
            $row->first_name           = $request->first_name;
            $row->last_name            = $request->last_name;
            $row->hebrew_last_name            = $request->hebrew_last_name;
            $row->hebrew_first_name           = $request->hebrew_first_name;
            $row->diploma_name                = $request->diploma_name;
            $row->hebrew_dob                  = $request->hebrew_dob;
            $row->place_of_birth              = $request->place_of_birth;
            $row->ssn                         = $request->ssn;
            $row->passport_no                 = $request->passport_no;
            $row->passport_name               = $request->passport_name;
            $row->passport_country            = $request->passport_country;
            $row->passport_exp_date           = $request->passport_exp_date;
            $row->teudat_zehut                = $request->teudat_zehut;
            $row->insurance                   = $request->insurance;
            $row->insurance_type              = $request->insurance_type;
            $row->cell_israel                 = $request->cell_israel;
            $row->cell_usa                    = $request->cell_usa;
            $row->high_school                 = $request->high_school;
            $row->city                        = $request->city;
            $row->state                       = $request->state;
            $row->zip_code                    = $request->zip_code;
            $row->marital_status              = $request->marital_status;
            $row->mobile               = $request->mobile;
            $row->image_id             = $user->upload_id;
            $row->email                = $request->email;
            $row->dob                  = $request->date_of_birth;
            $row->parent_guardian_id   = $request->parent != "" ? $request->parent :  NULL;
            $row->country = $request->country;
            $row->residance_address = $request->residance_address;
            $row->status               = $request->status;
            $row->upload_documents     = $this->uploadDocuments($request);
            $row->health_status = $request->health_status;
            $row->rank_in_family = !empty($request->rank_in_family) ? $request->rank_in_family : 0;
            $row->siblings = !empty($request->siblings) ? $request->siblings : 0;
            $row->cpr_no = $request->cpr_no;
            $row->spoken_lang_at_home = $request->spoken_lang_at_home;
            $row->department_id = $request->department_id;
            $row->save();

            $parentId = DB::table('parent_guardians')->insertGetId([
                'student_id' => $row->id,
                // 'user_id'    => $user->id,
                'father_name' => $request->father_name,
                'father_hebrew_name' => $request->father_hebrew_name,
                'father_mobile' => $request->father_mobile,
                'father_profession' => $request->father_profession,
                'mother_name' => $request->mother_name,
                'maiden_name' => $request->maiden_name,
                'mother_hebrew_name' => $request->mother_hebrew_name,
                'mother_mobile' => $request->mother_mobile,
                'mother_profession' => $request->mother_profession,
                'guardian_name' => $request->guardian_name,
                'guardian_email' => $request->guardian_email,
                'guardian_mobile' => $request->guardian_mobile,
                'guardian_profession' => $request->guardian_profession,
                'guardian_relation' => $request->guardian_relation,
                'guardian_address' => $request->guardian_address,
                'father_dob' => $request->father_dob,
                'mother_dob' => $request->mother_dob,
                'additional_mobile_numbers' => $request->additional_mobile_numbers,
                'father_email' => $request->father_email,
                'mother_email' => $request->mother_email,
                'additional_emails' => $request->additional_emails,
                'guardian_address' => $request->guardian_address,
                'guardian_home_phone' => $request->guardian_home_phone,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);



            $row->parent_guardian_id = $parentId;
            $row->save();

            DB::table('school_details')->insert([
                'school_id' => $request->school_id,
                'student_id' => $row->id,
                'school_year' => $request->school_yearsd,
                'year_status' => $request->year_statussd,
                'college' => $request->college,
                'withdraw_date' => $request->withdraw_date,
                'homeroom_class' => $request->homeroom_class,
                'group' => $request->group,
                'division' => $request->division,
                'floor' => $request->floor,
                'room' => $request->room,
                'created_at' => now(),
                'updated_at' => now(),
            ]);







            if ($request->has('school_year')) {
                $schoolYears = $request->school_year;
                $yearStatuses = $request->year_status;
                $travelForms = $request->travel_form;
                $flightDates = $request->flight_date;
                $flightInfos = $request->flight_information;
                $checklists  = $request->checklist;

                foreach ($schoolYears as $index => $schoolYear) {
                    if (empty($schoolYear)) continue;

                    $flightDate = null;
                    if (!empty($flightDates[$index])) {
                        try {
                            $flightDate = \Carbon\Carbon::parse($flightDates[$index])->format('Y-m-d');
                        } catch (\Exception $e) {
                            $flightDate = null;
                        }
                    }

                    DB::table('form_checklist')->insert([
                        'student_id'  => $row->id,
                        'school_year' => $schoolYear,
                        'year_status' => $yearStatuses[$index] ?? null,
                        'travel_from' => $travelForms[$index] ?? null,
                        'flight_date' => $flightDate,
                        'flight_info' => $flightInfos[$index] ?? null,
                        'checklist'   => $checklists[$index] ?? null,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }

            if ($request->has('request_date') && $request->has('request_destination')) {
                $requestDates = $request->request_date;
                $requestDestinations = $request->request_destination;
                $requestTypes = $request->payment_status;

                foreach ($requestDates as $index => $requestDate) {
                    if (empty($requestDestinations[$index])) continue;

                    DB::table('request_transcript')->insert([
                        'student_id' => $row->id,
                        'request_date'   => $requestDate,
                        'destination' => $requestDestinations[$index],
                        'type'     => $requestTypes[$index],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if ($request->has('class_id') && $request->has('teacher_id')) {
                $classIds = $request->class_id;
                $teacherIds = $request->teacher_id;

                foreach ($classIds as $index => $classId) {
                    if (empty($teacherIds[$index])) continue;

                    DB::table('student_class_mapping')->insert([
                        'student_id' => $row->id,
                        'class_id'   => $classId,
                        'teacher_id' => $teacherIds[$index],
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }


            $session_class                      = new SessionClassStudent();
            $session_class->session_id          = setting('session');
            $session_class->classes_id          = $request->class;
            $session_class->section_id          = $request->section != "" ? $request->section :  NULL;
            $session_class->shift_id            = $request->shift != "" ? $request->shift :  NULL;
            $session_class->student_id          = $row->id;
            $session_class->roll                = $request->roll_no;
            $session_class->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }





    // public function show($id)
    // {
    //     return $this->model->with('parent')->find($id);
    // }


    // public function show($id)
    // {
    //     return $this->model
    //         ->with('imageUpload')
    //         ->leftJoin('school_details as sd', 'sd.student_id', '=', 'students.id')
    //         ->leftJoin('parent_guardians as pg', 'pg.student_id', '=', 'students.id')
    //         ->leftJoin('form_checklist as fc', 'fc.student_id', '=', 'students.id')
    //         ->select(
    //             'students.*',
    //             'sd.school_id',
    //             'sd.college',
    //             'sd.withdraw_date',
    //             'sd.school_year',
    //             'sd.year_status',
    //             'sd.homeroom_class',
    //             'sd.group',
    //             'sd.division',
    //             'sd.floor',
    //             'sd.room',
    //             'pg.father_name',
    //             'pg.father_hebrew_name',
    //             'pg.mother_hebrew_name',
    //             'pg.mother_name',
    //             'pg.maiden_name',
    //             'pg.father_dob',
    //             'pg.mother_dob',
    //             'pg.additional_mobile_numbers',
    //             'pg.father_mobile',
    //             'pg.mother_mobile',
    //             'pg.guardian_name',
    //             'pg.father_email',
    //             'pg.father_profession',
    //             'pg.mother_profession',
    //             'pg.mother_email',
    //             'pg.additional_emails',
    //             'pg.guardian_address',
    //             'pg.guardian_home_phone',
    //             'pg.guardian_mobile',
    //             'pg.guardian_email',
    //             'pg.guardian_address',
    //             'pg.guardian_relation',
    //             'fc.travel_from',
    //             'fc.flight_date',
    //             'fc.flight_info',
    //             'fc.checklist'
    //         )
    //         ->where('students.id', $id)
    //         ->first();
    // }

    public function show($id)
    {
        return $this->model
            ->with(['imageUpload', 'requestTranscripts', 'classMappings.class', 'classMappings.teacher', 'formChecklists'])
            ->leftJoin('school_details as sd', 'sd.student_id', '=', 'students.id')
            ->leftJoin('parent_guardians as pg', 'pg.student_id', '=', 'students.id')
            ->leftJoin('form_checklist as fc', 'fc.student_id', '=', 'students.id')
            ->select(
                'students.*',
                'sd.school_id',
                'sd.college',
                'sd.withdraw_date',
                'sd.school_year',
                'sd.year_status',
                'sd.homeroom_class',
                'sd.group',
                'sd.division',
                'sd.floor',
                'sd.room',
                'pg.father_name',
                'pg.father_hebrew_name',
                'pg.mother_hebrew_name',
                'pg.mother_name',
                'pg.maiden_name',
                'pg.father_dob',
                'pg.mother_dob',
                'pg.additional_mobile_numbers',
                'pg.father_mobile',
                'pg.mother_mobile',
                'pg.guardian_name',
                'pg.father_email',
                'pg.father_profession',
                'pg.mother_profession',
                'pg.mother_email',
                'pg.additional_emails',
                'pg.guardian_home_phone',
                'pg.guardian_address',
                'pg.guardian_mobile',
                'pg.guardian_email',
                'pg.guardian_address',
                'pg.guardian_relation',
                'fc.travel_from',
                'fc.flight_date',
                'fc.flight_info',
                'fc.checklist'


            )
            ->where('students.id', $id)
            ->first();
    }

    // public function update($request, $id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $row                      = $this->model->find($id);

    //         $user                     = User::where('id', $row->user_id)->first();

    //         $role                     = Role::find($user->role_id);

    //         $user->name               = $request->first_name . ' ' . $request->last_name;
    //         $user->email              = $request->email != "" ? $request->email :  NULL;
    //         $user->phone              = $request->mobile != "" ? $request->mobile :  NULL;
    //         $user->date_of_birth      = $request->date_of_birth;
    //         $user->admission_no       = $request->admission_no;
    //         $user->upload_id          = $this->UploadImageUpdate($request->image, 'backend/uploads/students', $user->upload_id);
    //         $user->permissions        = $role->permissions;
    //         $user->username          = $request->username;
    //         $user->save();

    //         $row->first_name           = $request->first_name;
    //         $row->last_name            = $request->last_name;
    //         $row->admission_no         = $request->admission_no;
    //         $row->roll_no              = $request->roll_no != "" ? $request->roll_no :  NULL;
    //         $row->mobile               = $request->mobile;
    //         $row->image_id             = $user->upload_id;
    //         $row->email                = $request->email;
    //         $row->dob                  = $request->date_of_birth;
    //         $row->religion_id          = $request->religion != "" ? $request->religion :  NULL;
    //         $row->gender_id            = $request->gender != "" ? $request->gender :  NULL;
    //         $row->blood_group_id       = $request->blood != "" ? $request->blood :  NULL;
    //         $row->admission_date       = $request->admission_date;
    //         $row->parent_guardian_id   = $request->parent != "" ? $request->parent :  NULL;
    //         $row->student_category_id  = $request->category != "" ? $request->category :  NULL;

    //         $row->previous_school = $request->previous_school ?? 0;
    //         $row->previous_school_info = $request->previous_school ? $request->previous_school_info : null;
    //         $row->previous_school_image_id = $request->previous_school ? $this->UploadImageCreate($request->previous_school_image, 'backend/uploads/students') : null;
    //         $row->place_of_birth = $request->place_of_birth;
    //         $row->nationality = $request->nationality;
    //         $row->cpr_no = $request->cpr_no;
    //         $row->spoken_lang_at_home = $request->spoken_lang_at_home;
    //         $row->residance_address = $request->residance_address;

    //         $row->health_status = $request->health_status;
    //         $row->rank_in_family = !empty($request->rank_in_family) ? $request->rank_in_family : 0;
    //         $row->siblings = !empty($request->siblings) ? $request->siblings : 0;

    //         $row->status               = $request->status;
    //         $row->upload_documents     = $row->upload_documents ?? $this->uploadDocuments($request, $row->upload_documents);
    //         $row->department_id        = $request->department_id;
    //         $row->save();

    //         $session_class                      = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $row->id)->first();
    //         $session_class->classes_id          = $request->class;
    //         $session_class->section_id          = $request->section != "" ? $request->section :  NULL;
    //         $session_class->shift_id            = $request->shift != "" ? $request->shift :  NULL;
    //         $session_class->student_id          = $row->id;
    //         $session_class->roll                = $request->roll_no;
    //         $session_class->save();

    //         DB::commit();
    //         return $this->responseWithSuccess(___('alert.updated_successfully'), []);
    //     } catch (\Throwable $th) {
    //         dd($th);
    //         DB::rollback();
    //         return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
    //     }
    // }


    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->findOrFail($id);
            $user = User::findOrFail($row->user_id);
            $role = Role::find($user->role_id);
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email ?: null;
            $user->phone = $request->mobile ?: null;
            $user->date_of_birth = $request->date_of_birth;
            $user->admission_no = $request->admission_no ?: null;
            $user->upload_id = $this->UploadImageUpdate($request->file('image') ?? $request->image, 'backend/uploads/students', $user->upload_id);
            $user->permissions = $role->permissions;
            $user->username = $request->username;
            $user->save();

            // update students table (row)
            $row->first_name = $request->first_name;
            $row->last_name = $request->last_name;
            $row->hebrew_last_name            = $request->hebrew_last_name;
            $row->hebrew_first_name           = $request->hebrew_first_name;
            $row->diploma_name                = $request->diploma_name;
            $row->hebrew_dob                  = $request->hebrew_dob;
            $row->ssn                         = $request->ssn;
            $row->mobile = $request->mobile;
            $row->image_id = $user->upload_id;
            $row->email = $request->email;
            $row->dob = $request->date_of_birth;
            $row->place_of_birth = $request->place_of_birth;
            $row->residance_address = $request->residance_address;
            $row->status = $request->status;
            $row->department_id = $request->department_id;
            $row->upload_documents = $row->upload_documents ?? $this->uploadDocuments($request, $row->upload_documents);
            $row->save();

            $session_class = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $row->id)->first();
            if (!$session_class) {
                $session_class = new SessionClassStudent();
                $session_class->session_id = setting('session');
                $session_class->student_id = $row->id;
            }
            $session_class->classes_id = $request->class;
            $session_class->section_id = $request->section ?: null;
            $session_class->shift_id = $request->shift ?: null;
            $session_class->roll = $request->roll_no;
            $session_class->save();

            // parent_guardians: updateOrInsert by user_id
            DB::table('parent_guardians')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'father_name' => $request->father_name,
                    'father_hebrew_name' => $request->father_hebrew_name,
                    'father_mobile' => $request->father_mobile,
                    'father_profession' => $request->father_profession,
                    'mother_name' => $request->mother_name,
                    'maiden_name' => $request->maiden_name,
                    'mother_hebrew_name' => $request->mother_hebrew_name,
                    'mother_mobile' => $request->mother_mobile,
                    'mother_profession' => $request->mother_profession,
                    'guardian_name' => $request->guardian_name,
                    'guardian_email' => $request->guardian_email,
                    'guardian_mobile' => $request->guardian_mobile,
                    'guardian_profession' => $request->guardian_profession,
                    'guardian_relation' => $request->guardian_relation,
                    'guardian_address' => $request->guardian_address,
                    'father_dob' => $request->father_dob,
                    'mother_dob' => $request->mother_dob,
                    'additional_mobile_numbers' => $request->additional_mobile_numbers,
                    'father_email' => $request->father_email,
                    'mother_email' => $request->mother_email,
                    'additional_emails' => $request->additional_emails,
                    'guardian_home_phone' => $request->guardian_home_phone,
                    'status' => 1,
                    'updated_at' => now(),
                ]
            );

            // school_details updateOrInsert
            DB::table('school_details')->updateOrInsert(
                ['student_id' => $row->id],
                [
                    'school_id' => $request->school_id,
                    'school_year' => $request->school_yearsd,
                    'year_status' => $request->year_statussd,
                    'college' => $request->college,
                    'withdraw_date' => $request->withdraw_date,
                    'homeroom_class' => $request->homeroom_class,
                    'group' => $request->group,
                    'division' => $request->division,
                    'floor' => $request->floor,
                    'room' => $request->room,
                    'updated_at' => now(),
                ]
            );

            // form_checklist: update or insert (single record)
            // $flightDate = null;
            // if (!empty($request->flight_date)) {
            //     try {
            //         $flightDate = \Carbon\Carbon::parse($request->flight_date)->format('Y-m-d');
            //     } catch (\Exception $e) {
            //         $flightDate = null;
            //     }
            // }
            // DB::table('form_checklist')->updateOrInsert(
            //     ['student_id' => $row->id],
            //     [
            //         'school_year' => $request->school_year,
            //         'year_status' => $request->year_status,
            //         'travel_from' => $request->travel_form,
            //         'flight_date' => $flightDate,
            //         'flight_info' => $request->flight_information,
            //         'checklist' => $request->checklist,
            //         'updated_at' => now(),
            //     ]
            // );


            // Delete existing records if needed or update individually
            DB::table('form_checklist')->where('student_id', $row->id)->delete();

            if ($request->has('flight_date') && is_array($request->flight_date)) {
                foreach ($request->flight_date as $index => $fdate) {
                    $flightDate = null;
                    if (!empty($fdate)) {
                        try {
                            $flightDate = \Carbon\Carbon::parse($fdate)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $flightDate = null;
                        }
                    }

                    DB::table('form_checklist')->insert([
                        'student_id' => $row->id,
                        'school_year' => $request->school_year[$index] ?? null,
                        'year_status' => $request->year_status[$index] ?? null,
                        'travel_from' => $request->travel_form[$index] ?? null,
                        'flight_date' => $flightDate,
                        'flight_info' => $request->flight_information[$index] ?? null,
                        'checklist' => $request->checklist[$index] ?? null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]);
                }
            }


            // request_transcript: delete existing then re-insert from arrays
            DB::table('request_transcript')->where('student_id', $row->id)->delete();
            if ($request->has('request_date') && is_array($request->request_date)) {
                foreach ($request->request_date as $index => $rdate) {
                    if (empty($request->request_destination[$index])) continue;
                    DB::table('request_transcript')->insert([
                        'student_id' => $row->id,
                        'request_date' => $rdate,
                        'destination' => $request->request_destination[$index],
                        'type' => $request->payment_status[$index] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // student_class_mapping: delete existing then re-insert
            DB::table('student_class_mapping')->where('student_id', $row->id)->delete();
            if ($request->has('class_id') && is_array($request->class_id)) {
                foreach ($request->class_id as $index => $classId) {
                    if (empty($request->teacher_id[$index])) continue;
                    DB::table('student_class_mapping')->insert([
                        'student_id' => $row->id,
                        'class_id' => $classId,
                        'teacher_id' => $request->teacher_id[$index],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th); // during dev; remove dd() on production
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    // public function destroy($id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $row  = $this->model->find($id);
    //         $user = User::find($row->user_id);
    //         if ($user) {
    //             $this->UploadImageDelete($user->upload_id);
    //             foreach ($row->upload_documents ?? [] as $doc) {
    //                 $this->UploadImageDelete($doc['file']);
    //             }
    //             $user->delete(); // when user delete auto delete student, session class student table's row
    //         }
    //         SessionClassStudent::where('student_id', $row->id)->delete();
    //         $row->delete();

    //         DB::commit();
    //         return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
    //     } catch (\Throwable $th) {
    //         DB::rollback();
    //         dd($th);
    //         return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
    //     }
    // }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $student = $this->model->find($id);
            if (!$student) {
                return $this->responseWithError('Student not found', []);
            }

            if ($student->upload_documents) {
                foreach ($student->upload_documents as $doc) {
                    $this->UploadImageDelete($doc['file']);
                }
            }

            if ($student->previous_school_image_id) {
                $this->UploadImageDelete($student->previous_school_image_id);
            }

            DB::table('school_details')->where('student_id', $id)->delete();

            DB::table('parent_guardians')->where('student_id', $student->id)->delete();

            DB::table('form_checklist')->where('student_id', $id)->delete();

            DB::table('request_transcript')->where('student_id', $id)->delete();

            DB::table('student_class_mapping')->where('student_id', $id)->delete();

            SessionClassStudent::where('student_id', $id)->delete();

            $user = User::find($student->user_id);
            if ($user) {
                if ($user->upload_id) {
                    $this->UploadImageDelete($user->upload_id); // profile image
                }
                $user->delete();
            }

            $student->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    private function generateUniqueStudentId()
    {
        do {
            // Generate random 6-digit number
            $studentId = mt_rand(1000000, 9999999);

            // Check if this ID already exists in the students table
            $exists = $this->model->where('student_id', $studentId)->exists();
        } while ($exists);

        return $studentId;
    }
}
