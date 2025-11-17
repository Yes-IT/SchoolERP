<?php

namespace App\Interfaces\Applicant;

interface ApplicantInterface
{
    public function getAllApplicants();
    public function getApplicantById($id);
    public function createApplicant(array $data);
    public function updateApplicant($id, array $data);
    public function deleteApplicant($id);
    public function getSlotsBetween($date, $startTime, $endTime);
    public function saveInterviewSchedule($data);
    public function getSlotsForWeek($startDate, $endDate);
    public function updateInterviewSchedule($data);
    public function getApplicantNames();
    public function checkOverlappingSlots($date, $startTime, $endTime, $excludeApplicantId = null);
    public function toggleInterviewDetails($id);
}
