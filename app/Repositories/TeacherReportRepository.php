<?php

namespace App\Repositories\Report;
use App\Models\Academic\Classes;

class TeacherReportRepository
{
    public function generateReportData($reportType, $request)
    {
        switch ($reportType) {
            case 'teacher_list':
                return $this->getTeacherList($request);
            case 'teacher_home_address_labels':
                return $this->getTeacherHomeAddressLabels($request);
            case 'teacher_name_labels':
                return $this->getTeacherNameLabels($request);
            default:
                return [];
        }
    }

    public function getTeacherList($request)
    {
        $sessionId = $request->input('session_id');
        $yearStatusId = $request->input('year_status_id');
        $classId = $request->input('class_id');

        $teachers = Classes::with('teacher')
            ->where('session_id', $sessionId)
            ->where('year_status_id', $yearStatusId)
            ->where('id', $classId)
            ->get()
            ->pluck('teacher')
            ->filter()
            ->unique('id')
            ->values();

        return $teachers;
    }

    public function getTeacherHomeAddressLabels($request)
    {
        return [];
    }

    public function getTeacherNameLabels($request)
    {
        return [];
    }
}