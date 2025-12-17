<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\YearStatus;
use App\Models\Session;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator,Auth,DB,Log};

class ParentController extends Controller
{

    public function index()
    {
        $sessions     = Session::get();
        $yearStatuses = YearStatus::get();
        $students     = Student::get();

        return view('backend.parent.index', compact(
            'sessions',
            'yearStatuses',
            'students'
        ));
    }


    public function addParent(){
        return view('backend.parent.add-parent');

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


   

}