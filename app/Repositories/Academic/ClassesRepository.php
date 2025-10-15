<?php

namespace App\Repositories\Academic;

use App\Enums\Settings;
use App\Models\Academic\{Classes,Subject,ClassSchedule};
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\{DB,Log};
use App\Models\Academic\ClassSetup;
use App\Interfaces\Academic\ClassesInterface;
use App\Models\ClassTranslate;
use Carbon\Carbon;
use App\Models\StudentInfo\Student;


class ClassesRepository implements ClassesInterface
{
    use ReturnFormatTrait;

    private $classes;
    private $classTrans;
    private $subject;

    public function __construct(Classes $classes , ClassTranslate $classTrans, Subject $subject)
    {
        $this->classes = $classes;
        $this->classTrans = $classTrans;
        $this->subject = $subject;
    }

    public function assignedAll()
    {
        return ClassSetup::active()->where('session_id', setting('session'))->get();
    }

    public function all()
    {
        return $this->classes->active()->get();
    }

    public function getAll()
    {
        // return $this->classes->latest()->paginate(Settings::PAGINATE);
         return $this->classes
            ->with(['subject', 'teacher', 'session', 'yearStatus', 'semester']) 
            ->latest()
            ->paginate(Settings::PAGINATE);

        Log::info('records in classes', ['classes' => $this->classes]);    
    }

    public function getSubjectDetails($subjectId)
    {
        $subject = $this->subject->find($subjectId);

        if (!$subject) return null;

        return [
            'credits' => $subject->credits,
            'allowed_absences' => $subject->allowed_absences,
            'allowed_penalty_amount' => $subject->allowed_penalty_amount,
            'number_latenesses_equal_absence' => $subject->number_latenesses_equal_absence,
            'attendance_percent_auto_fail' => $subject->attendance_percent_auto_fail,
            'hebrew_attendance' => $subject->hebrew_attendance,
            'report_card' => $subject->report_card,
            'attendance_percent_amount' => $subject->attendance_percent_amount,
            'attendance_percent_fail_grade' => $subject->attendance_percent_fail_grade,
            'gpa_weight' => $subject->gpa_weight,
            'prec_rc' => $subject->prec_rc,
            'transcript_name' => $subject->transcript_name,
            'course_number' => $subject->course_number,
            'college_transcript' => $subject->college_transcript,
            'prec_transcript' => $subject->prec_transcript,
            'charter_oak_transcript' => $subject->charter_oak_transcript,
            'co_year_long'=> $subject->co_year_long,
            'co_department' => $subject->co_department,
            'elective' => $subject->elective,
            'comment' => $subject->comment,
            'composite_average' => $subject->composite_average,
            'composite_class_1' => $subject->composite_class_1,
            'composite_class_2' => $subject->composite_class_2,
            'composite_class_1_weight' => $subject->composite_class_1_weight,
            'composite_class_2_weight' => $subject->composite_class_2_weight
        ];
    }

   
    // public function store($request)
    // {
    //     Log::info('request in class store', ['request' => $request->all()]);

    //     try {
    //         DB::beginTransaction();

    //         // 1. Save Class
    //         $classesStore = new $this->classes;
    //         $classesStore->name                       = $request->class_name;
    //         $classesStore->identification_number      = $request->identification_number;
    //         $classesStore->subject_id                 = $request->subject_id;
    //         $classesStore->teacher_id                 = $request->teacher_id;
    //         $classesStore->school_year_id             = $request->school_year_id;
    //         $classesStore->semester_id                = $request->semester_id;
    //         $classesStore->year_status_id             = $request->year_status_id;
    //         $classesStore->composite_average          = $request->composite_average ? 1 : 0;
    //         $classesStore->composite_class_1          = $request->composite_class_1;
    //         $classesStore->composite_class_2          = $request->composite_class_2;
    //         $classesStore->composite_class_1_weight   = $request->composite_class_1_weight;
    //         $classesStore->composite_class_2_weight   = $request->composite_class_2_weight;

    //         $savedClass = $classesStore->save();
    //         Log::info('Class save result', ['saved' => $savedClass, 'class_id' => $classesStore->id]);

