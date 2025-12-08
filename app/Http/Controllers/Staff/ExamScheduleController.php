<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Traits\ScheduleTrait; 
use App\Interfaces\Staff\ExamRequestInterface;
use App\Models\Examination\ExamType;
use App\Models\Academic\Subject;
use App\Models\Academic\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Log,DB};
use App\Services\RoomAvailabilityService;
use Carbon\Carbon;

class ExamScheduleController extends Controller
{
    use ScheduleTrait;

    protected $examRequestRepository;

    public function __construct(ExamRequestInterface $examRequestRepository)
    {
        $this->examRequestRepository = $examRequestRepository;
    }

    public function examSchedule()
    {
        try{
                 $teacherId = Auth::user()->staff->id;
                // dd($teacherId);

                $examTypes = ExamType::where('status', 1)->get();

                // $subjects = Subject::whereHas('teachers', function($query) use ($teacherId) {
                //     $query->where('staff.user_id', $teacherId);
                // })->get();

                $subjects = Subject::whereHas('teachers', function ($query) use ($teacherId) {
                                $query->where('staff.id', $teacherId);
                            })->get();

                // dd($subjects);

                $classes = Classes::whereHas('teachers', function($query) use ($teacherId) {
                    $query->where('staff.id', $teacherId);
                })->get();

                // dd($classes);

                $upcomingExams = $this->examRequestRepository->getUpcomingExams($teacherId);
                $requestedExams = $this->examRequestRepository->getRequestedExams($teacherId);

                Log::info('Upcoming exams:', ['count' => $upcomingExams->count()]);
                Log::info('Requested exams:', ['count' => $requestedExams->count(), 'requested exams' => $requestedExams->toArray()]);

                // dd($requestedExams);

                
                return view('staff.exam_schedule', compact('examTypes', 'subjects', 'classes', 'upcomingExams', 'requestedExams'));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('staff.dashboard')->with('error', 'Failed to get exam schedule.');
        }
      
    }

