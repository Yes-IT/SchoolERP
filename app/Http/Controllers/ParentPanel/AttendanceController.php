<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Repositories\ParentPanel\AttendanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use DB;

class AttendanceController extends Controller
{
    private $repo;

    function __construct(AttendanceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
   
        $data['title']              = ___('common.Attendance');
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
        // dd($attendances);
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
        $data                       = $this->repo->index();
        $data['results']            = [];
        return view('parent-panel.attendance', compact(
            'attendances',
            'attendanceData',
            'subjects',
            'selectedSubjects',
            'firstDay',
            'lastDay',
            'month',
            'year',
            'daysOfWeek'
        ));
    }

    public function search(Request $request)
    {
        $data                 = $this->repo->search($request);
        $data['title']        = ___('common.Attendance');
        $data['request']      = $request;
        return view('parent-panel.attendance', compact('data'));
    }
}
