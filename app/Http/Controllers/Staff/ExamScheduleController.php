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
                   $query->where('staff.id', $teacherId);
                })->get();

                $classes = Classes::whereHas('teachers', function($query) use ($teacherId) {
                    $query->where('staff.id', $teacherId);
                })->get();
                
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
            $validated = $request->validate([
                'exam_type_id' => 'required|exists:exam_types,id',
                'subject_id' => 'required|exists:subjects,id',
                'class_id' => 'required|exists:classes,id',
                'room_id' => 'required|exists:rooms,id',
                'exam_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            // Calculate duration
            $start = Carbon::parse($validated['start_time']);
            $end = Carbon::parse($validated['end_time']);
            $duration = $start->diffInMinutes($end);

            $data = array_merge($validated, [
                'teacher_id' => Auth::id(),
                'duration' => $duration,
                'status' => 'pending'
            ]);

            // Create exam request directly using repository
            $examRequest = $this->examRequestRepository->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Exam request submitted successfully! Waiting for admin approval.',
                'data' => $examRequest
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit exam request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableRooms(Request $request)
    {
        try {
            $request->validate([
                'exam_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            $rooms = $this->examRequestRepository->getAvailableRooms(
                $request->exam_date,
                $request->start_time,
                $request->end_time
            );

            return response()->json([
                'success' => true,
                'rooms' => $rooms
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch available rooms'
            ], 500);
        }
    }
}
