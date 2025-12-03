<?php


namespace App\Interfaces\Staff;

interface ExamRequestInterface
{
    public function create(array $data);
    public function getAvailableRooms($examDate, $startTime, $endTime);
    public function getUpcomingExams($teacherId);
    public function getRequestedExams($teacherId);
}