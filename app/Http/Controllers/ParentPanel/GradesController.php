<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class GradesController extends Controller
{
  

    public function index(Request $request)
    {

        $perPage = $request->get('perPage', 5);
        $student = Student::where('parent_guardian_id', Auth::id())->firstOrFail();
        $id = $student->id;

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $selectedSubjects = $request->get('subjects', ['all']);

        // Attendance query
        $query = DB::table('attendances')
            ->join('classes', 'attendances.classes_id', '=', 'classes.id')
            ->join('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->where('attendances.student_id', $id)
            ->whereMonth('attendances.date', $month)
            ->whereYear('attendances.date', $year)
            ->select(
                'attendances.date',
                'attendances.attendance',
                'subjects.id as subject_id',
                'subjects.name as subject_name'
            );

        if (!in_array('all', $selectedSubjects)) {
            $query->whereIn('subjects.id', $selectedSubjects);
        }

        $attendances = $query->get();

        // Subject list for filter
        $subjects = DB::table('student_class_mapping')
            ->where('student_id', $id)
            ->leftJoin('classes', 'student_class_mapping.class_id', '=', 'classes.id')
            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->select('subjects.id', 'subjects.name')
            ->distinct()
            ->get();

        // Map attendance by date + subject_id
        $attendanceData = [];
        foreach ($attendances as $a) {
            $attendanceData[$a->date][$a->subject_id] = match ((int) $a->attendance) {
                1 => 'present',
                2 => 'late',
                3 => 'absent',
                4 => 'half_day',
                default => null,
            };
        }

        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Shabbos'];
        $student = Student::where('parent_guardian_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $query = DB::table('grades')
            ->leftJoin('classes', 'grades.classes_id', '=', 'classes.id')
            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->select(
                'grades.*',
                'classes.name as class_name',
                'subjects.name as subject_name'
            )
            ->where('grades.student_id', $student->id)
            ->orderBy('grades.created_at', 'desc');

        if ($request->filled('school_years_id')) {
            $query->where('grades.school_years_id', $request->school_years_id);
        }

        if ($request->filled('semester_id')) {
            $query->where('grades.semester_id', $request->semester_id);
        }

        $grades = $query->paginate($perPage);

        foreach ($grades as $grade) {
            $classId = $grade->classes_id;
            $studentId = $student->id;

            $attendanceSummary = DB::table('attendances')
                ->select(
                    DB::raw("SUM(CASE WHEN attendance = 1 THEN 1 ELSE 0 END) as total_present"),
                    DB::raw("SUM(CASE WHEN attendance = 2 THEN 1 ELSE 0 END) as total_late"),
                    DB::raw("SUM(CASE WHEN attendance = 3 THEN 1 ELSE 0 END) as total_absent"),
                    DB::raw("SUM(CASE WHEN attendance = 4 THEN 1 ELSE 0 END) as total_halfday")
                )
                ->where('student_id', $studentId)
                ->where('classes_id', $classId)
                ->first();

            $approvedLeaves = DB::table('leaves')
                ->where('student_id', $studentId)
                ->where('classes_id', $classId)
                ->where('is_approved', 1)
                ->get();

            $approvedLeaveDays = 0;
            foreach ($approvedLeaves as $leave) {
                $days = \Carbon\Carbon::parse($leave->from_date)->diffInDays(\Carbon\Carbon::parse($leave->to_date)) + 1;
                $approvedLeaveDays += $days;
            }

            $points = 0;
            // $points += ($attendanceSummary->total_present ?? 0) * 1;  
            $points += ($attendanceSummary->total_late ?? 0) * 2;
            $points += ($attendanceSummary->total_halfday ?? 0) * 4;
            $points += ($attendanceSummary->total_absent ?? 0) * 6;
            // $points += $approvedLeaveDays * 1;

            $marksGrade = DB::table('marks_grades')
                ->where('student_id', $studentId)
                ->where('classes_id', $classId)
                ->value('point');

            $calculatedPoints = ($marksGrade ?? 0) - $points;

            $percentage = 0;
            $percentage = round(($calculatedPoints / 100) * 100, 2);

            $result = $percentage < 59 ? 'Fail' : 'Pass';

            $grade->attendance_summary = [
                'present' => $attendanceSummary->total_present ?? 0,
                'late' => $attendanceSummary->total_late ?? 0,
                'absent' => $attendanceSummary->total_absent ?? 0,
                'half_day' => $attendanceSummary->total_halfday ?? 0,
                'approved_leave_days' => $approvedLeaveDays,
                'attendance_points' => $points,
                'marks_points' => $marksGrade ?? 0,
                'final_points' => $calculatedPoints,
                'percentage' => $percentage,
                'result' => $result,
            ];
        }

        // dd($grades);
        return view('parent-panel.grades', [
            'grades' => $grades,
            'yearOptions' => DB::table('sessions')->pluck('name', 'id')->toArray(),
            'semesterOptions' => DB::table('semesters')->pluck('name', 'id')->toArray(),
            'selectedYear' => $request->school_years_id,
            'selectedSemester' => $request->semester_id,
            'perPage' => $perPage,
        ]);
    }

   
}
