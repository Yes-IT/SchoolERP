<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
use PDF;
use DB;
use Illuminate\Support\Facades\Auth;

class ClassRoutineController extends Controller
{
    private $reportClassRoutineRepo;
    private $repo;

    function __construct(ReportClassRoutineRepository $reportClassRoutineRepo, ClassRoutineRepository $repo)
    {
        $this->reportClassRoutineRepo = $reportClassRoutineRepo;
        $this->repo               = $repo;
    }

    public function index(Request $request)
    {
        $student_first = Student::where('parent_guardian_id', Auth::user()->id)->first();
        $student = Student::where('id', $student_first->id)->first();
        $studentId = $student->id;

        // Get all mappings of this student (class + teachers)
        $classDetails = DB::table('student_class_mapping')
            ->where('student_id', $studentId)
            ->get();

        // Extract class_id (assuming all mappings are for the same class)
        $classId = $classDetails->first()->class_id ?? null;

        // Extract all teacher IDs from mapping
        $teacherIds = $classDetails->pluck('teacher_id')->toArray();

        // Build the base query
        $query = DB::table('daily_class_routines')
            ->join('subjects', 'daily_class_routines.subject_id', '=', 'subjects.id')
            ->join('staff', 'daily_class_routines.teacher_id', '=', 'staff.id')
            ->where('daily_class_routines.class_id', $classId)
            ->whereIn('daily_class_routines.teacher_id', $teacherIds);

        $selectedDates = $request->dates ?? '';

        if ($request->has('dates') && !empty($request->dates)) {
            $dates = explode(' - ', $request->dates);

            if (count($dates) == 2) {
                $startDate = date('Y-m-d', strtotime($dates[0]));
                $endDate = date('Y-m-d', strtotime($dates[1]));
            }
        }
        // =========== END DATE FILTERING LOGIC ===========

        // Execute the query
        $data = $query->select(
            'daily_class_routines.*',
            'subjects.name as subject_name',
            'staff.first_name as staff_first_name',
            'staff.last_name as staff_last_name'
        )
            ->get();

        foreach ($data as $item) {
            $item->time_range = $item->start_time . ' - ' . $item->end_time;
        }
        $times = $data->pluck('time_range')->unique()->values();

        $times = $times->sortBy(function ($time) {
            [$start, $end] = explode(' - ', $time);
            return strtotime(str_replace('-', ':', $start));
        })->values();

        $grouped = [];
        foreach ($data as $item) {
            $grouped[$item->day][$item->time_range] = $item;
        }

        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Pass the selected dates back to the view
        $selectedDates = $request->dates ?? '';

        return view('parent-panel.class-routine', compact('grouped', 'times', 'weekDays', 'selectedDates'));
    }

    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        $data['request'] = $request;

        return view('parent-panel.class-routine', compact('data'));
    }

    public function generatePDF($student)
    {
        $student        = Student::where('id', $student)->first();
        $classSection   = SessionClassStudent::where('session_id', setting('session'))
            ->where('student_id', @$student->id)
            ->first();

        $request = new Request([
            'class'        => $classSection->classes_id,
            'section'      => $classSection->section_id
        ]);

        $data['result']       = $this->reportClassRoutineRepo->search($request);
        $data['time']         = $this->reportClassRoutineRepo->time($request);

        $pdf = PDF::loadView('backend.report.class-routinePDF', compact('data'));
        return $pdf->download('class_routine' . '_' . date('d_m_Y') . '.pdf');
    }
}
