<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Repositories\ParentPanel\AttendanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    private $repo;

    function __construct(AttendanceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $data['title'] = ___('common.Attendance');

        // Get logged-in parent's student
        $student = Student::where('parent_guardian_id', Auth::id())->firstOrFail();
        $studentId = $student->id;

        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);
        $selectedSubjects = $request->get('subjects', ['all']);

        /*
        |--------------------------------------------------------------------------
        | 1. Get regular attendance
        |--------------------------------------------------------------------------
        */
        $attendanceQuery = DB::table('attendances')
            ->join('classes', 'attendances.classes_id', '=', 'classes.id')
            ->join('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->where('attendances.student_id', $studentId)
            ->whereMonth('attendances.date', $month)
            ->whereYear('attendances.date', $year)
            ->select(
                'attendances.date',
                'attendances.attendance',
                'subjects.id as subject_id',
                'subjects.name as subject_name'
            );

        if (!in_array('all', $selectedSubjects)) {
            $attendanceQuery->whereIn('subjects.id', $selectedSubjects);
        }

        $regularAttendances = $attendanceQuery->get();

        /*
        |--------------------------------------------------------------------------
        | 2. Get APPROVED leaves overlapping selected month
        |--------------------------------------------------------------------------
        */
        $approvedLeaves = DB::table('leaves')
            ->where('student_id', $studentId)
            ->where('is_approved', 1)
            ->where(function ($q) use ($year, $month) {
                $q->whereMonth('from_date', $month)->whereYear('from_date', $year)
                  ->orWhereMonth('to_date', $month)->whereYear('to_date', $year)
                  ->orWhere(function ($qq) use ($month, $year) {
                      $qq->where('from_date', '<', Carbon::create($year, $month, 1))
                         ->where('to_date', '>=', Carbon::create($year, $month, 1)->endOfMonth());
                  });
            })
            ->select('from_date', 'to_date')
            ->get();

        // Build leave date list
        $leaveDates = [];
        foreach ($approvedLeaves as $leave) {
            $start = Carbon::parse($leave->from_date);
            $end   = Carbon::parse($leave->to_date);

            $period = CarbonPeriod::create(
                max($start, Carbon::create($year, $month, 1)),
                min($end, Carbon::create($year, $month, 1)->endOfMonth())
            );

            foreach ($period as $date) {
                $leaveDates[] = $date->format('Y-m-d');
            }
        }
        $leaveDates = array_unique($leaveDates);

        /*
        |--------------------------------------------------------------------------
        | 3. Get student's subjects
        |--------------------------------------------------------------------------
        */
        $subjects = DB::table('student_class_mapping')
            ->where('student_id', $studentId)
            ->leftJoin('classes', 'student_class_mapping.class_id', '=', 'classes.id')
            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->select('subjects.id', 'subjects.name')
            ->distinct()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 4. Build attendance map
        |--------------------------------------------------------------------------
        */
        $attendanceData = [];

        // Insert regular attendance
        foreach ($regularAttendances as $a) {
            $status = match ((int) $a->attendance) {
                1 => 'present',
                2 => 'late',
                3 => 'absent',
                4 => 'half_day',
                default => 'absent',
            };

            $attendanceData[$a->date][$a->subject_id] = $status;
        }

        // Overlay approved leaves
        if (!empty($leaveDates)) {
            $subjectIds = $subjects->pluck('id')->all();

            foreach ($leaveDates as $date) {
                foreach ($subjectIds as $subjId) {
                    if (!isset($attendanceData[$date][$subjId])) {
                        $attendanceData[$date][$subjId] = 'absent'; // or 'leave'
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. AUTO MARK TODAY AS ABSENT IF NO RECORD EXISTS
        |--------------------------------------------------------------------------
        */
        $today = Carbon::today()->format('Y-m-d');

        if (
            Carbon::today()->month == $month &&
            Carbon::today()->year == $year &&
            !in_array($today, $leaveDates)
        ) {
            $subjectIds = $subjects->pluck('id')->all();

            foreach ($subjectIds as $subjId) {
                if (!isset($attendanceData[$today][$subjId])) {
                    $attendanceData[$today][$subjId] = 'absent';
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Calendar helpers
        |--------------------------------------------------------------------------
        */
        $firstDay   = Carbon::create($year, $month, 1);
        $lastDay    = $firstDay->copy()->endOfMonth();
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Shabbos'];

        return view('parent-panel.attendance', compact(
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
        $data            = $this->repo->search($request);
        $data['title']   = ___('common.Attendance');
        $data['request'] = $request;

        return view('parent-panel.attendance', compact('data'));
    }
}
