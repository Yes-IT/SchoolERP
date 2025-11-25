<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Interfaces\Staff\ExamRequestInterface;
use App\Models\Examination\ExamType;
use App\Models\Academic\Subject;
use App\Models\Academic\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Log,DB};
use Carbon\Carbon;

class ExamScheduleController extends Controller
{
    protected $examRequestRepository;

    public function __construct(ExamRequestInterface $examRequestRepository)
    {
        $this->examRequestRepository = $examRequestRepository;
    }

    public function examSchedule()
    {
        try{
                $teacherId = Auth::id();

                // dd($teacherId);

                $examTypes = ExamType::where('status', 1)->get();

                $subjects = Subject::whereHas('teachers', function($query) use ($teacherId) {
                    $query->where('staff.user_id', $teacherId);
                })->get();

                // dd($subjects);

                $classes = Classes::whereHas('teachers', function($query) use ($teacherId) {
                    $query->where('staff.user_id', $teacherId);
                })->get();

                // dd($classes);
                
                return view('staff.exam_schedule', compact('examTypes', 'subjects', 'classes'));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('staff.dashboard')->with('error', 'Failed to get exam schedule.');
        }
      
    }

    public function classSchedule()
    {
        return view('staff.class_schedule');
    }

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
                'exam_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
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

            Log::info('getAvailableRooms request', ['request' => $request->all()]);

            $request->validate([
                'exam_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            Log::info('Validation passed', [
                'exam_date' => $request->exam_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time
            ]);

            $rooms = $this->examRequestRepository->getAvailableRooms(
                $request->exam_date,
                $request->start_time,
                $request->end_time
            );

            Log::info('Available rooms found:', ['count' => $rooms->count()]);

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
