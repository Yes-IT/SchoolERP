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

class AttendanceReportController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->staff->id;

        $assignedClassIds = StudentClassMapping::where('teacher_id', $teacherId)
            ->distinct()
            ->pluck('class_id');

        $classes = Classes::whereIn('id', $assignedClassIds)
            ->with('subject') 
            ->get();

        $subjectIds = $classes->pluck('subject_id')->unique();

        $subjects = Subject::whereIn('id', $subjectIds)->get();

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
            ->where('teacher_id', Auth::user()->staff->id)
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

            // Get subject information for late counting rules
            $subjects = Subject::whereIn('id', $classIds)->get();
            
            // Get classes with their subjects
            $classesWithSubjects = Classes::whereIn('id', $classIds)
                ->with('subject')
                ->get()
                ->keyBy('id');

            foreach ($students as $student) {
                $studentId = $student->id;
                $lateCounts = []; // Track late counts per class/subject
                $absencesFromLate = []; // Track absences from excessive lates per class/subject

                // Initialize late counts for each class
                foreach ($classIds as $classId) {
                    $lateCounts[$classId] = 0;
                    $absencesFromLate[$classId] = 0;
                }

                // 1. Process attendance records for late counting and absences
                $absentCount = 0;
                for ($day = 1; $day <= $maxDay; $day++) {
                    $key = "{$studentId}-{$day}";
                    $attendance = $attendanceRecords[$key] ?? null;
                    
                    // Check if this day has attendance for any of the selected classes
                    $hasAttendanceForDay = false;
                    $lateForDay = 0;

                    foreach ($classIds as $classId) {
                        $attendanceKey = "{$studentId}-{$day}-{$classId}";
                        $specificAttendance = $attendanceRecords[$attendanceKey] ?? null;
                        
                        if ($specificAttendance !== null) {
                            $hasAttendanceForDay = true;
                            
                            // Count direct absences (attendance = 3)
                            if ($specificAttendance == 3) {
                                $absentCount++;
                            }
                            
                            // Count lates (attendance = 2)
                            if ($specificAttendance == 2) {
                                $lateCounts[$classId]++;
                                $lateForDay++;
                            }
                        }
                    }

                    // If no attendance record for the day and not on leave, count as not counted
                    if (!$hasAttendanceForDay && !isset($leaveDays[$studentId][$day])) {
                        // You might want to count this as absent or handle differently
                        // For now, we'll just track it as not counted
                    }
                }

                // 2. Calculate absences from excessive lates per subject/class
                foreach ($classIds as $classId) {
                    $subject = $classesWithSubjects[$classId]->subject ?? null;
                    if ($subject && isset($lateCounts[$classId])) {
                        $numberLatenessesEqualAbsence = (int) $subject->number_latenesses_equal_absence;
                        
                        if ($numberLatenessesEqualAbsence > 0) {
                            $absencesFromLates = floor($lateCounts[$classId] / $numberLatenessesEqualAbsence);
                            $absencesFromLate[$classId] = $absencesFromLates;
                            $absentCount += $absencesFromLates;
                        }
                    }
                }

                // 3. Excused (approved leaves)
                $excusedCount = isset($leaveDays[$studentId]) ? count($leaveDays[$studentId]) : 0;

                // 4. Total late count (across all classes)
                $totalLateCount = array_sum($lateCounts);

                // 5. Not Counted = no attendance record AND not on leave
                $notCounted = 0;
                for ($day = 1; $day <= $maxDay; $day++) {
                    $key = "{$studentId}-{$day}";
                    $hasAttendance = isset($attendanceRecords[$key]);
                    $onLeave = isset($leaveDays[$studentId][$day]);

                    if (!$hasAttendance && !$onLeave) {
                        $notCounted++;
                    }
                }

                // 6. Calculate percentages and points (assuming points are absences for now)
                $totalPossibleDays = $maxDay;
                $totalAbsences = $absentCount; // Direct absences + absences from lates
                $attendancePercentage = $totalPossibleDays > 0 ? 
                    round((($totalPossibleDays - $totalAbsences) / $totalPossibleDays) * 100, 2) : 0;

                $summary[] = [
                    'student'                 => $student,
                    'excused'                 => $excusedCount,
                    'late'                    => $totalLateCount,
                    'absences_direct'         => $absentCount - array_sum($absencesFromLate), // Only direct absences
                    'absences_from_late'      => array_sum($absencesFromLate), // Absences from excessive lates
                    'total_absences'          => $totalAbsences,
                    'not_counted'             => $notCounted,
                    'attendance_percentage'   => $attendancePercentage,
                    'points'                  => $totalAbsences, // Points as absences for now
                    'late_details'            => $lateCounts, // Per class late counts
                    'absences_from_late_details' => $absencesFromLate, // Per class late-based absences
                ];
            }

            $html = view('staff.report.attendance.partials.semester-total', [
                'summary' => $summary,
                'maxDay' => $maxDay
            ])->render();

        } else {
            // Render Blade view for month-wise
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