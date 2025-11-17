<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Examination\Type\ExamTypeStoreRequest;
use App\Http\Requests\Examination\Type\ExamTypeUpdateRequest;
use App\Interfaces\Examination\ExamTypeInterface;
use App\Models\Examination\{ExamRequest,ExamSchedule,RoomAvailability};
use App\Models\Academic\ClassRoom;
use carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExamScheduleController extends Controller
{

    protected $examType;

    public function __construct(ExamTypeInterface $examType)
    {
        $this->examType = $examType;
    }

    public function index(){

        $data['title']              = ___('examination.exam_schedule');
       

        return view ('backend.examination.exam-schedule.index',compact('data'));
    }

    public function createExamType(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $data['title']              = ___('examination.exam_type');
        $data['exam_types'] = $this->examType->getPaginateAll($perPage);

        // dd($data);
        return view ('backend.examination.exam-schedule.create-exam-type',compact('data'));
    }

    public function storeExamType(ExamTypeStoreRequest $request)
    {
        $result = $this->examType->store($request);

        if($result['status']){
            return redirect()->route('exam-schedule.createExamType')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function editExamType($id)
    {
        $examType = $this->examType->show($id);
        if (!$examType) {
            return response()->json(['status' => false, 'message' => 'Exam type not found'], 404);
        }

        // dd($examType);
        return response()->json(['status' => true, 'data' => $examType]);
    }



    public function updateExamType(ExamTypeUpdateRequest $request, $id)
    {
        $result = $this->examType->update($request, $id);
        if($result['status']){
            return redirect()->route('exam-schedule.createExamType')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function deleteExamType($id){
        $result = $this->examType->destroy($id);
        if($result['status']){
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }


    public function createExamScheduleType()
    {
        $data['title']              = ___('examination.exam_type');
        $data['exam_request'] = ExamRequest::with(['examType', 'class', 'room', 'teacher'])->get();

        // dd($data);
        return view ('backend.examination.exam-schedule.create-exam-schedule-type',compact('data'));
    }

   

    public function checkAvailablity($id)
    {
        $examRequest = ExamRequest::with(['examType', 'class', 'room', 'teacher'])
            ->findOrFail($id);
        // dd($examRequest);   
        
        // Find available rooms for this date/time
       $availableRooms = ClassRoom::whereDoesntHave('examSchedules', function($q) use ($examRequest) {
        $q->where('exam_date', $examRequest->exam_date)
          ->where(function($q2) use ($examRequest) {
              $q2->whereBetween('start_time', [$examRequest->start_time, $examRequest->end_time])
                 ->orWhereBetween('end_time', [$examRequest->start_time, $examRequest->end_time])
                 ->orWhere(function($q3) use ($examRequest) {
                     $q3->where('start_time', '<=', $examRequest->start_time)
                        ->where('end_time', '>=', $examRequest->end_time);
                 });
          });
        })->get();

         // Generate available time slots (you can modify this logic)
          $availableSlots = $this->generateAvailableSlots($examRequest->exam_date);

        return view('backend.examination.exam-schedule.check-availablity', compact('examRequest','availableRooms','availableSlots'));
    }

    private function generateAvailableSlots($examDate)
    {
        // This is a simplified example - you should implement your actual slot generation logic
        $slots = [];
        $startDate = Carbon::parse($examDate);
        
        // Generate sample slots for the next 3 days
        for ($i = 0; $i < 3; $i++) {
            $date = $startDate->copy()->addDays($i);
            $slots[] = [
                'datetime' => $date->format('Y-m-d\T10:00'),
                'display_date' => $date->format('l, F j, Y'),
                'display_time' => '10:00 AM - 11:00 AM'
            ];
            $slots[] = [
                'datetime' => $date->format('Y-m-d\T14:00'),
                'display_date' => $date->format('l, F j, Y'),
                'display_time' => '02:00 PM - 03:00 PM'
            ];
        }
        
        return $slots;
    }

    public function roomAvailability(){
        return view ('backend.examination.exam-schedule.room-availability');
    }

public function assignExam(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $examRequest = ExamRequest::findOrFail($id);

        $request->validate([
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'rooms' => 'required|array|min:1',
            'rooms.*.room_id' => 'required|exists:class_rooms,id',
            'rooms.*.allocated_students' => 'required|integer|min:1',
        ]);

        $examDate = $request->exam_date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        // Validate total allocated students match class requirements
        $totalAllocated = collect($request->rooms)->sum('allocated_students');
        $requiredStudents = $examRequest->class->student_count ?? $totalAllocated;

        if ($totalAllocated < $requiredStudents) {
            return back()->with('error', "Total allocated students ($totalAllocated) is less than required ($requiredStudents).");
        }

        // Check all rooms availability before creating any schedules
        foreach ($request->rooms as $roomData) {
            $roomId = $roomData['room_id'];
            $room = ClassRoom::find($roomId);

            // Check room capacity
            if ($roomData['allocated_students'] > $room->capacity) {
                return back()->with('error', "Room {$room->room_no} capacity exceeded. Max: {$room->capacity}");
            }

            // Check if room is available
            $isAvailable = !ExamSchedule::where('room_id', $roomId)
                ->where('exam_date', $examDate)
                ->where(function($q) use ($startTime, $endTime) {
                    $q->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function($q2) use ($startTime, $endTime) {
                          $q2->where('start_time', '<=', $startTime)
                             ->where('end_time', '>=', $endTime);
                      });
                })->exists();

            if (!$isAvailable) {
                return back()->with('error', "Room {$room->room_no} is already booked for this time slot.");
            }
        }

        // Create exam schedules for all rooms
        foreach ($request->rooms as $roomData) {
            $roomId = $roomData['room_id'];
            $allocated = $roomData['allocated_students'];

            $schedule = ExamSchedule::create([
                'exam_request_id' => $examRequest->id,
                'room_id' => $roomId,
                'exam_date' => $examDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'allocated_students' => $allocated,
                'status' => 'scheduled' // Add status if your table has it
            ]);

            // Update room availability if you're using that table
            if (class_exists('RoomAvailability')) {
                RoomAvailability::updateOrCreate(
                    [
                        'room_id' => $roomId,
                        'exam_date' => $examDate,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ],
                    [
                        'is_booked' => true,
                        'exam_schedule_id' => $schedule->id,
                        // 'exam_request_id' => $examRequest->id
                    ]
                );
            }
        }

        // Update exam request status
        $examRequest->update([
            'status' => \App\Enums\ExamRequestStatus::APPROVED,
            // 'scheduled_at' => now()
        ]);

        DB::commit();

        return redirect()->route('exam-schedule.createExamScheduleType')
            ->with('success', 'Exam scheduled successfully across ' . count($request->rooms) . ' rooms!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        throw $e;
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to schedule exam: ' . $e->getMessage());
    }
}

}
