<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classes;
use App\Models\Academic\Semester;
use App\Models\Academic\Subject;
use App\Models\Academic\YearStatus;
use App\Models\Attendance\Attendance;
use App\Models\Examination\ExamType;
use App\Models\Examination\Grade;
use App\Models\Examination\GradeMap;
use App\Models\Session;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GradeReportController extends Controller{

    public function allGrade(){

        $teacherId = Auth::user()->staff->id;
        $assignedClassIds = StudentClassMapping::where('teacher_id', $teacherId)->distinct()->pluck('class_id');
        $classes = Classes::whereIn('id', $assignedClassIds)->get();
        $subjects = Subject::get();
        $years = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderByDesc('id')->get();
        $semesters = Semester::orderByDesc('id')->get();
        $examTypes = ExamType::get();

        return view('staff.report.grade.all_grades', compact(
            'classes',
            'subjects',
            'years',
            'yearStatuses',
            'semesters',
            'examTypes'
        ));

    }

    
    public function allGradeSearch(Request $request)
    {
        $request->validate([
            'year_id'        => 'required|exists:sessions,id',
            'class_id'       => 'required|exists:classes,id',
            'year_status_id' => 'nullable|exists:year_status,id',
            'subject_id'     => 'nullable|exists:subjects,id',
        ]);

        $yearId        = $request->year_id;
        $semesterId    = $request->semester_id;
        $classId       = $request->class_id;
        $yearStatusId  = $request->year_status_id;
        $teacherId = Auth::user()->staff->id;

        // Check if "Full Year" option is selected
        if ($semesterId === 'all') {
            // Handle Full Year logic - Return full_year_grade_list view
            return $this->handleFullYearGrades($yearId, $classId, $yearStatusId, $teacherId);
        } else {
            // Original logic for regular semester selection
            return $this->handleSemesterGrades($yearId, $semesterId, $classId, $yearStatusId, $teacherId);
        }

    }

    private function handleFullYearGrades($yearId, $classId, $yearStatusId, $teacherId)
    {
       
        return view('staff.report.grade.partials.full_year_grade_list')->render();
    }


    private function handleSemesterGrades($yearId, $semesterId, $classId, $yearStatusId, $teacherId)
    {
        // Step 1: Get active students in this class (status = 1)
        $mappings = DB::table('student_class_mapping')
            ->where('class_id', $classId)
            ->where('status', 1)
            ->where('teacher_id', $teacherId)
            ->select('student_id')
            ->distinct()
            ->get();

        if ($mappings->isEmpty()) {
            return '<div class="text-center p-4 text-muted">No active students found in this class for the selected year.</div>';
        }

        $studentIds = $mappings->pluck('student_id')->toArray();

        // Load students with user relation
        $students = Student::with('user')
            ->whereIn('id', $studentIds)
            ->get();

        if ($students->isEmpty()) {
            return '<div class="text-center p-4 text-muted">No student details found.</div>';
        }

        // Total school days in selected session + semester
        $totalDays = Attendance::whereIn('student_id', $studentIds)
            ->where('session_id', $yearId)
            ->where('semester_id', $semesterId)
            ->where('is_approved', 1)
            ->distinct('date')
            ->count('date');

        // Attendance stats per student
        $attendanceStats = [];
        foreach ($studentIds as $sid) {
            $attendanceStats[$sid] = [
                'total_days'  => $totalDays,
                'personal'    => 0,
                'excused'     => 0,
                'not_counted' => 0,
            ];
        }

        $rawStats = Attendance::whereIn('student_id', $studentIds)
            ->where('session_id', $yearId)
            ->where('semester_id', $semesterId)
            ->where('is_approved', 1)
            ->select('student_id', 'attendance_type', DB::raw('COUNT(*) as total'))
            ->groupBy('student_id', 'attendance_type')
            ->get();

        foreach ($rawStats as $row) {
            $type = $row->attendance_type;
            if (in_array($type, [3, 4])) {           // P and P*
                $attendanceStats[$row->student_id]['personal'] += $row->total;
            } elseif ($type == 1) {                  // E
                $attendanceStats[$row->student_id]['excused'] += $row->total;
            } elseif ($type == 2) {                  // NC
                $attendanceStats[$row->student_id]['not_counted'] += $row->total;
            }
        }

        return view('staff.report.grade.partials.all_grade_list', [
            'students'        => $students,
            'attendanceStats' => $attendanceStats,
        ])->render();
    }


    public function failingGrade()
    {
        $years        = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderByDesc('id')->get();
        $semesters    = Semester::orderByDesc('id')->get();

        return view('staff.report.grade.failing_grades', compact(
            'years',
            'yearStatuses',
            'semesters'
        ));
    }


    public function failingGradeSearch(Request $request)
    {
        $request->validate([
            'year_id'         => 'required|exists:sessions,id',
            'year_status_id'  => 'nullable|exists:year_status,id',
            'semester_id'     => 'required|exists:semesters,id',
        ]);

        $teacherId = Auth::user()->staff->id;

        // 1. Get all students this teacher teaches
        $teacherStudentIds = StudentClassMapping::where('teacher_id', $teacherId)
            ->pluck('student_id')
            ->unique();

        if ($teacherStudentIds->isEmpty()) {
            return view('staff.report.grade.partials.failing_grade_list', ['grouped' => collect()]);
        }

        // 2. Get failing grades (percentage < 60) from grades table
        $failings = Grade::whereIn('student_id', $teacherStudentIds)
            ->where('session_id', $request->year_id)           // school year
            ->where('semester_id', $request->semester_id)
            ->when($request->filled('year_status_id'), function ($q) use ($request) {
                return $q->where('session_id', $request->year_status_id); // if you use it
            })
            ->where('percentage', '<', 60)  // Failing = less than 60%
            ->with(['student.user', 'class']) // load class to get subject name
            ->orderBy('classes_id')
            ->get();

        // 3. Group only by classes_id (since subject is inside class)
        $grouped = $failings->groupBy('classes_id')->map(function ($classGrades) {
            $first = $classGrades->first();
            $class = $first->class; // this has subject name

            $subjectName = $class->subject?->name 
                ?? $class->subject_name 
                ?? $class->name 
                ?? 'Unknown Subject';

            $className = $class->name ?? 'Unknown Class';

            return [
                'class_name'    => $className,
                'subject_name'  => $subjectName,
                'full_name'     => $className . ' - ' . $subjectName,
                'students'      => $classGrades->map(fn($g) => [
                    'student_name' => $g->student?->user?->name ?? 'Unknown Student',
                    'percentage'   => number_format($g->percentage, 1) . '%',
                    'report_card'  => $g->report_card ? 'Yes' : 'No',
                    'transcript'   => $g->transcript ? 'Yes' : 'No',
                ])->toArray()
            ];
        })->values();

        return view('staff.report.grade.partials.failing_grade_list', compact('grouped'));
    }

    
    public function missingGrade(){

        $years = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderByDesc('id')->get();
        $semesters = Semester::orderByDesc('id')->get();

        return view('staff.report.grade.missing_grades', compact(
            'years',
            'yearStatuses',
            'semesters'
        ));

    }

    
    public function missingGradeSearch(Request $request)
    {
        $request->validate([
            'year_id'        => 'required|exists:sessions,id',
            'year_status_id' => 'nullable|exists:year_status,id',
            'semester_id'    => 'required|exists:semesters,id',
            'page'           => 'nullable|integer|min:1',
            'per_page'       => 'nullable|integer|in:1,2,3,4', // Match options in pagination blade
        ]);

        $teacherId     = Auth::user()->staff->id;
        $yearId        = $request->year_id;
        $semesterId    = $request->semester_id;
        $yearStatusId  = $request->year_status_id;
        $page          = $request->input('page', 1);
        $perPage       = $request->input('per_page', 1); // Default to 1, as per your pagination blade options

        // 1. Get all active class-subject combinations this teacher is assigned to
        $assignedMappings = StudentClassMapping::where('teacher_id', $teacherId)
            ->where('status', 1)
            ->select('class_id', 'student_id')
            ->distinct()
            ->get();

        if ($assignedMappings->isEmpty()) {
            $missing = collect();
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator($missing, 0, $perPage, $page);
            return view('staff.report.grade.partials.missing_grade_list', [
                'missing' => $missing,
                'paginator' => $paginator,
                'routeName' => 'staff.report.grade.missing-grade.search',
            ])->render();
        }

        $classIds    = $assignedMappings->pluck('class_id')->unique();
        $studentIds  = $assignedMappings->pluck('student_id')->unique();

        // 2. Get all students in those classes (active ones)
        $students = Student::with('user')
            ->whereIn('id', $studentIds)
            ->get()
            ->keyBy('id');

        // 3. Get all existing grades for this teacher’s students in selected year + semester
        $existingGrades = Grade::whereIn('student_id', $studentIds)
            ->where('session_id', $yearId)
            ->where('semester_id', $semesterId)
            ->when($yearStatusId, function ($q) use ($yearStatusId) {
                return $q->where('year_status_id', $yearStatusId);
            })
            ->get()
            ->groupBy('classes_id')
            ->map(function ($group) {
                return $group->pluck('student_id')->toArray();
            });

        // 4. Build expected missing combinations
        $expected = [];
        foreach ($assignedMappings as $map) {
            $classId   = $map->class_id;
            $studentId = $map->student_id;

            $gradedStudents = $existingGrades->get($classId, []);
            if (!in_array($studentId, $gradedStudents)) {
                $expected[] = [
                    'student_id' => $studentId,
                    'class_id'   => $classId,
                ];
            }
        }

        if (empty($expected)) {
            $missing = collect();
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator($missing, 0, $perPage, $page);
            return view('staff.report.grade.partials.missing_grade_list', [
                'missing' => $missing,
                'paginator' => $paginator,
                'routeName' => 'staff.report.grade.missing-grade.search',
            ])->render();
        }

        // 5. Load class details (with subject) once
        $classIdsNeeded = collect($expected)->pluck('class_id')->unique();
        $classes = Classes::with('subject')->whereIn('id', $classIdsNeeded)->get()->keyBy('id');

        // 6. Build the missing collection
        $missingCollection = collect($expected)->map(function ($item) use ($students, $classes) {
            $student = $students->get($item['student_id']);
            $class   = $classes->get($item['class_id']);

            if (!$student || !$class) return null;

            return [
                'student_name' => $student->user?->name ?? 'Unknown Student',
                'class_name'   => $class->name ?? 'Unknown Class',
                'subject_name' => $class->subject?->name ?? 'Unknown Subject',
                'full_name'    => ($class->name ?? 'Unknown') . ' - ' . ($class->subject?->name ?? 'Unknown'),
            ];
        })->filter()->sortBy('full_name');

        // 7. Paginate the collection
        $total = $missingCollection->count();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $missingCollection->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => route('staff.report.grade.missing-grade.search')]
        );

        // 8. Render the partial view
        return view('staff.report.grade.partials.missing_grade_list', [
            'missing' => $missingCollection->forPage($page, $perPage)->values(),
            'paginator' => $paginator,
            'routeName' => 'staff.report.grade.missing-grade.search',
        ])->render();
    }

    


}