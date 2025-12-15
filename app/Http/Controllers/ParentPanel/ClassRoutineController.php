<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
// use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use Illuminate\Support\Facades\{Auth,DB,Log};

class ClassRoutineController extends Controller
{
    // private $reportClassRoutineRepo;
    private $repo;

    // function __construct(ClassRoutineRepository $repo)
    // {
    //     // $this->reportClassRoutineRepo = $reportClassRoutineRepo;
    //     $this->repo               = $repo;
    // }

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

    // public function index()
    // {
    //     try {
    //         $students = DB::table('parent_guardians')
    //                         ->where('user_id', auth()->id())
    //                         ->pluck('student_id');

    //         if ($students->isEmpty()) {
    //             return back()->with('error', 'No student found for this parent');
    //         }

    //         $classIds = DB::table('class_student')
    //                     ->whereIn('student_id', $students)
    //                     ->where('status', '1')
    //                     ->pluck('class_id');

    //         if ($classIds->isEmpty()) {
    //             return back()->with('error', 'No class assigned to this student');
    //         }

    //         $schedules = DB::table('class_schedules')
    //                     ->select('class_schedules.*', 'classes.subject_id', 'classes.teacher_id')
    //                     ->join('classes', 'class_schedules.class_id', '=', 'classes.id')
    //                     ->whereIn('class_schedules.class_id', $classIds)
    //                     ->whereNull('class_schedules.deleted_at')
    //                     ->whereNull('classes.deleted_at')
    //                     ->orderBy('class_schedules.day')
    //                     ->orderBy('class_schedules.start_time')
    //                     ->get();

    //         $timeSlots = [];
    //         for ($h = 0; $h <= 23; $h++) {  
    //             $start = sprintf("%02d:00:00", $h);
    //             $end   = sprintf("%02d:59:00", $h);
    //             $slotKey = $start; 

    //             $timeSlots[$slotKey] = [
    //                 'label' => date("h:i A", strtotime($start)) . " - " . date("h:i A", strtotime($end))
    //             ];
    //         }

    //         $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Shabbos'];

    //         $formatted = [];
    //         foreach ($days as $day) {
    //             foreach ($timeSlots as $startTime => $slot) {
    //                 $formatted[$day][$startTime] = null;
    //             }
    //         }

    //         $subjectIds = $schedules->pluck('subject_id')->filter()->unique()->values();
    //         $teacherIds = $schedules->pluck('teacher_id')->filter()->unique()->values();
    //         // dd($teacherIds);

    //         $subjects = DB::table('subjects')
    //                     ->whereIn('id', $subjectIds)
    //                     ->pluck('name', 'id');
            
    //         $teachers = DB::table('staff')
    //                     ->whereIn('id', $teacherIds)
    //                     ->select(DB::raw("id, CONCAT(first_name, ' ', last_name) as full_name"))
    //                     ->pluck('full_name', 'id');

    //         $roomIds = $schedules->pluck('room_id')->filter()->unique()->values();
    //         $rooms = DB::table('class_rooms')
    //                 ->whereIn('id', $roomIds)
    //                 ->pluck('room_no', 'id');

    //         foreach ($schedules as $schedule) {
    //             $normalizedStart = date("H:00:00", strtotime($schedule->start_time));
                
    //             // TEMPORARILY REMOVE TIME FILTER
    //             // if ($normalizedStart >= "08:00:00" && $normalizedStart <= "19:00:00") {
                
    //             if (!isset($formatted[$schedule->day])) {
    //                 Log::warning('Day not in array:', ['day' => $schedule->day]);
    //                 continue;
    //             }
                
    //             if (!array_key_exists($normalizedStart, $formatted[$schedule->day])) {
    //                 Log::warning('Time slot not in array:', [
    //                     'day' => $schedule->day,
    //                     'time' => $normalizedStart,
    //                     'available_slots' => array_keys($formatted[$schedule->day])
    //                 ]);
    //                 continue;
    //             }
                
    //             $subjectName = $subjects[$schedule->subject_id] ?? ('Period ' . $schedule->period);
    //             $teacherName = $teachers[$schedule->teacher_id] ?? 'Teacher ID: ' . $schedule->teacher_id;
    //             $room = $rooms[$schedule->room_id] ?? ('Room ID: ' . $schedule->room_id);
            
    //             $formatted[$schedule->day][$normalizedStart] = [
    //                 'subject' => $subjectName,
    //                 'teacher' => $teacherName,
    //                 'room' => $room,
    //                 'period' => $schedule->period,
    //                 'start_time_raw' => $schedule->start_time,
    //                 'end_time_raw' => $schedule->end_time,
    //             ];
                
               
                
    //         }

           

    //         return view('parent-panel.class-routine', compact('formatted', 'timeSlots', 'days'));

    //     } catch (\Exception $e) {
    //         Log::error('Error in index method:', [
    //             'error' => $e->getMessage(), 
    //             'trace' => $e->getTraceAsString(),
    //             'line' => $e->getLine()
    //         ]);
    //         return redirect()->route('parent-panel-dashboard.index')->with('error', 'Failed to load classes: ' . $e->getMessage());
    //     }
    // }

    public function index()
    {
        try {
            $studentIds = DB::table('parent_guardians')
                            ->where('user_id', auth()->id())
                            ->pluck('student_id');

            if ($studentIds->isEmpty()) {
                return back()->with('error', 'No student found for this parent');
            }

            $classIds = DB::table('class_student')
                        ->whereIn('student_id', $studentIds)
                        ->where('status', '1')
                        ->whereNull('deleted_at')
                        ->pluck('class_id');

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
                                ->where('cs.day', '!=', 'Shabbos') // Exclude Shabbos from query
                                ->orderByRaw("FIELD(cs.day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
                                ->orderBy('cs.start_time')
                                ->get();

            Log::info('Class schedules found:', [
                'count' => $schedules->count(),
                'days' => $schedules->pluck('day')->unique()->values()->toArray()
            ]);                    

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
                
                // Skip Shabbos (shouldn't happen due to query filter, but just in case)
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

            // Clean up - remove weekdays with no classes at all
            $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            foreach ($weekdays as $day) {
                if (isset($formatted[$day]) && empty(array_filter($formatted[$day], function($slot) {
                    return $slot !== null && (!isset($slot['is_holiday']) || !$slot['is_holiday']);
                }))) {
                    // Keep the day but mark all slots as empty
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
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('parent-panel-dashboard.index')->with('error', 'Unable to load class schedule. Please try again later.');
        }
    }

    public function generateSchedulePDF(Request $request)
    {
        // Get date range from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Parse dates or use defaults
        $start = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfWeek();
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now()->endOfWeek();
        
        // Fetch schedules for the date range
        $schedules = ClassSchedule::with(['subject', 'teacher', 'classroom'])
            ->whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('date');
        
        $data = [
            'schedules' => $schedules,
            'startDate' => $start->format('M d, Y'),
            'endDate' => $end->format('M d, Y'),
            'generatedAt' => Carbon::now()->format('M d, Y h:i A'),
        ];
        
        // Generate PDF
        $pdf = Pdf::loadView('pdf.schedule', $data);
        
        // Set PDF options
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption('defaultFont', 'Arial');
        
        // Download PDF
        return $pdf->download('class-schedule-'.$start->format('Y-m-d').'-to-'.$end->format('Y-m-d').'.pdf');
    }
    
}