    public function classSchedule(Request $request)
    {
        $teacherId =  Auth::user()->staff->id;

        $service = new RoomAvailabilityService();
        
        $viewType = $request->get('view', 'week'); 
        $selectedDate = $request->get('date', date('Y-m-d'));
        
        // Log::info('Processing parameters', [
        //     'view_type' => $viewType,
        //     'selected_date' => $selectedDate
        // ]);

        $periods = DB::table('period')
                    ->where('start_time', '>=', '08:00:00')
                    ->where('end_time', '<=', '17:59:00')
                    ->orderBy('start_time')
                    ->get();
        // dd($periods);           
        
        $schedules = [];
        
        try {
            switch ($viewType) {
                case 'date': 
                    $schedules = $this->getSchedulesForDate($selectedDate, $teacherId);
                    break;
                    
                case 'month': 
                    $schedules = $this->getSchedulesForMonth($selectedDate, $teacherId);
                    break;
                    
                case 'week':
                default:
                   
                    $schedules = $this->getSchedulesForWeek($selectedDate, $teacherId);
                    break;
            }
            
            
        } catch (\Exception $e) {
            Log::error('Error fetching schedules: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return empty data on error
            $schedules = [];
        }
        
        return view('staff.class_schedule', [
            'schedules' => $schedules,
            'viewType' => $viewType,    
            'selectedDate' => $selectedDate,
            'roomService' => $service,
            'periods' => $periods
        ]);
    }
    // private function getSchedulesForDate($date, $teacherId)
    // {
    //     $day = date('l', strtotime($date)); 
        
    //     // Log::info('Getting schedules for date', [
    //     //     'date' => $date,
    //     //     'day' => $day,
    //     //     'day_short' => date('D', strtotime($date)),
    //     //     'teacher_id' => $teacherId
    //     // ]);
        
    //     try {

    //         // Log::info('Teacher details', [
    //         //     'teacher_id_from_auth' => Auth::user()->staff->id,
    //         //     'auth_user_id' => Auth::id(),
    //         //     'auth_user' => Auth::user()->email
    //         // ]);

    //         // Get TEACHER'S CLASS SCHEDULES for that day
    //         $classSchedules = DB::table('class_schedules as cs')
    //             ->join('classes as c', 'cs.class_id', '=', 'c.id')
    //             ->leftJoin('subjects as s', 'c.subject_id', '=', 's.id')
    //             ->where('cs.day', $day)
    //             ->where('c.teacher_id', $teacherId)
    //             ->whereNull('cs.deleted_at')
    //             ->select(
    //                 'cs.*',
    //                 'c.name as class_name',
    //                 's.name as subject_name',
    //                 DB::raw("'class' as type")
    //             )
    //             ->orderBy('cs.start_time')
    //             ->get();
                
    //         // Log::info('Class schedules query result', [
    //         //     'date' => $date,
    //         //     'day' => $day,
    //         //     'count' => $classSchedules->count(),
    //         //     'class_schedules' => $classSchedules
    //         // ]);
            
    //         // Get TEACHER'S EXAM SCHEDULES for that date
    //         $examSchedules = DB::table('exam_schedules as es')
    //             ->join('exam_requests as er', 'es.exam_request_id', '=', 'er.id')
    //             ->leftJoin('subjects as s', 'er.subject_id', '=', 's.id')
    //             ->leftJoin('classes as c', 'er.class_id', '=', 'c.id')
    //             ->leftJoin('exam_types as et', 'er.exam_type_id', '=', 'et.id')
    //             ->whereDate('es.exam_date', $date)
    //             ->where('er.teacher_id', $teacherId)
    //             ->where('er.status', 'approved')
    //             ->whereNull('es.deleted_at')
    //             ->select(
    //                 'es.*',
    //                 'er.exam_type_id',
    //                 'er.teacher_id',
    //                 's.name as subject_name',
    //                 'c.name as class_name',
    //                 'et.name as exam_type_name',
    //                 DB::raw("'exam' as type")
    //             )
    //             ->orderBy('es.start_time')
    //             ->get();
                
    //         // Log::info('Exam schedules query result', [
    //         //     'date' => $date,
    //         //     'day' => $day,
    //         //     'count' => $examSchedules->count(),
    //         //     'exam_schedules' => $examSchedules
    //         // ]);
                
    //         $allSchedules = $classSchedules->merge($examSchedules);
            
    //         return [
    //             'date' => $date,
    //             'day_name' => $day,
    //             'class_schedules' => $classSchedules,
    //             'exam_schedules' => $examSchedules,
    //             'all_schedules' => $allSchedules
    //         ];
            
    //     } catch (\Exception $e) {
    //         Log::error('Error in getSchedulesForDate: ' . $e->getMessage());
            
    //         return [
    //             'date' => $date,
    //             'day_name' => $day,
    //             'class_schedules' => collect([]),
    //             'exam_schedules' => collect([]),
    //             'all_schedules' => collect([])
    //         ];
    //     }
    // }

    // private function getSchedulesForWeek($date, $teacherId)
    // {
    //     try {
    //         $startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($date)));
    //         $endOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($date)));

    //         // Log::info('Processing week', [
    //         //     'start_date' => $startOfWeek,
    //         //     'end_date' => $endOfWeek
    //         // ]);
            
    //         $weekSchedules = [];
    //         $currentDate = $startOfWeek;
            
    //         while (strtotime($currentDate) <= strtotime($endOfWeek)) {
    //             $dateSchedule = $this->getSchedulesForDate($currentDate, $teacherId);
                
    //             $weekSchedules[$currentDate] = $dateSchedule;
                
    //             $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
    //         }
            
    //         return [
    //             'week_start' => $startOfWeek,
    //             'week_end' => $endOfWeek,
    //             'daily_schedules' => $weekSchedules 
    //         ];
            
    //     } catch (\Exception $e) {
    //         Log::error('Error in getSchedulesForWeek: ' . $e->getMessage());
    //         return [
    //             'week_start' => $date,
    //             'week_end' => $date,
    //             'daily_schedules' => []
    //         ];
    //     }
    // }

    // private function getSchedulesForMonth($date, $teacherId)
    // {
    //     try {
    //         $year = date('Y', strtotime($date));
    //         $month = date('m', strtotime($date));
    //         $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            
    //         // Log::info('Processing month', [
    //         //     'year' => $year,
    //         //     'month' => $month,
    //         //     'days_in_month' => $daysInMonth
    //         // ]);

    //         $monthSchedules = [];
            
    //         for ($day = 1; $day <= $daysInMonth; $day++) {
    //             $currentDate = date('Y-m-d', strtotime("{$year}-{$month}-{$day}"));
    //             $monthSchedules[$currentDate] = $this->getSchedulesForDate($currentDate, $teacherId);
    //         }

    //         // Log::info('Month schedules', [
    //         //     'month_schedules' => $monthSchedules
    //         // ]);
            
    //         return [
    //             'year' => $year,
    //             'month' => $month,
    //             'month_name' => date('F', strtotime($date)),
    //             'daily_schedules' => $monthSchedules
    //         ];
            
    //     } catch (\Exception $e) {
    //         Log::error('Error in getSchedulesForMonth: ' . $e->getMessage());
    //         return [
    //             'year' => date('Y'),
    //             'month' => date('m'),
    //             'month_name' => date('F'),
    //             'daily_schedules' => []
    //         ];
    //     }
    // }


   
    // public function checkRoomAvailability(Request $request)
    // {
    //     // Log::info('checkRoomAvailability called', $request->all());
        
    //     $request->validate([
    //         'room_id' => 'required|integer',
    //         'date' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //     ]);
        
    //     try {
    //         $service = new RoomAvailabilityService();
    //         $isAvailable = $service->isRoomAvailable(
    //             $request->room_id,
    //             $request->date,
    //             $request->start_time,
    //             $request->end_time
    //         );
            
    //         // Log::info('Room availability checked', [
    //         //     'room_id' => $request->room_id,
    //         //     'date' => $request->date,
    //         //     'start_time' => $request->start_time,
    //         //     'end_time' => $request->end_time,
    //         //     'available' => $isAvailable
    //         // ]);
            
    //         return response()->json([
    //             'available' => $isAvailable,
    //             'message' => $isAvailable ? 'Room is available' : 'Room is not available'
    //         ]);
            
    //     } catch (\Exception $e) {
    //         Log::error('Error checking room availability: ' . $e->getMessage(), [
    //             'request' => $request->all(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
            
    //         return response()->json([
    //             'available' => false,
    //             'message' => 'Error checking availability: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function store_exam_request(Request $request)
    {
        try {

            // Log::info('Auth user:', [
            //     'user_id' => Auth::id(),
            //     'user' => Auth::user()
            // ]);

            $validated = $request->validate([
                'exam_type_id' => 'required|exists:exam_types,id',
                'subject_id' => 'required|exists:subjects,id',
                // 'class_id' => 'required|exists:classes,id',
                'room_id' => 'required|exists:class_rooms,id',
                
                'exam_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ]);

            $user = Auth::user();
            $staffId = $user->staff->id;

            // Log::info('User and staff info:', [
            //     'user_id' => $user->id,
            //     'staff_id' => $staffId
            // ]);

            $availableRooms = $this->examRequestRepository->getAvailableRooms(
                $validated['exam_date'],
                $validated['start_time'],
                $validated['end_time']
            );

            $isRoomAvailable = $availableRooms->contains('id', $validated['room_id']);

            if (!$isRoomAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, the selected room is no longer available. Please choose another room.'
                ], 422);
            }

            $start = Carbon::parse($validated['start_time']);
            $end = Carbon::parse($validated['end_time']);
            $duration = $start->diffInMinutes($end);

            $data = array_merge($validated, [
                'teacher_id' =>$staffId,
                'duration' => $duration,
                'status' => 'pending'
            ]);

            $examRequest = $this->examRequestRepository->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Your exam schedule request sent successfully to Admin.',
                'data' => $examRequest
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit exam request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableRooms(Request $request)
    {
        try {

            // Log::info('getAvailableRooms request', ['request' => $request->all()]);

            $request->validate([
                'exam_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            // Log::info('Validation passed', [
            //     'exam_date' => $request->exam_date,
            //     'start_time' => $request->start_time,
            //     'end_time' => $request->end_time
            // ]);

            $rooms = $this->examRequestRepository->getAvailableRooms(
                $request->exam_date,
                $request->start_time,
                $request->end_time
            );

            // Log::info('Available rooms found:', ['count' => $rooms->count()]);

            return response()->json([
                'success' => true,
                'rooms' => $rooms
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getAvailableRooms:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch available rooms'
            ], 500);
        }
    }
}
