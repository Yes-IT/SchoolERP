<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth,DB,Log};
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class ClassRoutineController extends Controller
{
    // private $reportClassRoutineRepo;
    private $repo;

    function __construct(ClassRoutineRepository $repo)
    {
       
        $this->repo               = $repo;
    }

    // public function index(Request $request)
    // {
    //     $student_first = Student::where('parent_guardian_id', Auth::user()->id)->first();
    //     $student = Student::where('id', $student_first->id)->first();
    //     $studentId = $student->id;

    //     // Get all mappings of this student (class + teachers)
    //     $classDetails = DB::table('student_class_mapping')
    //         ->where('student_id', $studentId)
    //         ->get();

    //     // Extract class_id (assuming all mappings are for the same class)
    //     $classId = $classDetails->first()->class_id ?? null;

    //     // Extract all teacher IDs from mapping
    //     $teacherIds = $classDetails->pluck('teacher_id')->toArray();

    //     // Build the base query
    //     $query = DB::table('daily_class_routines')
    //         ->join('subjects', 'daily_class_routines.subject_id', '=', 'subjects.id')
    //         ->join('staff', 'daily_class_routines.teacher_id', '=', 'staff.id')
    //         ->where('daily_class_routines.class_id', $classId)
    //         ->whereIn('daily_class_routines.teacher_id', $teacherIds);

    //     $selectedDates = $request->dates ?? '';

    //     if ($request->has('dates') && !empty($request->dates)) {
    //         $dates = explode(' - ', $request->dates);

    //         if (count($dates) == 2) {
    //             $startDate = date('Y-m-d', strtotime($dates[0]));
    //             $endDate = date('Y-m-d', strtotime($dates[1]));
    //         }
    //     }
    //     // =========== END DATE FILTERING LOGIC ===========

    //     // Execute the query
    //     $data = $query->select(
    //         'daily_class_routines.*',
    //         'subjects.name as subject_name',
    //         'staff.first_name as staff_first_name',
    //         'staff.last_name as staff_last_name'
    //     )
    //         ->get();

    //     foreach ($data as $item) {
    //         $item->time_range = $item->start_time . ' - ' . $item->end_time;
    //     }
    //     $times = $data->pluck('time_range')->unique()->values();

    //     $times = $times->sortBy(function ($time) {
    //         [$start, $end] = explode(' - ', $time);
    //         return strtotime(str_replace('-', ':', $start));
    //     })->values();

    //     $grouped = [];
    //     foreach ($data as $item) {
    //         $grouped[$item->day][$item->time_range] = $item;
    //     }

    //     $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    //     // Pass the selected dates back to the view
    //     $selectedDates = $request->dates ?? '';

    //     return view('parent-panel.class-routine', compact('grouped', 'times', 'weekDays', 'selectedDates'));
    // }

    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        $data['request'] = $request;

        return view('parent-panel.class-routine', compact('data'));
    }

    // public function generatePDF($student)
    // {
    //     $student        = Student::where('id', $student)->first();
    //     $classSection   = SessionClassStudent::where('session_id', setting('session'))
    //         ->where('student_id', @$student->id)
    //         ->first();

    //     $request = new Request([
    //         'class'        => $classSection->classes_id,
    //         'section'      => $classSection->section_id
    //     ]);

    //     $data['result']       = $this->reportClassRoutineRepo->search($request);
    //     $data['time']         = $this->reportClassRoutineRepo->time($request);

    //     $pdf = PDF::loadView('backend.report.class-routinePDF', compact('data'));
    //     return $pdf->download('class_routine' . '_' . date('d_m_Y') . '.pdf');
    // }



    ///changes by nazmin 11-12-2025

    public function index(Request $request)
    {
        try {
           
            // Log::info('ClassRoutineController - Start', [
            //     'route' => $request->route()->getName(),
            //     'student_from_request' => request()->get('currentStudent') ? 'exists' : 'null',
            //     'student_id_session' => session('current_student_id'),
            //     'auth_id' => Auth::id()
            // ]);

            $student = request()->get('currentStudent');

            // If student is not set via middleware, try to get it from session
            if (!$student) {
                $studentId = session('current_student_id');
                if (!$studentId) {
                    return redirect()->route('parent-panel-dashboard.index')->with('error', 'Please select a student first');
                }
                
                $student = Student::where('id', $studentId)->where('parent_guardian_id', Auth::id())->first();
                if (!$student) {

                    return redirect()->route('parent-panel-dashboard.index')->with('error', 'Invalid student selected');
                }
            }

           
            $studentId = $student->id;

            $classIds = DB::table('student_class_mapping')
                        ->where('student_id', $studentId)
                        ->pluck('class_id');
                        
                        
            Log::info('ClassRoutineController - Class IDs found', [
                'student_id' => $studentId,
                'class_ids' => $classIds->toArray(),
                'count' => $classIds->count()
            ]);

            if ($classIds->isEmpty()) {
                return back()->with('error', 'No class assigned to this student');
            }

            $schedules = DB::table('class_schedules as cs')
                                ->select([
                                    'cs.id',
                                    'cs.day',
                                    'cs.period',
                                    'cs.start_time',
                                    'cs.end_time',
                                    'cs.room_id',
                                    'c.subject_id',
                                    'c.teacher_id',
                                    's.name as subject_name',
                                    DB::raw("CONCAT(st.first_name, ' ', st.last_name) as teacher_name"),
                                    'cr.room_no',
                                    DB::raw("TIME(cs.start_time) as start_time_only"),
                                    DB::raw("DATE_FORMAT(cs.start_time, '%H:00:00') as hour_slot")
                                ])
                                ->join('classes as c', 'cs.class_id', '=', 'c.id')
                                ->leftJoin('subjects as s', 'c.subject_id', '=', 's.id')
                                ->leftJoin('staff as st', 'c.teacher_id', '=', 'st.id')
                                ->leftJoin('class_rooms as cr', 'cs.room_id', '=', 'cr.id')
                                ->whereIn('cs.class_id', $classIds)
                                ->whereNull('cs.deleted_at')
                                ->whereNull('c.deleted_at')
                                ->where('cs.day', '!=', 'Shabbos') 
                                ->orderByRaw("FIELD(cs.day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
                                ->orderBy('cs.start_time')
                                ->get();
             

            // Prepare time slots (school hours: 8 AM to 8 PM)
            $timeSlots = [];
            for ($h = 8; $h <= 20; $h++) {  
                $start = sprintf("%02d:00:00", $h);
                $timeSlots[$start] = [
                    'label' => date("h:i A", strtotime($start)) . " - " . 
                            date("h:i A", strtotime(sprintf("%02d:59:00", $h))),
                    'hour' => $h
                ];
            }

            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Shabbos'];

            // Initialize formatted array
            $formatted = [];
            foreach ($days as $day) {
                $formatted[$day] = [];
                foreach ($timeSlots as $startTime => $slot) {
                    $formatted[$day][$startTime] = null;
                }
            }

            // Set Shabbos to show "No Classes" for all slots
            foreach ($timeSlots as $startTime => $slot) {
                $formatted['Shabbos'][$startTime] = [
                    'is_holiday' => true,
                    'message' => 'No Classes - Shabbos'
                ];
            }

            // Process regular schedules (excluding Shabbos)
            foreach ($schedules as $schedule) {
                $normalizedStart = $schedule->hour_slot ?? date("H:00:00", strtotime($schedule->start_time));
                
                // Skip if outside school hours
                if (!isset($timeSlots[$normalizedStart])) {
                    continue;
                }
                
                if ($schedule->day === 'Shabbos') {
                    continue;
                }
                
                // Set the data
                $formatted[$schedule->day][$normalizedStart] = [
                    'subject' => $schedule->subject_name ?? ('Period ' . $schedule->period),
                    'teacher' => $schedule->teacher_name ?? 'Teacher ID: ' . $schedule->teacher_id,
                    'room' => $schedule->room_no ?? ('Room ID: ' . $schedule->room_id),
                    'period' => $schedule->period,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'display_time' => date('h:i A', strtotime($schedule->start_time)) . ' - ' . 
                                    date('h:i A', strtotime($schedule->end_time)),
                    'is_holiday' => false
                ];
            }

            $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            foreach ($weekdays as $day) {
                if (isset($formatted[$day]) && empty(array_filter($formatted[$day], function($slot) {
                    return $slot !== null && (!isset($slot['is_holiday']) || !$slot['is_holiday']);
                }))) {
                   
                    foreach ($formatted[$day] as $time => $slot) {
                        if ($slot === null) {
                            $formatted[$day][$time] = [
                                'is_empty' => true,
                                'message' => 'No Class'
                            ];
                        }
                    }
                }
            }

            $hasData = false;
            foreach ($weekdays as $day) {
                if (isset($formatted[$day])) {
                    foreach ($formatted[$day] as $slot) {
                        if ($slot && (!isset($slot['is_holiday']) || !$slot['is_holiday']) && !isset($slot['is_empty'])) {
                            $hasData = true;
                            break 2;
                        }
                    }
                }
            }

            return view('parent-panel.class-routine', [
                'formatted' => $formatted,
                'timeSlots' => $timeSlots,
                'days' => $days,
                'hasData' => $hasData
            ]);

        } catch (\Exception $e) {
             Log::error('Error loading class routine:', [
                'user_id' => auth()->id(),
                'student_id' => optional(request()->get('currentStudent'))->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('parent-panel-dashboard.index')->with('error', 'Unable to load class schedule. Please try again later.');
        }
    }

    // public function generateSchedulePDF(Request $request)
    // {
    //     // Get date range from request
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
        
    //     // Parse dates or use defaults
    //     $start = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfWeek();
    //     $end = $endDate ? Carbon::parse($endDate) : Carbon::now()->endOfWeek();
        
    //     // Fetch schedules for the date range
    //     $schedules = ClassSchedule::with(['subject', 'teacher', 'classroom'])
    //         ->whereBetween('date', [$start, $end])
    //         ->orderBy('date')
    //         ->orderBy('start_time')
    //         ->get()
    //         ->groupBy('date');
        
    //     $data = [
    //         'schedules' => $schedules,
    //         'startDate' => $start->format('M d, Y'),
    //         'endDate' => $end->format('M d, Y'),
    //         'generatedAt' => Carbon::now()->format('M d, Y h:i A'),
    //     ];
        
    //     // Generate PDF
    //     $pdf = Pdf::loadView('pdf.schedule', $data);
        
    //     // Set PDF options
    //     $pdf->setPaper('A4', 'landscape');
    //     $pdf->setOption('defaultFont', 'Arial');
        
    //     // Download PDF
    //     return $pdf->download('class-schedule-'.$start->format('Y-m-d').'-to-'.$end->format('Y-m-d').'.pdf');
    // }
    
}
