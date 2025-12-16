<?php

namespace App\Repositories\ParentPanel;

use Illuminate\Http\Request;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\{Auth,Log};
use App\Models\Attendance\Attendance;
use Illuminate\Support\Facades\Session;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Interfaces\ParentPanel\AttendanceInterface;

class AttendanceRepository implements AttendanceInterface
{
    public function index()
    {
        try {
            $parent           = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
            $data['student']  = Student::where('id', Session::get('student_id'))->first();

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // public function search($request)
    // {
    //     try {
    //         Session::put('student_id', $request->student);
    //         $parent   = ParentGuardian::where('user_id', Auth::user()->id)->first();
    //         $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
    //         $data['student']  = Student::where('id', Session::get('student_id'))->first();

    //         $student        = Student::where('id', Session::get('student_id'))->first();
    //         $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();

    //         $result = Attendance::query();
    //         $result = $result->where('session_id', setting('session'))
    //         ->where('classes_id', $classSection->classes_id)
    //         ->where('section_id', $classSection->section_id)
    //         ->where('student_id', $student->id);
    //         if($request->month != "") {
    //             $result = $result->where('date', 'LIKE', $request->month.'%');
    //         }
    //         if($request->date != "") {
    //             $result = $result->where('date', $request->date);
    //         }
    //         if($request->view == 0) {
    //             $data['results'] = $result->get();
    //         }
    //         else{
    //             $data['results'] = $result->paginate(10);
    //         }

    //         return $data;

    //     } catch (\Throwable $th) {
    //         return false;
    //     }
    // }

    public function search($request, $studentId = null)
    {
        try {
            // Use provided studentId or get from session (backward compatibility)
            $studentId = $studentId ?? Session::get('current_student_id');
            
            if (!$studentId) {
                // Try to get from currentStudent in request
                if (method_exists($request, 'get') && $request->get('currentStudent')) {
                    $studentId = $request->get('currentStudent')->id;
                }
            }
            
            if (!$studentId) {
                throw new \Exception('No student selected');
            }
            
            $parent = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
            $data['student'] = Student::find($studentId);

            if (!$data['student']) {
                throw new \Exception('Student not found');
            }

            $classSection = SessionClassStudent::where('session_id', setting('session'))
                ->where('student_id', $data['student']->id)
                ->latest()
                ->first();

            if (!$classSection) {
                return [
                    'students' => $data['students'],
                    'student' => $data['student'],
                    'results' => collect(),
                    'message' => 'No class section found for this student'
                ];
            }

            $result = Attendance::query();
            $result = $result->where('session_id', setting('session'))
                ->where('classes_id', $classSection->classes_id)
                ->where('section_id', $classSection->section_id)
                ->where('student_id', $data['student']->id);
                
            if($request->month != "") {
                $result = $result->where('date', 'LIKE', $request->month.'%');
            }
            if($request->date != "") {
                $result = $result->where('date', $request->date);
            }
            
            if($request->view == 0) {
                $data['results'] = $result->get();
            } else {
                $data['results'] = $result->paginate(10);
            }

            return $data;

        } catch (\Throwable $th) {
            Log::error('Attendance repository error: ' . $th->getMessage());
            return [
                'students' => collect(),
                'student' => null,
                'results' => collect(),
                'error' => $th->getMessage()
            ];
        }
    }
}
