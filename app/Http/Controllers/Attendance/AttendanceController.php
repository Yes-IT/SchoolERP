<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\AttendanceReportRequest;
use App\Http\Requests\Attendance\AttendanceSearchRequest;
use App\Http\Requests\Attendance\AttendanceStoreRequest;
use App\Models\Academic\SchoolYear;
use App\Models\Academic\Semester;
use App\Models\Academic\Subject;
use App\Models\Academic\YearStatus;
use App\Models\Academic\Classes;
use App\Http\Requests\Report\AttendanceRequest;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Attendance\AttendanceRepository;
use Illuminate\Http\Request;
use PDF;
use App\Models\Attendance\Attendance;
use App\Models\Leave;
use App\Models\Session;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use DB;

class AttendanceController extends Controller
{
    private $repo;
    private $classRepo;
    private $classSetupRepo;

    function __construct(
        AttendanceRepository   $repo,
        ClassesRepository      $classRepo,
        ClassSetupRepository   $classSetupRepo,
    ) {
        $this->repo              = $repo;
        $this->classRepo         = $classRepo;
        $this->classSetupRepo    = $classSetupRepo;
    }


    // Daily Attendance Functions Start Here----------------------------------------------------------------------------------------------

    public function dailyAttendance()
    {
        $query = Attendance::leftJoin('students', 'attendances.student_id', 'students.id')
            ->leftJoin('class_schedules', 'class_schedules.class_id', 'attendances.classes_id')
            ->select(
                'attendances.id',
                'attendances.attendance',
                'students.student_id',
                'students.first_name',
                'students.last_name',
                'class_schedules.start_time'
            );

        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = Session::all();
        $subjects = Subject::all();
        $data['attendance'] = $query->paginate(10);

        return view('backend.attendance.index', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
            'data'
        ));

    }
    

    public function searchDaily(Request $request)
    {
        // -----------------------------------------------------------------
        // 1. Build Attendance query – start with attendances table
        // -----------------------------------------------------------------
        $query = Attendance::query()
            ->leftJoin('class_schedules', 'class_schedules.class_id', '=', 'attendances.classes_id')
            ->leftJoin('students', 'students.id', '=', 'attendances.student_id')
            ->select(
                'attendances.id',
                'attendances.student_id',
                'attendances.attendance',
                'attendances.is_approved as attendance_approved',
                'attendances.approved_date as attendance_approved_date',
                'attendances.date',
                'class_schedules.start_time',
                'students.student_id as student_code',
                'students.first_name',
                'students.last_name'
            );

        // -----------------------------------------------------------------
        // 2. Apply filters directly on attendances table
        // -----------------------------------------------------------------
        if ($request->filled('school_year')) {
            $query->where('attendances.session_id', $request->school_year);
        }

        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }

        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }

        if ($request->filled('class_id')) {
            $query->where('attendances.classes_id', $request->class_id);
        }

        // Subject filter: ignore for now (you will add later)
        // if ($request->filled('subject_id')) { ... }

        // -----------------------------------------------------------------
        // 3. Date filter – single date
        // -----------------------------------------------------------------
        if ($request->filled('date')) {
            $query->whereDate('attendances.date', $request->date);
        }

        // -----------------------------------------------------------------
        // 4. Pagination
        // -----------------------------------------------------------------
        $perPage = $request->input('per_page', 10);
        $attendance = $query->paginate($perPage);

        // -----------------------------------------------------------------
        // 5. Get student IDs from paginated results
        // -----------------------------------------------------------------
        $studentIds = $attendance->pluck('student_id')->filter()->unique()->values();

        // -----------------------------------------------------------------
        // 6. Load approved/rejected leaves for the same date
        // -----------------------------------------------------------------
        $leaves = collect();
        if ($studentIds->isNotEmpty() && $request->filled('date')) {
            $leaves = Leave::whereIn('student_id', $studentIds)
                ->whereDate('from_date', '<=', $request->date)
                ->whereDate('to_date',   '>=', $request->date)
                ->whereIn('is_approved', [0, 1]) // 0 = rejected, 1 = approved
                ->get()
                ->keyBy('student_id');
        }

        // -----------------------------------------------------------------
        // 7. Attach leave status to each row
        // -----------------------------------------------------------------
        $attendance->getCollection()->transform(function ($item) use ($leaves) {
            $leave = $leaves->get($item->student_id);

            $item->leave_status         = $leave->is_approved ?? null; // 1, 0, or null
            $item->leave_approved_date  = $leave->approved_date ?? null;

            return $item;
        });

        // -----------------------------------------------------------------
        // 8. Return JSON for AJAX
        // -----------------------------------------------------------------
        return response()->json([
            'data' => view('backend.attendance.partials.daily_attendance_list', [
                'attendance' => $attendance
            ])->render(),
            'pagination' => (string) $attendance->links('backend.partials.pagination', ['routeName' => 'daily.index'])
        ]);
    }

    // Monthly Attendance Functions Start Here----------------------------------------------------------------------------------------------
    
    public function monthlyAttendance()
    {
        $month = now()->month;
        $year = now()->year;

        $query = Student::select(
            'students.id',
            'students.student_id as student_code',
            'students.first_name',
            'students.last_name'
        )
        ->join('attendances', 'students.id', '=', 'attendances.student_id')
        ->whereMonth('attendances.date', $month)
        ->whereYear('attendances.date', $year)
        ->distinct();

        if (request()->filled('school_year')) {
            $query->where('attendances.session_id', request()->school_year);
        }

        if (request()->filled('year_status')) {
            $query->where('attendances.year_status_id', request()->year_status);
        }

        if (request()->filled('semester')) {
            $query->where('attendances.semester_id', request()->semester);
        }

        if (request()->filled('class_id')) {
            $query->where('attendances.classes_id', request()->class_id);
        }

        if (request()->filled('subject_id') && !in_array('all', request()->subject_id)) {
            $query->whereIn('attendances.subject_id', request()->subject_id);
        }

        $perPage = request()->input('per_page', 10);
        $students = $query->orderBy('students.last_name')->paginate($perPage);

        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();
        $subjects = Subject::all();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $data['students'] = $students;

        return view('backend.attendance.monthly_attendance', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
            'data',
            'daysInMonth',
            'month',
            'year'
        ));
    }


    public function searchMonthly(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $query = Student::select(
            'students.id',
            'students.student_id as student_code',
            'students.first_name',
            'students.last_name'
        )
        ->join('attendances', 'students.id', '=', 'attendances.student_id')
        ->whereMonth('attendances.date', $month)
        ->whereYear('attendances.date', $year)
        ->distinct();

        if ($request->filled('school_year')) {
            $query->where('attendances.session_id', $request->school_year);
        }

        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }

        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }

        if ($request->filled('class_id')) {
            $query->where('attendances.classes_id', $request->class_id);
        }

        if ($request->filled('subject_id') && !in_array('all', $request->subject_id)) {
            $query->whereIn('attendances.subject_id', $request->subject_id);
        }

        $perPage = $request->input('per_page', 10);
        $students = $query->orderBy('students.last_name')->paginate($perPage);

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        return response()->json([
            'data' => view('backend.attendance.partials.monthly_attendance_list', [
                'data' => ['students' => $students],
                'daysInMonth' => $daysInMonth,
                'month' => $month,
                'year' => $year
            ])->render(),
            'pagination' => (string) $students->links('backend.partials.pagination', ['routeName' => 'monthly.index'])
        ]);
    }

    // Total Attendance Functions Start Here----------------------------------------------------------------------------------------------
    
    public function totalAttendance()
    {
        $query = Student::select(
            'students.id',
            'students.student_id as student_code',
            'students.first_name',
            'students.last_name',
            DB::raw('SUM(CASE WHEN attendances.attendance = "1" THEN 1 ELSE 0 END) as excused_count'),
            DB::raw('SUM(CASE WHEN attendances.attendance = "3" THEN 1 ELSE 0 END) as late_count'),
            DB::raw('SUM(CASE WHEN attendances.attendance = "2" THEN 1 ELSE 0 END) as personal_count'),
            DB::raw('SUM(CASE WHEN attendances.attendance = "4" THEN 1 ELSE 0 END) as not_counted'),
            DB::raw('COUNT(CASE WHEN attendances.attendance = "0" THEN 1 END) as present_count'),
            DB::raw('COUNT(attendances.id) as total_classes'),
            DB::raw('ROUND((COUNT(CASE WHEN attendances.attendance = "0" THEN 1 END) / NULLIF(COUNT(attendances.id), 0)) * 100, 2) as attendance_percentage'),
            DB::raw('COUNT(CASE WHEN attendances.attendance = "0" THEN 1 END) as points')
        )
        ->leftJoin('attendances', 'students.id', '=', 'attendances.student_id')
        ->groupBy('students.id', 'students.student_id', 'students.first_name', 'students.last_name');

        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();
        $subjects = Subject::all();
        $students = Student::all(); // For the student dropdown
        $data['students'] = $query->orderBy('students.last_name')->paginate(10);

        return view('backend.attendance.total_attendance', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
            'students',
            'data'
        ));
    }


    public function searchTotal(Request $request)
    {
        $query = Student::select(
            'students.id',
            'students.student_id as student_code',
            'students.first_name',
            'students.last_name',
            DB::raw('SUM(CASE WHEN attendances.attendance = "1" THEN 1 ELSE 0 END) as excused_count'),
            DB::raw('SUM(CASE WHEN attendances.attendance = "3" THEN 1 ELSE 0 END) as late_count'),
            DB::raw('SUM(CASE WHEN attendances.attendance = "2" THEN 1 ELSE 0 END) as personal_count'),
            DB::raw('SUM(CASE WHEN attendances.attendance = "4" THEN 1 ELSE 0 END) as not_counted'),
            DB::raw('COUNT(CASE WHEN attendances.attendance = "0" THEN 1 END) as present_count'),
            DB::raw('COUNT(attendances.id) as total_classes'),
            DB::raw('ROUND((COUNT(CASE WHEN attendances.attendance = "0" THEN 1 END) / NULLIF(COUNT(attendances.id), 0)) * 100, 2) as attendance_percentage'),
            DB::raw('COUNT(CASE WHEN attendances.attendance = "0" THEN 1 END) as points')
        )
        ->leftJoin('attendances', 'students.id', '=', 'attendances.student_id')
        ->groupBy('students.id', 'students.student_id', 'students.first_name', 'students.last_name');

        // Apply filters
        if ($request->filled('school_year')) {
            $query->where('attendances.session_id', $request->school_year);
        }

        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }

        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }

        if ($request->filled('class_id')) {
            $query->where('attendances.classes_id', $request->class_id);
        }

        if ($request->filled('subject_id') && !in_array('all', $request->subject_id)) {
            $query->whereIn('attendances.subject_id', $request->subject_id);
        }

        if ($request->filled('student_id')) {
            $query->where('students.id', $request->student_id);
        }

        $perPage = $request->input('per_page', 10);
        $filteredStudents = $query->orderBy('students.last_name')->paginate($perPage);
        $allStudents = Student::all(); // For the student dropdown

        return response()->json([
            'data' => view('backend.attendance.partials.total_attendance_list', [
                'data' => ['students' => $filteredStudents],
                'students' => $allStudents
            ])->render(),
            'pagination' => (string) $filteredStudents->links('backend.partials.pagination', ['routeName' => 'total.index'])
        ]);
    }


    // Attendance Submission Tracker Functions Start Here----------------------------------------------------------------------------------------------

    public function submissionTracker(Request $request)
    {
        // Fetch all class records with related staff and subject
        $classes = Classes::with(['staff', 'subject'])
            ->paginate(10); // pagination (change number if needed)

        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();
        $subjects = Subject::all();

        // Loop through each class to check attendance submission
        foreach ($classes as $class) {
            $attendance = Attendance::where('classes_id', $class->id)->latest()->first();

            $class->attendance_status = $attendance ? 'Submitted' : 'Pending';
            $class->attendance_time = $attendance ? $attendance->created_at : null;
        }

        return view('backend.attendance.submission_tracker', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects'
        ));
    }


    public function submissionTrackerSearch(){
    }


    //Report Functions Start Here----------------------------------------------------------------------------------------------

    public function studentReport()
    {
        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = Session::all();
        $subjects = Subject::all();
        $students = Student::all();

        return view('backend.attendance.report_student_attendance', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
            'students'
        ));
    }

    public function studentReportSearch(Request $request)
    {
        $tab = $request->input('tab', 'attendance');

        // -----------------------------------------------------------------
        // 1. Base Query – common filters for both tabs
        // -----------------------------------------------------------------
        $query = Attendance::query()
            ->leftJoin('students', 'attendances.student_id', '=', 'students.id')
            ->leftJoin('classes', 'attendances.classes_id', '=', 'classes.id');

        // Apply all filters
        if ($request->filled('class_id')) {
            $query->where('attendances.classes_id', $request->class_id);
        }
        if ($request->filled('school_year')) {
            $query->where('attendances.session_id', $request->school_year);
        }
        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }
        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }
        if ($request->filled('student_id')) {
            $query->where('attendances.student_id', $request->student_id);
        }

        // -----------------------------------------------------------------
        // 2. TAB: SUMMARY – Group by class + count types
        // -----------------------------------------------------------------
        if ($tab === 'summary') {

            $summary = (clone $query)
                ->leftJoin('attendance_type', 'attendances.attendance_type', '=', 'attendance_type.id')
                ->selectRaw('
                    classes.id      AS class_id,
                    classes.name    AS class_name,

                    COUNT(CASE WHEN attendance_type.id = 1 THEN 1 END) AS excused,        -- E
                    COUNT(CASE WHEN attendances.late_time IS NOT NULL THEN 1 END) AS late,
                    COUNT(CASE WHEN attendance_type.id IN (3,4) THEN 1 END) AS personal,  -- P, P*
                    COUNT(CASE WHEN attendance_type.id = 2 THEN 1 END) AS not_counted     -- NC
                ')
                ->groupBy('classes.id', 'classes.name')
                ->orderBy('classes.name');

            $perPage = $request->input('per_page', 10);
            $summary = $summary->paginate($perPage);

            return response()->json([
                'data' => view('backend.attendance.partials.student_report_summary_list', [
                    'summary' => $summary
                ])->render(),
                'pagination' => (string) $summary->links('backend.partials.pagination', [
                    'routeName' => 'student-report.index'
                ]),
            ]);
        }

        // -----------------------------------------------------------------
        // 3. TAB: ATTENDANCE – Detailed list with human-readable type
        // -----------------------------------------------------------------
        $attendance = (clone $query)
            ->leftJoin('attendance_type', 'attendances.attendance_type', '=', 'attendance_type.id')
            ->select(
                'attendances.id',
                'attendances.classes_id',
                'attendances.date',
                'attendances.attendance',        // comment
                'attendances.late_time',
                'students.student_id',
                'students.first_name',
                'students.last_name',
                'classes.name AS class_name',
                'attendance_type.type AS attendance_type_name'
            )
            ->orderBy('attendances.date', 'desc');

        $perPage = $request->input('per_page', 10);
        $attendance = $attendance->paginate($perPage);

        return response()->json([
            'data' => view('backend.attendance.partials.student_report_list', [
                'attendance' => $attendance
            ])->render(),
            'pagination' => (string) $attendance->links('backend.partials.pagination', [
                'routeName' => 'student-report.index'
            ]),
        ]);
    }


    public function classReport()
    {
        $classes      = Classes::orderBy('name')->get();
        $schoolYears  = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderBy('name')->get();
        $semesters    = Semester::orderBy('name')->get();

        return view('backend.attendance.report_class_attendance', compact(
            'classes', 'schoolYears', 'yearStatuses', 'semesters'
        ));
    }

    public function classReportSearch(Request $request)
    {
        $tab = $request->input('tab', 'attendance');

        // Base Query
        $query = Attendance::query()
            ->leftJoin('students', 'attendances.student_id', '=', 'students.id')
            ->leftJoin('classes', 'attendances.classes_id', '=', 'classes.id')
            ->leftJoin('attendance_type', 'attendances.attendance_type', '=', 'attendance_type.id');

        // Apply Filters
        if ($request->filled('class_id')) {
            $query->where('attendances.classes_id', $request->class_id);
        }
        if ($request->filled('school_year')) {
            $query->where('attendances.session_id', $request->school_year);
        }
        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }
        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }

        // TAB: SUMMARY
        if ($tab === 'summary') {
            $summary = (clone $query)
                ->selectRaw('
                    students.id,
                    CONCAT(students.first_name, " ", students.last_name) AS student_name,
                    COUNT(CASE WHEN attendance_type.id = 1 THEN 1 END) AS excused,
                    COUNT(CASE WHEN attendances.late_time IS NOT NULL THEN 1 END) AS late,
                    COUNT(CASE WHEN attendance_type.id IN (3,4) THEN 1 END) AS personal,
                    COUNT(CASE WHEN attendance_type.id = 2 THEN 1 END) AS not_counted
                ')
                ->groupBy('students.id', 'students.first_name', 'students.last_name')
                ->orderBy('student_name');

            $perPage = $request->input('per_page', 10);
            $summary = $summary->paginate($perPage);

            return response()->json([
                'data' => view('backend.attendance.partials.class_report_summary_list', [
                    'summary' => $summary
                ])->render(),
                'pagination' => (string) $summary->links('backend.partials.pagination', [
                    'routeName' => 'class-report.index'
                ]),
            ]);
        }

        // TAB: ATTENDANCE
        $attendance = (clone $query)
            ->select(
                'attendances.id',
                'attendances.date',
                'attendances.attendance AS comment',
                'attendances.late_time',
                 DB::raw('CONCAT(students.first_name, " ", students.last_name) AS student_name'),
                'attendance_type.type AS attendance_type_name'
            )
            ->orderBy('attendances.date', 'desc');

        $perPage = $request->input('per_page', 10);
        $attendance = $attendance->paginate($perPage);

        return response()->json([
            'data' => view('backend.attendance.partials.class_report_list', [
                'attendance' => $attendance
            ])->render(),
            'pagination' => (string) $attendance->links('backend.partials.pagination', [
                'routeName' => 'class-report.index'
            ]),
        ]);
    }


    public function studentAttendanceSummary(){
        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = Session::all();
        $subjects = Subject::all();
        $students = Student::all();

        return view('backend.attendance.student_attendance_summary', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
            'students',
        ));
    }

    public function studentAttendanceSummarySearch(Request $request)
    {
        $query = Attendance::query()
            ->leftJoin('students', 'attendances.student_id', '=', 'students.id')
            ->leftJoin('classes', 'attendances.classes_id', '=', 'classes.id')
            ->leftJoin('attendance_type', 'attendances.attendance_type', '=', 'attendance_type.id');

        if ($request->filled('school_year')) {
            $query->where('attendances.school_year_id', $request->school_year);
        }
        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }
        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }
        if ($request->filled('student_id')) {
            $query->where('attendances.student_id', $request->student_id);
        }

        $semesterName = 'All Semesters';
        if ($request->filled('semester')) {
            $semester = Semester::find($request->semester);
            $semesterName = $semester?->name ?? 'Unknown Semester';
        }

        $summary = (clone $query)
            ->selectRaw('
                classes.name AS class_name,
                COUNT(*) AS total_days,
                COUNT(CASE WHEN attendance_type.id = 1 THEN 1 END) AS excused,
                COUNT(CASE WHEN attendances.late_time IS NOT NULL THEN 1 END) AS late,
                COUNT(CASE WHEN attendance_type.id IN (3,4) THEN 1 END) AS personal
            ')
            ->groupBy('classes.id', 'classes.name')
            ->orderBy('classes.name');

        $perPage = $request->input('per_page', 10);
        $summary = $summary->paginate($perPage);

        $summary->getCollection()->transform(function ($row) {
            $total = $row->total_days;
            $counted = $row->excused + $row->late + $row->personal;
            $row->percentage = $total > 0 ? round(($counted / $total) * 100, 2) : 0;
            $row->points = '';
            return $row;
        });

        return response()->json([
            'data' => view('backend.attendance.partials.student_attendance_summary_list', [
                'summary' => $summary,
                'semesterName' => $semesterName
            ])->render(),
            'pagination' => (string) $summary->links('backend.partials.pagination', ['routeName' => 'student-attendance-summary.index']),
        ]);
    }

    public function excessiveAbsencesByStudent()
    {
        $schoolYears  = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderBy('name')->get();
        $semesters    = Semester::orderBy('name')->get();
        $students     = Student::select('id', 'first_name', 'last_name')
                            ->orderBy('first_name')
                            ->get();

        return view('backend.attendance.excessive_absences_by_student', compact(
            'schoolYears', 'yearStatuses', 'semesters', 'students'
        ));
    }

    public function excessiveAbsencesByStudentSearch(Request $request)
    {
        $query = Attendance::query()
            ->leftJoin('students', 'attendances.student_id', '=', 'students.id')
            ->leftJoin('attendance_type', 'attendances.attendance_type', '=', 'attendance_type.id') // Fixed table name
            ->selectRaw('
                students.id AS student_id,
                CONCAT(students.first_name, " ", students.last_name) AS student_name,
                COUNT(*) AS total_days,
                COUNT(CASE WHEN attendance_type.code = "P" THEN 1 END) AS personal_absences,
                COUNT(CASE WHEN attendance_type.code = "P*" THEN 1 END) AS p_star_absences
            ')
            ->groupBy('students.id', 'students.first_name', 'students.last_name');

        // Filters
        if ($request->filled('school_year')) {
            $query->where('attendances.session_id', $request->school_year);
        }
        if ($request->filled('year_status')) {
            $query->where('attendances.year_status_id', $request->year_status);
        }
        if ($request->filled('semester')) {
            $query->where('attendances.semester_id', $request->semester);
        }
        if ($request->filled('student_id')) {
            $query->where('attendances.student_id', $request->student_id);
        }

        // Only show students with at least one P or P*
        $query->havingRaw('(personal_absences + p_star_absences) > 0')
            ->orderByRaw('(personal_absences + p_star_absences) DESC');

        $perPage = $request->input('per_page', 10);
        $summary = $query->paginate($perPage);

        // Add percentage
        $summary->getCollection()->transform(function ($row) {
            $totalPersonal = $row->personal_absences + $row->p_star_absences;
            $row->total_personal = $totalPersonal;
            $row->percentage = $row->total_days > 0 
                ? round(($totalPersonal / $row->total_days) * 100, 2) 
                : 0;
            return $row;
        });

        $html = view('backend.attendance.partials.excessive_absences_by_student_list', [
            'summary' => $summary
        ])->render();

        return response()->json([
            'html' => $html   // ← We send ONE HTML block
        ]);
    }


    public function excessiveAbsencesByClass(){
        
        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = Session::all();
        $subjects = Subject::all();
        $students = Student::all();

        return view('backend.attendance.excessive_absences_by_class', compact(
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
            'students',
        ));

    }

    public function excessiveAbsencesByClassSearch(){
    }


    public function store(Request $request)
    {

        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect(route('attendance.index'))->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function searchStudents(Request $request)
    {
       
        $query = Attendance::leftJoin('students', 'attendances.student_id', 'students.id')->leftJoin('class_schedules', 'class_schedules.class_id', 'attendances.classes_id')->leftJoin('sessions', 'attendances.session_id', '=', 'sessions.id')->select('attendances.id', 'attendances.attendance', 'students.student_id', 'attendances.session_id', 'attendances.classes_id', 'students.first_name', 'students.last_name', 'class_schedules.start_time', 'sessions.start_date', 'sessions.end_date', 'sessions.name',);
        if ($request->year) {
            $years = explode('-', $request->year);
            $query->where('sessions.name', $years[0]);
        }
        if ($request->classes) {
            $query->where('attendances.classes_id', $request->classes);
        }
        if ($request->attendance) {
            $query->where('attendances.attendance', $request->attendance);
        }
        $data['attendance'] = $query->paginate(10);
        $data['school_years'] = DB::table('school_years')->get();
        $data['classes'] = DB::table('classes')->get();
        $data['subjects'] = DB::table('subjects')->get();
        return view('backend.attendance.index', compact('data'));
    }


    // report start----------------------------------------------------------------------------------------------

    public function report()
    {
        $data['title']              = ___('attendance.Attendance');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = [];
        $data['students']           = [];
        $data['request']            = [];

        return view('backend.attendance.report', compact('data'));
    }


    public function reportSearch(AttendanceRequest $request)
    {
        $data['title']        = ___('attendance.Attendance');
        $data['request']      = $request;
        $data['classes']      = $this->classRepo->assignedAll();
        $data['sections']     = $this->classSetupRepo->getSections($request->class);
        $results              = $this->repo->searchReport($request);
        $data['students']     = $results['students'];
        $data['days']         = $results['days'];
        $data['attendances']  = $results['attendances'];
        return view('backend.attendance.report', compact('data'));
    }




    public function generatePDF(Request $request)
    {
        $results              = $this->repo->searchReportPDF($request);
        $data['students']     = $results['students'];
        $data['days']         = $results['days'];
        $data['attendances']  = $results['attendances'];
        $data['request']      = $request;

        $pdf = PDF::loadView('backend.attendance.reportPDF', compact('data'));

        if ($request->view == '0')
            $pdf->setPaper('A4', 'landscape');

        return $pdf->download('attendance' . '_' . date('d_m_Y') . '.pdf');
    }

    // report end----------------------------------------------------------------------------------------------
}