    //         // 2. Save Subject Specifications (if subject_id is selected)
    //         if ($request->subject_id) {
    //             $subject = Subject::find($request->subject_id);
    //             if ($subject) {
    //                 $subject->class_id                       = $classesStore->id;
    //                 $subject->credits                        = $request->credits;
    //                 $subject->allowed_absences               = $request->allowed_absences;
    //                 $subject->allowed_penalty_amount         = $request->allowed_penalty_amount;
    //                 $subject->number_latenesses_equal_absence= $request->number_latenesses_equal_absence;
    //                 $subject->attendance_percent_auto_fail   = $request->attendance_percent_auto_fail ? 1 : 0;
    //                 $subject->hebrew_attendance              = $request->hebrew_attendance ? 1 : 0;
    //                 $subject->report_card                    = $request->report_card ? 1 : 0;
    //                 $subject->attendance_percent_amount      = $request->attendance_percent_amount;
    //                 $subject->attendance_percent_fail_grade  = $request->attendance_percent_fail_grade;
    //                 $subject->gpa_weight                     = $request->gpa_weight;
    //                 $subject->prec_rc                        = $request->prec_rc;
    //                 $subject->transcript_name                = $request->transcript_name;
    //                 $subject->course_number                  = $request->course_number;
    //                 $subject->college_transcript             = $request->college_transcript ? 1 : 0;
    //                 $subject->prec_transcript                = $request->prec_transcript;
    //                 $subject->charter_oak_transcript         = $request->charter_oak_transcript ? 1 : 0;
    //                 $subject->co_year_long                   = $request->co_year_long ? 1 : 0;
    //                 $subject->co_department                  = $request->co_department;
    //                 $subject->elective                       = $request->elective ? 1 : 0;
    //                 $subject->comment                        = $request->comment;

    //                 $savedSubject = $subject->save();
    //                 Log::info('Subject update result', ['saved' => $savedSubject, 'subject_id' => $subject->id]);
    //             } else {
    //                 Log::warning('Subject not found', ['subject_id' => $request->subject_id]);
    //             }
    //         }

    //         DB::commit();

    //         return $this->responseWithSuccess(___('alert.class_created_successfully'), []);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         Log::error('Error in class store', [
    //             'error_message' => $th->getMessage(),
    //             'trace' => $th->getTraceAsString()
    //         ]);
    //         return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
    //     }
    // }

