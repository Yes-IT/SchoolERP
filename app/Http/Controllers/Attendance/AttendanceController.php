<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\AttendanceReportRequest;
use App\Http\Requests\Attendance\AttendanceSearchRequest;
use App\Http\Requests\Attendance\AttendanceStoreRequest;
use App\Http\Requests\Report\AttendanceRequest;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Attendance\AttendanceRepository;
use Illuminate\Http\Request;
use PDF;
use App\Models\Attendance\Attendance;
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

    public function index()
    {

        $query = Attendance::leftJoin('students', 'attendances.student_id', 'students.id')->leftJoin('class_schedules', 'class_schedules.class_id', 'attendances.classes_id')->select('attendances.id', 'attendances.attendance', 'students.student_id', 'students.first_name', 'students.last_name', 'class_schedules.start_time');
        $data['attendance'] = $query->paginate(10);
        $data['school_years'] = DB::table('school_years')->get();
        $data['classes'] = DB::table('classes')->get();
        $data['subjects'] = DB::table('subjects')->get();
        return view('backend.attendance.index', compact('data'));
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
