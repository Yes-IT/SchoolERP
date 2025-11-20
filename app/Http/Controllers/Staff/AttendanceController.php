<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classes;
use App\Models\Academic\Subject;
use App\Models\Attendance\Attendance;
use App\Models\Leave;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Get classes assigned to this teacher
        $assignedClassIds = StudentClassMapping::where('teacher_id', $teacherId)
            ->distinct()
            ->pluck('class_id');

        $classes = Classes::whereIn('id', $assignedClassIds)->get();
        $subjects = Subject::orderBy('name')->get();

        return view('staff.attendance.index', compact('classes', 'subjects'));
    }


public function loadAttendance(Request $request)
{
    $request->validate([
        'class_id'        => 'required|integer|exists:classes,id',
        'subject_id'      => 'required|integer|exists:subjects,id',
        'attendance_date' => 'required',
    ]);

    $teacherId = Auth::id();
    $classId   = $request->class_id;
    $subjectId = $request->subject_id;
    $rawDate   = trim($request->attendance_date);

    // Parse date
    try {
        $dateObj = Carbon::createFromFormat('F d, Y', $rawDate)
                   ?? Carbon::createFromFormat('M d, Y', $rawDate)
                   ?? Carbon::parse($rawDate);
        $date = $dateObj->format('Y-m-d');
        $formattedDate = $dateObj->format('F d, Y');
    } catch (\Exception $e) {
        return response('<p class="text-danger">Invalid date format.</p>', 400);
    }

    // Check teacher assignment
    $isAssigned = StudentClassMapping::where('teacher_id', $teacherId)
                                     ->where('class_id', $classId)
                                     ->exists();
    if (!$isAssigned) {
        return '<p class="text-danger">You are not assigned to this class.</p>';
    }

    // Get students assigned to this teacher + class
    $students = Student::select('students.id', 'students.student_id', 'students.first_name', 'students.last_name')
        ->join('student_class_mapping', 'students.id', '=', 'student_class_mapping.student_id')
        ->where('student_class_mapping.teacher_id', $teacherId)
        ->where('student_class_mapping.class_id', $classId)
        ->orderBy('students.first_name')
        ->get();

    if ($students->isEmpty()) {
        return '<p class="text-center">No students assigned to you in this class.</p>';
    }

    $studentIds = $students->pluck('id');

    // Existing attendance for this date
    $attendanceRecords = Attendance::where('classes_id', $classId)
        ->whereIn('student_id', $studentIds)
        ->where('date', $date)
        ->pluck('attendance', 'student_id'); // student_id => 1/2/3/4 or null

    // All leaves (approved, pending, rejected) that cover this date
    $leaves = Leave::where('classes_id', $classId)
        ->whereIn('student_id', $studentIds)
        ->where('from_date', '<=', $date)
        ->where('to_date', '>=', $date)
        ->get()
        ->keyBy('student_id');

    return view('staff.attendance.attendance_table', compact(
        'students',
        'date',
        'formattedDate',
        'attendanceRecords',
        'leaves',
        'classId',
        'subjectId'
    ))->render();
}


}