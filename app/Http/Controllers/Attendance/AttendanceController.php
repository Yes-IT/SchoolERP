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
        $schoolYears = SchoolYear::all();
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
        $query = Attendance::leftJoin('students', 'attendances.student_id', 'students.id')
            ->leftJoin('class_schedules', 'class_schedules.class_id', 'attendances.classes_id')
            ->select(
                'attendances.id',
                'attendances.attendance',
                'attendances.is_approved',
                'attendances.approved_date',
                'students.student_id',
                'students.first_name',
                'students.last_name',
                'class_schedules.start_time'
            );

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

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('attendances.date', $request->month)
                ->whereYear('attendances.date', $request->year);

            // Handle week range (e.g., '1-6')
            if ($request->filled('week')) {
                // Parse week range (e.g., '1-6' -> [1, 6])
                [$startDay, $endDay] = explode('-', $request->week);

                // Validate start and end days
                $startDay = (int) $startDay;
                $endDay = (int) $endDay;

                // Ensure valid day range (1 to 31)
                if ($startDay >= 1 && $endDay <= 31 && $startDay <= $endDay) {
                    // Create start and end dates for the week
                    $startDate = Carbon::create($request->year, $request->month, $startDay)->startOfDay();
                    $endDate = Carbon::create($request->year, $request->month, $endDay)->endOfDay();

                    // Apply date range filter
                    $query->whereBetween('attendances.date', [$startDate, $endDate]);
                }
            }
        }

        // Adjust pagination per_page based on request
        $perPage = $request->input('per_page', 10); // Default to 10 if not provided
        $attendance = $query->paginate($perPage);

        return response()->json([
            'data' => view('backend.attendance.partials.daily_attendance_list', [
                'data' => ['attendance' => $attendance]
            ])->render(),
            'pagination' => (string) $attendance->links('backend.partials.pagination', ['routeName' => 'daily.index'])
        ]);
    }


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


    public function totalAttendance(){

        $students = Student::all();
        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();
        $subjects = Subject::all();

        return view('backend.attendance.total_attendance', compact(
            'students',
            'classes',
            'yearStatuses',
            'semesters',
            'schoolYears',
            'subjects',
        ));


    }

    
    public function searchTotal(Request $request){
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

    public function submissionTracker()
    {
        return view('backend.attendance.submission_tracker');
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
