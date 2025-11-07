<?php

namespace App\Repositories\Report;

use App\Models\Applicant\Applicant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicantReportRepository
{
    public function generateReportData($reportType, $request)
    {
        switch ($reportType) {
            case 'applicant_status_by_name':
                return $this->getApplicantStatusListByName($request);
            case 'applicant_status_by_school':
                return $this->getApplicantStatusBySchool($request);
            case 'applicant_status_by_camp':
                return $this->getApplicantStatusByCamp($request);
            case 'applicant_status_by_status':
                return $this->getApplicantStatusByStatus($request);
            default:
                return [];
        }
    }

    public function getApplicantStatusListByName(Request $request)
    {
        $query = Applicant::query();

        if ($request->filled('school_year') && $request->year_status !== 'all') {
            $query->where('session_id', $request->year_status);
        }

        $data = $query->get();

        return [
            'applicants' => $data,
        ];
    }

    public function getApplicantStatusBySchool(Request $request)
    {
        $query = Applicant::query()
            ->select([
                'applicants.*',
                'hs.hs_name as high_school_name',
            ])
            ->join('high_schools as hs', 'hs.id', '=', 'applicants.high_school_id');

        if ($request->filled('year_status') && $request->year_status !== 'all') {
            $query->where('applicants.session_id', $request->year_status);
        }

        // if a single high school is selected
        if ($request->filled('high_school') && $request->high_school !== 'all') {
            $query->where('applicants.high_school_id', $request->high_school);
            $data = $query->get();

            $schoolName = optional($data->first())->high_school_name ?? 'Unknown School';

            return [
                'grouped' => false,
                'schoolName' => $schoolName,
                'applicants' => $data,
            ];
        }

        // otherwise, show all schools grouped
        $data = $query->get()->groupBy('high_school_name');

        return [
            'grouped' => true,
            'groupedApplicants' => $data,
        ];
    }

    public function getApplicantStatusByCamp(Request $request)
    {
        $query = Applicant::query()
            ->select('applicants.*', 'applicant_camps.camp as camp_name')
            ->join('applicant_camps', 'applicant_camps.applicant_id', '=', 'applicants.id');

        if ($request->filled('year_status') && $request->year_status !== 'all') {
            $query->where('applicants.session_id', $request->year_status);
        }

        // Group applicants by camp name
        $groupedApplicants = $query->get()->groupBy('camp_name');

        return [
            'groupedApplicants' => $groupedApplicants
        ];
    }

    public function getApplicantStatusByStatus(Request $request)
    {
        $query = Applicant::query()
            ->select('applicants.*', 'high_schools.hs_name')
            ->leftJoin('high_schools', 'high_schools.id', '=', 'applicants.high_school_id');

        if ($request->filled('school_year') && $request->year_status !== 'all') {
            $query->where('session_id', $request->year_status);
        }

        // Get applicants and group by enum value (string)
        $groupedApplicants = $query->get()->groupBy(function ($item) {
            return $item->applicant_status?->value ?? 'unknown';
        });

        return [
            'groupedApplicants' => $groupedApplicants,
        ];
    }


}