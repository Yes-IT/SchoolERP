<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classes;
use App\Models\Academic\YearStatus;
use App\Models\Session;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Str,Hash,Validator,Auth,DB,Log};
use Illuminate\Support\Str as SupportStr;

class ParentController extends Controller
{

    public function index()
    {
        $sessions     = Session::get();
        $yearStatuses = YearStatus::get();
        $students     = Student::get();

        // Fetch parents/guardians with joined location names
        $parents = User::where('role_id', 7)
            ->join('parent_guardians', 'users.id', '=', 'parent_guardians.user_id')
            ->leftJoin('countries', 'parent_guardians.country', '=', 'countries.country_id')
            ->leftJoin('states', 'parent_guardians.state', '=', 'states.id_state')
            ->leftJoin('cities', 'parent_guardians.city', '=', 'cities.id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'parent_guardians.id as parent_guardian_id',
                'parent_guardians.*',
                'countries.country_name as country_name',
                'states.state as state_name',
                'cities.city as city_name'
            )
            ->orderBy('users.id', 'desc')
            ->get();

        return view('backend.parent.index', compact(
            'sessions',
            'yearStatuses',
            'students',
            'parents'
        ));
    }


    public function addParent(){

        $students = DB::table('students')->get();
        $countries = DB::table('countries')->orderBy('country_id')->get(['country_id', 'country_name']);
        return view('backend.parent.add-parent', compact('countries','students'));

    }


    public function parent_info($parentGuardianId)
    {
        try{
                $parentGuardianId=1;
                $parent = DB::table('parent_guardians')->where('id', $parentGuardianId)->first();
                if (!$parent) {
                    abort(404, 'Parent record not found');
                }

                $students = DB::table('students')
                            ->leftJoin('uploads', 'uploads.id', '=', 'students.image_id')
                            ->where('students.parent_guardian_id', $parentGuardianId)
                           ->select(
                                'students.id',
                                'students.first_name',
                                'students.last_name',
                                'students.student_id',
                                'students.hebrew_first_name',
                                'students.hebrew_last_name',
                                'students.diploma_name',
                                'students.dob',
                                'uploads.path as image_path'
                            )
                            ->get();

                $selectedStudent = $students->first();

                $schoolDetails = null;
                if ($selectedStudent) {
                    $schoolDetails = DB::table('school_details')
                                        ->where('student_id', $selectedStudent->id)
                                        ->select('school_year', 'year_status')
                                        ->first();
                }

                return view(
                    'backend.parent.parent-info',
                    compact('parent', 'students', 'selectedStudent','schoolDetails')
                );
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('parent_flow.index')->with('error', 'Failed to get student info.');
        }
    }


    public function getStudentInfo($studentId)
    {
       
        $student = DB::table('students')
                    ->leftJoin('uploads', 'uploads.id', '=', 'students.image_id')
                    ->leftJoin(
                        'school_details',
                        'school_details.student_id',
                        '=',
                        'students.id'
                    )
                    ->where('students.id', $studentId)
                    ->select(
                        'students.first_name',
                        'students.last_name',
                        'students.student_id',
                        'students.hebrew_first_name',
                        'students.hebrew_last_name',
                        'students.diploma_name',
                        'students.dob',
                        'school_details.school_year',
                        'school_details.year_status',
                        'uploads.path as image_path',
                    )
                    ->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        return response()->json($student);
    }



    public function getStudentDetails($id)
    {
        // Get student
        $student = Student::findOrFail($id);

        // Get class mapping
        $classMapping = StudentClassMapping::where('student_id', $id)->first();

        $schoolYearName = null;
        $yearStatusName = null;

        if ($classMapping) {

            // Get class
            $class = Classes::find($classMapping->class_id);

            if ($class) {

                // Get session name (SAFE)
                $schoolYearName = Session::where('id', $class->session_id)
                    ->value('name');

                // Get year status name (SAFE)
                $yearStatusName = YearStatus::where('id', $class->year_status_id)
                    ->value('name');
            }
        }

        return response()->json([
            'first_name'     => $student->first_name,
            'last_name'      => $student->last_name,
            'school_year'    => $schoolYearName,
            'year_status'    => $yearStatusName,
            'date_of_birth'  => $student->dob,
        ]);
    }


