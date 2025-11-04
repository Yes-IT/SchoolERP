<?php

namespace App\Repositories\Report;

use App\Models\StudentInfo\Student;
use App\Models\StudentInfo\SessionClassStudent;

class StudentReportRepository
{
    public function generateReportData($reportType, $request)
    {
        switch ($reportType) {
            case 'student_home_address':
                return $this->getStudentHomeAddress($request);
            case 'parent_home_address':
                return $this->getParentHomeAddress($request);
            case 'student_name_labels':
                return $this->getStudentNameLabels($request);
            case 'student_name_labels_full_sheet':
                return $this->getStudentNameLabelsFullSheet($request);
            default:
                return [];
        }
    }

    public function getStudentHomeAddress($request)
    {
        $data = Student::query();

        // if ($request->has('session_id')) {
        //     $data->where('session_id', $request->session_id);
        // }

        return $data->get();
    }

    public function getParentHomeAddress($request)
    {
        $data = Student::query();

        // if ($request->has('session_id')) {
        //     $data->where('session_id', $request->session_id);
        // }

        return $data->get();
    }

    public function getStudentNameLabels($request)
    {
        $data = Student::query();

        // if ($request->has('session_id')) {
        //     $data->where('session_id', $request->session_id);
        // }

        return $data->get();
    }

    public function getStudentNameLabelsFullSheet($request)
    {
        $data = Student::query();

        // if ($request->has('session_id')) {
        //     $data->where('session_id', $request->session_id);
        // }

        return $data->get();
    }
}