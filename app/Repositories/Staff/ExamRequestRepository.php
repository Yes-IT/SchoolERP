<?php

namespace App\Repositories\Staff;

use App\Models\Examination\ExamRequest;
use App\Models\Academic\ClassRoom;
use App\Interfaces\Staff\ExamRequestInterface;
use Illuminate\Support\Facades\{DB,Log};

class ExamRequestRepository implements ExamRequestInterface
{
    protected $model;

    public function __construct(ExamRequest $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getAvailableRooms($examDate, $startTime, $endTime)
    {

        Log::info('Repository getAvailableRooms called:', [
            'exam_date' => $examDate,
            'start_time' => $startTime,
            'end_time' => $endTime
        ]);

         try {
                $bookedRooms = DB::table('exam_requests')
                    ->where('exam_date', $examDate)
                    ->where('status', 'approved')
                    ->where(function($query) use ($startTime, $endTime) {
                        $query->where(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>', $startTime);
                        })->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<', $endTime)
                            ->where('end_time', '>=', $endTime);
                        })->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '>=', $startTime)
                            ->where('end_time', '<=', $endTime);
                        });
                    })
                    ->pluck('room_id');

                Log::info('Booked rooms found:', ['booked_rooms' => $bookedRooms->toArray()]);

                $availableRooms = ClassRoom::where('status', 1)
                    ->whereNotIn('id', $bookedRooms)
                    ->get(['id', 'room_no', 'capacity']);

                Log::info('Available rooms query result:', ['count' => $availableRooms->count()]);

                return $availableRooms;

            } catch (\Exception $e) {
                Log::error('Error in repository getAvailableRooms:', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                throw $e;
            }
    }
}