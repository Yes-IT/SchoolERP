<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classes;
use App\Models\Academic\Semester;
use App\Models\Academic\Subject;
use App\Models\Academic\YearStatus;
use App\Models\Attendance\Attendance;
use App\Models\Leave;
use App\Models\Session;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AttendanceReportController extends Controller{

    public function index()
    {

        $teacherId = Auth::id();
        $assignedClassIds = StudentClassMapping::where('teacher_id', $teacherId)->distinct()->pluck('class_id');

        $classes = Classes::whereIn('id', $assignedClassIds)->get();
        $subjects = Subject::get();
        $years = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderByDesc('id')->get();
        $semesters = Semester::orderByDesc('id')->get();

        return view('staff.report.attendance.index', compact(
            'classes',
            'subjects',
            'years',
            'yearStatuses',
            'semesters'
        ));
    }

    
    public function search(Request $request)
    {
        $tab      = $request->input('tab', 'month');
        $month    = (int)$request->input('month', now()->month);
        $year     = now()->year;

        // Filters
        $classIds = is_array($request->class_id) ? $request->class_id : [$request->class_id];
        $classIds = array_filter($classIds);

        if (empty($classIds)) {
            return response()->json([
                'html' => '<p class="text-center text-muted py-5">Please select at least one class.</p>'
            ]);
        }

        // 1. Get students assigned to current teacher in selected classes
        $studentIds = DB::table('student_class_mapping')
            ->where('teacher_id', Auth::id())
            ->whereIn('class_id', $classIds)
            ->where('status', 1)
            ->distinct()
            ->pluck('student_id')
            ->toArray();

        if (empty($studentIds)) {
            return response()->json([
                'html' => '<p class="text-center text-muted py-5">No students assigned to you in the selected class.</p>'
            ]);
        }

        // 2. Load students
        $students = Student::whereIn('id', $studentIds)
            ->orderBy('first_name')
            ->get();

        // 3. Days to show
        $startOfMonth = Carbon::create($year, $month, 1);
        $today        = Carbon::today();
        $maxDay       = $startOfMonth->isCurrentMonth() ? $today->day : $startOfMonth->copy()->endOfMonth()->day;

        // 4. Attendance records
        $attendanceRecords = Attendance::whereIn('student_id', $studentIds)
            ->whereIn('classes_id', $classIds)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->mapWithKeys(fn($r) => ["{$r->student_id}-" . Carbon::parse($r->date)->day => $r->attendance]);

        // 5. Approved leaves
        $leaves = Leave::whereIn('student_id', $studentIds)
            ->where('is_approved', 1)
            ->where(function ($q) use ($year, $month) {
                $q->whereMonth('from_date', $month)->whereYear('from_date', $year)
                ->orWhereMonth('to_date', $month)->whereYear('to_date', $year);
            })
            ->get();

        $leaveDays = [];
        foreach ($leaves as $leave) {
            $from = Carbon::parse($leave->from_date)->max($startOfMonth);
            $to   = Carbon::parse($leave->to_date)->min($startOfMonth->copy()->endOfMonth());

            for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
                if ($d->month == $month) {
                    $leaveDays[$leave->student_id][$d->day] = true;
                }
            }
        }

        if ($tab === 'semester') {

            $summary = [];

            foreach ($students as $student) {
                $studentId = $student->id;

                // 1. Excused (approved leaves)
                $excusedCount = isset($leaveDays[$studentId]) ? count($leaveDays[$studentId]) : 0;

                // 2. Late count – now correctly checks for value 2
                $lateCount = 0;
                for ($day = 1; $day <= $maxDay; $day++) {
                    $key = "{$studentId}-{$day}";
                    if (isset($attendanceRecords[$key]) && $attendanceRecords[$key] == 2) {
                        $lateCount++;
                    }
                }

                // 3. Not Counted = no attendance record AND not on leave
                $notCounted = 0;
                for ($day = 1; $day <= $maxDay; $day++) {
                    $key = "{$studentId}-{$day}";
                    $hasAttendance = isset($attendanceRecords[$key]);
                    $onLeave = isset($leaveDays[$studentId][$day]);

                    if (!$hasAttendance && !$onLeave) {
                        $notCounted++;
                    }
                }

                $summary[] = [
                    'student'     => $student,
                    'excused'     => $excusedCount,
                    'late'        => $lateCount,
                    'not_counted' => $notCounted,
                ];
            }

            $html = view('staff.report.attendance.partials.semester-total', ['summary' => $summary])->render();

        }else{

            // Render Blade view
            $html = view('staff.report.attendance.partials.month-wise-table', [
                'students'          => $students,
                'maxDay'            => $maxDay,
                'attendanceRecords' => $attendanceRecords,
                'leaveDays'         => $leaveDays,
            ])->render();

        }
        

        return response()->json(['html' => $html]);
    }



}