<?php

namespace App\Services;

use App\Interfaces\Staff\ExamRequestInterface;
use Carbon\Carbon;

class ExamRequestService
{
    protected $examRequestRepository;

    public function __construct(ExamRequestInterface $examRequestRepository)
    {
        $this->examRequestRepository = $examRequestRepository;
    }

    public function createExamRequest(array $data)
    {
        // Calculate duration
        $start = Carbon::parse($data['start_time']);
        $end = Carbon::parse($data['end_time']);
        $data['duration'] = $start->diffInMinutes($end);

        // Create exam request
        return $this->examRequestRepository->create($data);
    }

    public function getAvailableRooms($examDate, $startTime, $endTime)
    {
        return $this->examRequestRepository->getAvailableRooms($examDate, $startTime, $endTime);
    }
}