    public function store($request)
    {
        // Log::info('request in class store', ['request' => $request->all()]);
        // Log::info('Student IDs:', ['students' => $request->student_ids]);

        try {
            DB::beginTransaction();

            $class = new $this->classes;
            $class->name                               = $request->class_name;
            $class->identification_number              = $request->identification_number;
            $class->abbreviation                       = $request->abbreviation;
            $class->subject_id                         = $request->subject_id; 
            $class->teacher_id                         = $request->teacher_id;
            $class->school_year_id                     = $request->school_year_id;
            $class->semester_id                        = $request->semester_id;
            $class->year_status_id                     = $request->year_status_id;

            
            $class->composite_average          = $request->composite_average ? 1 : 0;
            $class->composite_class_1          = $request->composite_class_1;
            $class->composite_class_2          = $request->composite_class_2;
            $class->composite_class_1_weight   = $request->composite_class_1_weight;
            $class->composite_class_2_weight   = $request->composite_class_2_weight;
            $class->save();

            // Log::info('Class created', ['class_id' => $class->id]);

            // Step 2: Create Schedule(s) for this class
            if ($request->has('schedules')) {
                foreach ($request->schedules as $schedule) {
                    $start_time = Carbon::createFromFormat('h:i A', $schedule['start_time'])->format('H:i:s');
                    $end_time   = Carbon::createFromFormat('h:i A', $schedule['end_time'])->format('H:i:s');
                    $room_id = $schedule['room_id'] !== '' ? $schedule['room_id'] : null;

                    ClassSchedule::create([
                        'class_id'   => $class->id,
                        'day'        => $schedule['day'],
                        'period'     => $schedule['period'],
                        'start_time' => $start_time,
                        'end_time'   => $end_time,
                        'room_id'    => $room_id
                    ]);
                }
            }

            
           //step 3: update subject common details wrt class
            if (!$request->has('is_class_for_scheduling')) {
                $subject = Subject::find($request->subject_id);
                if ($subject) {
                    $subject->update([
                        'credits' => $request->credits,
                        'allowed_absences' => $request->allowed_absences,
                        'allowed_penalty_amount' => $request->allowed_penalty_amount,
                        'number_latenesses_equal_absence' => $request->number_latenesses_equal_absence,
                        'attendance_percent_auto_fail' => $request->attendance_percent_auto_fail ? 1 : 0,
                        'hebrew_attendance' => $request->hebrew_attendance ? 1 : 0,
                        'report_card' => $request->report_card ? 1 : 0,
                        'attendance_percent_amount' => $request->attendance_percent_amount,
                        'attendance_percent_fail_grade' => $request->attendance_percent_fail_grade,
                        'gpa_weight' => $request->gpa_weight,
                        'prec_rc' => $request->prec_rc,

                        'transcript_name' => $request->transcript_name,
                        'course_number' => $request->course_number,
                        'college_transcript' => $request->college_transcript ? 1 : 0,
                        'prec_transcript' => $request->prec_transcript,
                        'charter_oak_transcript' => $request->charter_oak_transcript ? 1 : 0,
                        'co_year_long'=> $request->co_year_long ? 1 : 0,
                        'co_department' => $request->co_department,

                        'elective' => $request->elective ? 1 : 0,
                        'comment' => $request->comment
                    ]);
                }
            }

            //step 4:adding students in the class
             if ($request->has('student_ids') && !empty($request->student_ids)) {
                // Validate that students exist
                $existingStudents = Student::whereIn('id', $request->student_ids)->pluck('id')->toArray();
                
                if (count($existingStudents) > 0) {
                    $class->students()->attach($existingStudents);
                    Log::info('Students attached to class:', [
                        'class_id' => $class->id,
                        'students' => $existingStudents
                    ]);
                } else {
                    Log::warning('No valid students found to attach', ['requested_ids' => $request->student_ids]);
                }
            } else {
                Log::info('No students to attach to class');
            }

            DB::commit();

            return $this->responseWithSuccess(___('alert.class_created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in class store', [
                'error_message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }



    public function show($id)
    {
        return $this->classes->with([
            'subject',
            'teacher', 
            // 'schoolYear',
            'session',
            'yearStatus',
            'semester',
            'schedules.room',
            'students'
            ])->find($id);
    }


    public function update($request, $id)
    {
        Log::info('Update request received', $request->all());

        try {
            $class             = $this->classes->findOrfail($id);
            $class->name       = $request->class_name;
            $class->subject_id = $request->subject_id;
            $class->teacher_id = $request->teacher_id;
            $class->school_year_id = $request->school_year_id;
            $class->semester_id = $request->semester_id;

            $class->composite_average = $request->has('composite_average') ? 1 : 0;
            $class->composite_class_1 = $request->composite_class_1;
            $class->composite_class_2 = $request->composite_class_2;
            $class->composite_class_1_weight = $request->composite_class_1_weight;
            $class->composite_class_2_weight = $request->composite_class_2_weight;
            $class->is_class_scheduling = $request->has('is_class_for_scheduling') ? 1 : 0;
            // $class->save();

             // Save class specifications (only if not scheduling-only)
            if (!$class->is_class_scheduling)
            {
                $subject = Subject::find($request->subject_id);
                if ($subject) {
                    $subject->update([
                        'credits' => $request->credits,
                        'allowed_absences' => $request->allowed_absences,
                        'allowed_penalty_amount' => $request->allowed_penalty_amount,
                        'number_latenesses_equal_absence' => $request->number_latenesses_equal_absence,
                        'attendance_percent_auto_fail' => $request->attendance_percent_auto_fail ? 1 : 0,
                        'hebrew_attendance' => $request->hebrew_attendance ? 1 : 0,
                        'report_card' => $request->report_card ? 1 : 0,
                        'attendance_percent_amount' => $request->attendance_percent_amount,
                        'attendance_percent_fail_grade' => $request->attendance_percent_fail_grade,
                        'gpa_weight' => $request->gpa_weight,
                        'prec_rc' => $request->prec_rc,

                        'transcript_name' => $request->transcript_name,
                        'course_number' => $request->course_number,
                        'college_transcript' => $request->college_transcript ? 1 : 0,
                        'prec_transcript' => $request->prec_transcript,
                        'charter_oak_transcript' => $request->charter_oak_transcript ? 1 : 0,
                        'co_year_long'=> $request->co_year_long ? 1 : 0,
                        'co_department' => $request->co_department,

                        'elective' => $request->elective ? 1 : 0,
                        'comment' => $request->comment
                    ]);
                }   
            }

            $class->save();

             // Handle schedules update
            if ($request->has('schedules')) {
                $class->schedules()->delete();
                
                foreach ($request->schedules as $scheduleData) {
                    if (!empty($scheduleData['day']) && !empty($scheduleData['period'])) {
                        // Convert time format from '09:00 AM' to '09:00:00'
                        if (!empty($scheduleData['start_time'])) {
                            $scheduleData['start_time'] = $this->convertTo24HourFormat($scheduleData['start_time']);
                        }
                        if (!empty($scheduleData['end_time'])) {
                            $scheduleData['end_time'] = $this->convertTo24HourFormat($scheduleData['end_time']);
                        }
                        
                        $class->schedules()->create($scheduleData);
                    }
                }
            }

            
            // Sync students (this will add new ones and remove deleted ones)
            if ($request->has('student_ids')) {
                $class->students()->sync($request->student_ids);
            } else {
                // If no students selected, remove all
                $class->students()->detach();
            }

            return $this->responseWithSuccess(___('alert.Class_updated_successfully'), []);
        } catch (\Throwable $th) {
            Log::error('Error in class update', [
                'error_message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    private function convertTo24HourFormat($time12Hour)
    {
        try {
            return \Carbon\Carbon::createFromFormat('h:i A', $time12Hour)->format('H:i:s');
        } catch (\Exception $e) {
            // If conversion fails, return the original time or handle the error
            Log::error('Time conversion error', [
                'original_time' => $time12Hour,
                'error' => $e->getMessage()
            ]);
            return $time12Hour; // or return null, or throw exception
        }
    }

    public function destroy($id)
    {
        try {
            $classesDestroy = $this->classes->find($id);
            $classesDestroy->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function translates($id)
    {
        return $this->classTrans->where('class_id',$id)->get()->groupBy('locale');
    }

    public function translateUpdate($request, $id){
        DB::beginTransaction();
        try {
            $delete_old = $this->classTrans->where('class_id',$id)->delete();
            $class = $this->show($id);

            foreach($request->name as $key => $name){
                $row                   = new $this->classTrans;
                $row->class_id        = $id ;
                $row->locale           = $key ;
                $row->name             = $name;
                $row->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    // public function filter($request)
    // {
    //     Log::info('request in filter', ['request' => $request->all()]);
    //     $query = Classes::query()->with(['subject', 'teacher', 'schoolYear', 'yearStatus', 'semester']);

       
    //     if ($request->teacher_id && $request->teacher_id !== 'all') {
    //         $query->where('teacher_id', $request->teacher_id);
    //     }

    //     Log::info('query in filter', ['query' => $query]);
    //    return $query->paginate(
    //         $request->per_page ?? 10, 
    //         ['*'], 
    //         'page', 
    //         $request->page ?? 1
    //     )->appends($request->except('page'));
    // }

    public function filter($requestData)
    {
        Log::info('Filter request received', $requestData);

        Log::info('filter request data', [
            'teacher_id' => $requestData['teacher_id'] ?? null,
            'per_page' => $requestData['per_page'] ?? null,
        ]);

        
        $query = Classes::query()->with(['subject', 'teacher', 'schoolYear', 'yearStatus', 'semester']);

        if (isset($requestData['teacher_id']) && $requestData['teacher_id'] !== 'all') {
            Log::info('Filtering by teacher_id: ' . $requestData['teacher_id']);
            $query->where('teacher_id', $requestData['teacher_id']);
        }

        $perPage = $requestData['per_page'] ?? 10; 

        $results = $query->paginate($perPage);

        Log::info('Query results', ['results' => $results, 'total' => $results->total()]);
        
        return $results;
    }




}
