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
        ->get()
        ->keyBy('student_id')
        ->map(function ($record) {
            return [
                'attendance' => $record->attendance,
                'comment'    => $record->comment
            ];
        });

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


    public function saveAttendance(Request $request)
    {
        $request->validate([
            'class_id'        => 'required|integer|exists:classes,id',
            'attendance_date' => 'required',
            'attendance'      => 'required|array',
            'attendance.*.student_id' => 'required|integer|exists:students,id',
            'attendance.*.attendance' => 'required|in:1,2,3', // 1=Present, 2=Late, 3=Absent
        ]);

        $teacherId = Auth::id();
        $classId   = $request->class_id;

        // Parse date
        $date = Carbon::createFromFormat('F d, Y', $request->attendance_date)
                    ->format('Y-m-d');

        // Security: Teacher must be assigned to this class
        $isAssigned = StudentClassMapping::where('teacher_id', $teacherId)
                                        ->where('class_id', $classId)
                                        ->exists();

        if (!$isAssigned) {
            return response()->json(['message' => 'You are not authorized to mark attendance for this class.'], 403);
        }

        // Get only students that teacher is allowed to mark
        $allowedStudentIds = StudentClassMapping::where('teacher_id', $teacherId)
                                                ->where('class_id', $classId)
                                                ->pluck('student_id')
                                                ->toArray();

        $dataToSave = [];

        foreach ($request->attendance as $item) {
            $studentId = $item['student_id'];
            $status    = $item['attendance'];

            // Extra security: only allow students assigned to this teacher
            if (!in_array($studentId, $allowedStudentIds, true)) {
                continue; // skip invalid student
            }

            $dataToSave[] = [
                'classes_id'   => $classId,
                'student_id'   => $studentId,
                'date'         => $date,
                'attendance'   => $status, // 1, 2, or 3
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        if (empty($dataToSave)) {
            return response()->json(['message' => 'No valid data to save.'], 400);
        }

        // Delete old records for these students on this date (clean slate)
        Attendance::where('classes_id', $classId)
                ->where('date', $date)
                ->whereIn('student_id', collect($dataToSave)->pluck('student_id'))
                ->delete();

        // Insert new ones
        Attendance::insert($dataToSave);

        return response()->json([
            'message' => 'Attendance saved successfully!',
            'saved_count' => count($dataToSave)
        ], 200);
    }


    public function saveComment(Request $request)
    {
        $date = $request->date;

        $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'comment'    => 'nullable|string|max:500'
        ]);

        // ONLY UPDATE comment if the attendance record already exists
        $updated = Attendance::where('classes_id', $request->class_id)
            ->where('student_id', $request->student_id)
            ->where('date', $date)
            ->update(['comment' => $request->comment ?: null]);

        // Optional: give friendly response
        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Comment updated successfully!']);
        } else {
            return response()->json(['success' => true, 'message' => 'No attendance record found for today. Comment not saved.']);
            // OR just return success silently:
            // return response()->json(['success' => true]);
        }
    }


}