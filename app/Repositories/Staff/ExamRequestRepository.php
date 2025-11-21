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
        $bookedRooms = DB::table('exam_requests')
            ->where('exam_date', $examDate)
            ->where('status', 'approved')
            ->where(function($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<=', $startTime)
                         ->where('end_time', '>=', $endTime);
                  });
            })
            ->pluck('room_id');

        return ClassRoom::where('status', 1)
            ->whereNotIn('id', $bookedRooms)
            ->get(['id', 'name', 'capacity']);
    }
}