    public function storeParent(Request $request)
    {
        // Normalize legal_guardian to lowercase for consistent comparison
        $legalGuardian = strtolower($request->legal_guardian); // e.g., "mother", "father", "both", "legal_guardian"

        // Base validation rules
        $rules = [
            'marital_status' => 'required|in:married,remarried,widowed,divorced,separated',
            'legal_guardian' => 'required|in:mother,father,both,legal_guardian',

            'address_line'   => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'state'          => 'nullable|string|max:100',
            'zip_code'       => 'nullable|string|max:20',
            'country'        => 'required|string|max:100',
            'parent_address' => 'nullable|string|max:500',

            // Parent details - all nullable by default
            'father_title'       => 'nullable|string|max:20',
            'father_name'        => 'nullable|string|max:255',
            'father_hebrew_name' => 'nullable|string|max:255',
            'father_phone'       => 'nullable|string|max:20',
            'father_email'       => 'nullable|email|max:255',
            'father_dob'         => 'nullable|date',
            'father_occupation'  => 'nullable|string|max:255',

            'mother_title'       => 'nullable|string|max:20',
            'mother_name'        => 'nullable|string|max:255',
            'maiden_name'        => 'nullable|string|max:255',
            'mother_hebrew_name' => 'nullable|string|max:255',
            'mother_phone'       => 'nullable|string|max:20',
            'mother_email'       => 'nullable|email|max:255',
            'mother_dob'         => 'nullable|date',
            'mother_occupation'  => 'nullable|string|max:255',

            'additional_phone'   => 'nullable|string|max:50',
            'additional_email'   => 'nullable|email|max:255',
            'marital_comment'    => 'nullable|string|max:500',

            // Emergency / Relative contact
            'relative_name'         => 'nullable|string|max:255',
            'relative_relationship' => 'nullable|string|max:100',
            'relative_home_phone'   => 'nullable|string|max:20',
            'relative_cell_phone'   => 'nullable|string|max:20',
            'relative_email'        => 'nullable|email|max:255',
            'relative_address'      => 'nullable|string|max:500',
        ];

        $rules['student_id'] = 'nullable|exists:students,id';

        // Dynamic required fields based on legal guardian
        switch ($legalGuardian) {
            case 'father':
                $rules['father_name']   = 'required|string|max:255';
                $rules['father_title']  = 'required|string|max:20';
                $rules['father_email']  = 'required|email|max:255';
                break;

            case 'mother':
                $rules['mother_name']   = 'required|string|max:255';
                $rules['mother_title']  = 'required|string|max:20';
                $rules['mother_email']  = 'required|email|max:255';
                break;

            case 'both':
                $rules['father_name']   = 'required|string|max:255';
                $rules['father_title']  = 'required|string|max:20';
                $rules['mother_name']   = 'required|string|max:255';
                $rules['mother_title']  = 'required|string|max:20';
                break;

            case 'legal_guardian':
                // You can add requirements here if needed (e.g. relative_name)
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        // Custom: At least one email must be provided for login
        $validator->after(function ($validator) use ($request) {
            $hasEmail = $request->filled('father_email') ||
                        $request->filled('mother_email') ||
                        $request->filled('additional_email') ||
                        $request->filled('relative_email');

            if (!$hasEmail) {
                $validator->errors()->add('father_email', 'At least one email address is required to create a parent account.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->messages()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Determine primary email and phone
            $primaryEmail = $request->father_email
                ?? $request->mother_email
                ?? $request->additional_email
                ?? $request->relative_email;

            $primaryPhone = $request->father_phone
                ?? $request->mother_phone
                ?? $request->additional_phone
                ?? $request->relative_cell_phone
                ?? $request->relative_home_phone;

            // Build parent display name for user account
            $parentName = match ($legalGuardian) {
                'both'          => trim(($request->father_name ?? '') . ' & ' . ($request->mother_name ?? '')),
                'father'        => $request->father_name ?? 'Father',
                'mother'        => $request->mother_name ?? 'Mother',
                'legal_guardian'=> $request->relative_name ?? 'Guardian',
                default         => 'Parent'
            };

            if (empty(trim($parentName))) {
                $parentName = 'Parent Account';
            }

            // Create User for login
            $userId = DB::table('users')->insertGetId([
                'name'       => $parentName,
                'email'      => $primaryEmail,
                'phone'      => $primaryPhone,
                'password'   => Hash::make('12345678'), // Recommend sending password reset link instead
                'role_id'    => 7, // Parent role
                'branch_id'  => 1,
                'status'     => 1,
                'uuid'       => SupportStr::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Build additional contacts (excluding primary email)
            $allEmails = collect([$request->father_email, $request->mother_email, $request->additional_email, $request->relative_email])
                ->filter()
                ->unique()
                ->reject(fn($email) => $email === $primaryEmail)
                ->values();

            $additionalEmails = $allEmails->isNotEmpty() ? $allEmails->implode(',') : null;

            $additionalPhones = collect([$request->additional_phone, $request->relative_cell_phone, $request->relative_home_phone])
                ->filter()
                ->unique()
                ->implode(',');

            $additionalPhones = $additionalPhones ?: null;

            // Use address_line if provided, fallback to parent_address
            $addressLine = $request->filled('address_line') ? $request->address_line : $request->parent_address;

            // Prepare clean data array - converts empty strings to null (critical for dates!)
            $data = [
                'user_id'           => $userId,
                'student_id'        => $request->student_id ?? null,

                'primary_custodian' => $request->legal_guardian, // Keep original case if needed for display
                'marital_status'    => $request->marital_status,
                'marital_comment'   => $request->marital_comment ?: null,

                // Father
                'father_title'         => $request->father_title ?: null,
                'father_name'          => $request->father_name ?: null,
                'father_hebrew_name'   => $request->father_hebrew_name ?: null,
                'father_mobile'        => $request->father_phone ?: null,
                'father_email'         => $request->father_email ?: null,
                'father_dob'           => $request->father_dob ?: null,
                'father_profession'    => $request->father_occupation ?: null,

                // Mother
                'mother_title'         => $request->mother_title ?: null,
                'mother_name'          => $request->mother_name ?: null,
                'maiden_name'          => $request->maiden_name ?: null,
                'mother_hebrew_name'   => $request->mother_hebrew_name ?: null,
                'mother_mobile'        => $request->mother_phone ?: null,
                'mother_email'         => $request->mother_email ?: null,
                'mother_dob'           => $request->mother_dob ?: null,
                'mother_profession'    => $request->mother_occupation ?: null,

                'additional_mobile_numbers' => $additionalPhones,
                'additional_emails'         => $additionalEmails,

                'address_line' => $addressLine,
                'city'         => $request->city,
                'state'        => $request->state ?: null,
                'zip_code'     => $request->zip_code ?: null,
                'country'      => $request->country,

                // Emergency Contact
                'guardian_name'       => $request->relative_name ?: null,
                'guardian_relation'   => $request->relative_relationship ?: null,
                'guardian_home_phone' => $request->relative_home_phone ?: null,
                'guardian_mobile'     => $request->relative_cell_phone ?: null,
                'guardian_email'      => $request->relative_email ?: null,
                'guardian_address'    => $request->relative_address ?: null,

                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert into parent_guardians table
            DB::table('parent_guardians')->insert($data);

            $parentId = DB::table('parent_guardians')->insertGetId($data);

            if ($request->filled('student_id')) {
                DB::table('students')
                    ->where('id', $request->student_id)
                    ->update(['parent_guardian_id' => $parentId]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Parent added successfully! Default password: 12345678 (Please change it immediately.)'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Parent creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save parent information. Please try again.'
            ], 500);
        }
    }


    public function editParent($id)
    {
        // Fetch the specific parent_guardian record by ID, joined with user
        $parent = DB::table('parent_guardians')
            ->join('users', 'parent_guardians.user_id', '=', 'users.id')
            ->where('parent_guardians.id', $id)
            ->where('users.role_id', 7) // Parent role - change if different
            ->select(
                'parent_guardians.*',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone'
            )
            ->first();

        if (!$parent) {
            abort(404, 'Parent not found');
        }

        $students = DB::table('students')->get();
        $countries = DB::table('countries')->orderBy('country_id')->get(['country_id', 'country_name']);

        return view('backend.parent.edit-parent', compact('parent','countries','students'));
    }


    public function updateParent(Request $request, $id)
    {
        // Normalize legal_guardian to lowercase for consistent comparison
        $legalGuardian = strtolower($request->legal_guardian);

        // Base validation rules (same as store)
        $rules = [
            'marital_status' => 'required|in:married,remarried,widowed,divorced,separated',
            'legal_guardian' => 'required|in:mother,father,both,legal_guardian',

            'address_line'   => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'state'          => 'nullable|string|max:100',
            'zip_code'       => 'nullable|string|max:20',
            'country'        => 'required|string|max:100',
            'parent_address' => 'nullable|string|max:500',

            // Parent details - nullable by default
            'father_title'       => 'nullable|string|max:20',
            'father_name'        => 'nullable|string|max:255',
            'father_hebrew_name' => 'nullable|string|max:255',
            'father_phone'       => 'nullable|string|max:20',
            'father_email'       => 'nullable|email|max:255',
            'father_dob'         => 'nullable|date',
            'father_occupation'  => 'nullable|string|max:255',

            'mother_title'       => 'nullable|string|max:20',
            'mother_name'        => 'nullable|string|max:255',
            'maiden_name'        => 'nullable|string|max:255',
            'mother_hebrew_name' => 'nullable|string|max:255',
            'mother_phone'       => 'nullable|string|max:20',
            'mother_email'       => 'nullable|email|max:255',
            'mother_dob'         => 'nullable|date',
            'mother_occupation'  => 'nullable|string|max:255',

            'additional_phone'   => 'nullable|string|max:50',
            'additional_email'   => 'nullable|email|max:255',
            'marital_comment'    => 'nullable|string|max:500',

            // Relative / Emergency contact
            'relative_name'         => 'nullable|string|max:255',
            'relative_relationship' => 'nullable|string|max:100',
            'relative_home_phone'   => 'nullable|string|max:20',
            'relative_cell_phone'   => 'nullable|string|max:20',
            'relative_email'        => 'nullable|email|max:255',
            'relative_address'      => 'nullable|string|max:500',
        ];

        $rules['student_id'] = 'nullable|exists:students,id';

        // Dynamic required fields based on legal guardian
        switch ($legalGuardian) {
            case 'father':
                $rules['father_name']  = 'required|string|max:255';
                $rules['father_title'] = 'required|string|max:20';
                $rules['father_email'] = 'required|email|max:255';
                break;

            case 'mother':
                $rules['mother_name']  = 'required|string|max:255';
                $rules['mother_title'] = 'required|string|max:20';
                $rules['mother_email'] = 'required|email|max:255';
                break;

            case 'both':
                $rules['father_name']  = 'required|string|max:255';
                $rules['father_title'] = 'required|string|max:20';
                $rules['mother_name']  = 'required|string|max:255';
                $rules['mother_title'] = 'required|string|max:20';
                break;

            case 'legal_guardian':
                // Optional: add requirements for relative if needed
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        // Custom: At least one email must be provided
        $validator->after(function ($validator) use ($request) {
            $hasEmail = $request->filled('father_email') ||
                        $request->filled('mother_email') ||
                        $request->filled('additional_email') ||
                        $request->filled('relative_email');

            if (!$hasEmail) {
                $validator->errors()->add('father_email', 'At least one email address is required for the parent account.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->messages()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Fetch the existing parent record
            $parent = DB::table('parent_guardians')->where('id', $id)->first();

            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent record not found.'
                ], 404);
            }

            // Determine primary email and phone (priority order)
            $primaryEmail = $request->father_email
                ?? $request->mother_email
                ?? $request->additional_email
                ?? $request->relative_email;

            $primaryPhone = $request->father_phone
                ?? $request->mother_phone
                ?? $request->additional_phone
                ?? $request->relative_cell_phone
                ?? $request->relative_home_phone;

            // Build parent display name for user account
            $parentName = match ($legalGuardian) {
                'both'          => trim(($request->father_name ?? '') . ' & ' . ($request->mother_name ?? '')),
                'father'        => $request->father_name ?? 'Father',
                'mother'        => $request->mother_name ?? 'Mother',
                'legal_guardian'=> $request->relative_name ?? 'Guardian',
                default         => 'Parent'
            };

            if (empty(trim($parentName))) {
                $parentName = 'Parent Account';
            }

            // Update the associated User record (for login)
            DB::table('users')
                ->where('id', $parent->user_id)
                ->update([
                    'name'       => $parentName,
                    'email'      => $primaryEmail,
                    'phone'      => $primaryPhone ?: null,
                    'updated_at' => now(),
                ]);

            // Collect additional emails (exclude primary)
            $allEmails = collect([$request->father_email, $request->mother_email, $request->additional_email, $request->relative_email])
                ->filter()
                ->unique()
                ->reject(fn($email) => $email === $primaryEmail)
                ->values();

            $additionalEmails = $allEmails->isNotEmpty() ? $allEmails->implode(',') : null;

            // Additional phones
            $additionalPhones = collect([$request->additional_phone, $request->relative_cell_phone, $request->relative_home_phone])
                ->filter()
                ->unique()
                ->implode(',');

            $additionalPhones = $additionalPhones ?: null;

            // Use address_line if provided, else fallback to parent_address
            $addressLine = $request->filled('address_line') ? $request->address_line : ($request->parent_address ?: $parent->address_line);

            // Prepare data for update
            $data = [
                'primary_custodian' => $request->legal_guardian, // Keep original casing if needed
                'marital_status'    => $request->marital_status,
                'marital_comment'   => $request->marital_comment ?: null,

                // Father
                'father_title'         => $request->father_title ?: null,
                'father_name'          => $request->father_name ?: null,
                'father_hebrew_name'   => $request->father_hebrew_name ?: null,
                'father_mobile'        => $request->father_phone ?: null,
                'father_email'         => $request->father_email ?: null,
                'father_dob'           => $request->father_dob ?: null,
                'father_profession'    => $request->father_occupation ?: null,

                // Mother
                'mother_title'         => $request->mother_title ?: null,
                'mother_name'          => $request->mother_name ?: null,
                'maiden_name'          => $request->maiden_name ?: null,
                'mother_hebrew_name'   => $request->mother_hebrew_name ?: null,
                'mother_mobile'        => $request->mother_phone ?: null,
                'mother_email'         => $request->mother_email ?: null,
                'mother_dob'           => $request->mother_dob ?: null,
                'mother_profession'    => $request->mother_occupation ?: null,

                'additional_mobile_numbers' => $additionalPhones,
                'additional_emails'         => $additionalEmails,

                'address_line' => $addressLine,
                'city'         => $request->city,
                'state'        => $request->state ?: null,
                'zip_code'     => $request->zip_code ?: null,
                'country'      => $request->country,

                // Emergency Contact / Relative
                'guardian_name'       => $request->relative_name ?: null,
                'guardian_relation'   => $request->relative_relationship ?: null,
                'guardian_home_phone' => $request->relative_home_phone ?: null,
                'guardian_mobile'     => $request->relative_cell_phone ?: null,
                'guardian_email'      => $request->relative_email ?: null,
                'guardian_address'    => $request->relative_address ?: null,

                'updated_at' => now(),
            ];

            // Update the parent_guardians record
            DB::table('parent_guardians')
                ->where('id', $id)
                ->update($data);


            if ($request->filled('student_id')) {
                DB::table('students')
                    ->where('id', $request->student_id)
                    ->update(['parent_guardian_id' => $id]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Parent updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Parent update failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update parent information. Please try again.'
            ], 500);
        }
    }


    public function getStates(Request $request, $country_id)
    {
        // Optional: basic validation
        if (!is_numeric($country_id) || $country_id <= 0) {
            return response()->json([]);
        }

        // Fetch states from the 'states' table where country_id matches
        $states = DB::table('states')
                    ->where('country_id', $country_id)
                    ->orderBy('state')
                    ->get(['id_state', 'state']);

        return response()->json($states);
    }

    public function getCities(Request $request, $state_id)
    {
        // Optional: basic validation
        if (!is_numeric($state_id) || $state_id <= 0) {
            return response()->json([]);
        }

        // Fetch cities from the 'cities' table where state_id matches
        $cities = DB::table('cities')
                    ->where('state_id', $state_id)
                    ->orderBy('city')
                    ->get(['id', 'city']);

        return response()->json($cities);
    }

   

}