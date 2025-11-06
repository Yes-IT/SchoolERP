<?php

namespace App\Repositories\Report;

use App\Models\Session;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\DB;

class AlumniReportRepository
{
    public function generateReportData($reportType, $request)
    {
        switch ($reportType) {
            case 'alumni_list':
                return $this->getAlumniList($request);
            case 'alumni_home_address_labels':
                return $this->getAlumniHomeAddressLabels($request);
            default:
                return [];
        }
    }

    public function getAlumniList($request)
    {
        $query = Student::query()
            ->select([
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.residance_address',
                'students.city',
                'students.state',
                'students.zip_code',
                'students.country',
                'students.cell_usa',
                'students.cell_israel',
                'students.email',
                'classes.name as class_name',
                'sessions.name as session_name',
                'year_status.name as year_status_name',
            ])
            ->join('student_class_mapping', 'student_class_mapping.student_id', '=', 'students.id')
            ->join('classes', 'classes.id', '=', 'student_class_mapping.class_id')
            ->join('sessions', 'sessions.id', '=', 'classes.session_id')
            ->join('year_status', 'year_status.id', '=', 'classes.year_status_id')
            ->where('classes.session_id', $request->school_year);

        if ($request->year_status !== 'all') {
            $query->where('classes.year_status_id', $request->year_status);
        }

        $sortBy = $request->sort_order ?? 'name';

        if ($sortBy === 'year') {
            $query->orderBy('year_status.name');
        } else {
            $query->orderBy('students.last_name')->orderBy('students.first_name');
        }

        $data = $query->get();

        $schoolYearName = $data->first()->session_name ?? null;
        $yearStatusName = ($request->year_status === 'all')
            ? 'All Years'
            : ($data->first()->year_status_name ?? null);

        return [
            'alumni' => $data,
            'school_year' => $schoolYearName,
            'year_status' => $yearStatusName,
        ];
    }

    public function getAlumniHomeAddressLabels($request)
    {
        $query = Student::query()
            ->select([
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.residance_address',
                'students.city',
                'students.state',
                'students.zip_code',
                'students.country',
                'students.cell_usa',
                'students.cell_israel',
                'students.email',
                'classes.name as class_name',
                'sessions.name as session_name',
                'year_status.name as year_status_name',
            ])
            ->join('student_class_mapping', 'student_class_mapping.student_id', '=', 'students.id')
            ->join('classes', 'classes.id', '=', 'student_class_mapping.class_id')
            ->join('sessions', 'sessions.id', '=', 'classes.session_id')
            ->join('year_status', 'year_status.id', '=', 'classes.year_status_id')
            ->where('classes.session_id', $request->school_year);

        if ($request->year_status !== 'all') {
            $query->where('classes.year_status_id', $request->year_status);
        }

        $sortBy = $request->sort_order ?? 'name';

        if ($sortBy === 'year') {
            $query->orderBy('year_status.name');
        } else {
            $query->orderBy('students.last_name')->orderBy('students.first_name');
        }

        $data = $query->get();

        return $data;


    }
}