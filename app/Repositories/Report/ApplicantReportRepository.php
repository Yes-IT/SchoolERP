<?php

namespace App\Repositories\Report;

use App\Models\Session;
use App\Models\Applicant\Applicant;
use App\Models\Applicant\ApplicationProcessing;

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
        $query = Applicant::query()
            ->select([
                'applicants.id',
                'applicants.first_name',
                'applicants.last_name',
                'applicants.session_id',
                'sessions.name as session_name',
            ])
            ->leftJoin('sessions', 'sessions.id', '=', 'applicants.session_id');

        if ($request->filled('school_year') && $request->school_year !== 'all') {
            $query->where('applicants.session_id', $request->school_year);
        }

        $data = $query->orderBy('applicants.last_name')->get();

        return ['applicants' => $data];
    }

    public function getApplicantStatusBySchool(Request $request)
    {
        $query = Applicant::query()
            ->select([
                'applicants.id',
                'applicants.first_name',
                'applicants.last_name',
                'hs.hs_name as high_school_name',
                'sessions.name as session_name',
            ])
            ->leftJoin('high_schools as hs', 'hs.id', '=', 'applicants.high_school_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'applicants.session_id');

        // Filter by session (school year)
        if ($request->filled('school_year') && $request->school_year !== 'all') {
            $query->where('applicants.session_id', $request->school_year);
        }

        // Filter by specific high school
        if ($request->filled('high_school') && $request->high_school !== 'all') {
            $query->where('applicants.high_school_id', $request->high_school);
            $data = $query->get();

            $schoolName = optional($data->first())->high_school_name ?? 'Unknown School';

            return [
                'grouped'     => false,
                'schoolName'  => $schoolName,
                'applicants'  => $data,
            ];
        }

        // Otherwise group by school
        $data = $query->get()->groupBy('high_school_name');

        return [
            'grouped'            => true,
            'groupedApplicants'  => $data,
        ];
    }

    public function getApplicantStatusByCamp(Request $request)
    {
        $query = Applicant::query()
            ->select([
                'applicants.id',
                'applicants.first_name',
                'applicants.last_name',
                'applicant_camps.camp as camp_name',
                'sessions.name as session_name',
            ])
            ->leftJoin('applicant_camps', 'applicant_camps.applicant_id', '=', 'applicants.id')
            ->leftJoin('sessions', 'sessions.id', '=', 'applicants.session_id');

        // Filter by school year
        if ($request->filled('school_year') && $request->school_year !== 'all') {
            $query->where('applicants.session_id', $request->school_year);
        }

        // Group by camp
        $groupedApplicants = $query->get()->groupBy('camp_name');

        return [
            'groupedApplicants' => $groupedApplicants,
        ];
    }

    public function getApplicantStatusByStatus(Request $request)
    {
        $query = Applicant::query()
            ->select([
                'applicants.id',
                'applicants.first_name',
                'applicants.last_name',
                'high_schools.hs_name',
                'sessions.name as session_name',
            ])
            ->leftJoin('high_schools', 'high_schools.id', '=', 'applicants.high_school_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'applicants.session_id');

        // Filter by school year
        if ($request->filled('school_year') && $request->school_year !== 'all') {
            $query->where('applicants.session_id', $request->school_year);
        }

        $groupedApplicants = $query->get()->groupBy(function ($item) {
            return $item->applicant_status?->value ?? 'unknown';
        });

        return [
            'groupedApplicants' => $groupedApplicants,
        ];
    }

    // Accepted Applicant 
    public function responseListByName(Request $request)
    {
        $query = Applicant::query()
            ->select([
                'applicants.id',
                'applicants.first_name',
                'applicants.last_name',
                'applicants.session_id',
                'sessions.name as session_name',
                'ipr.id as interview_id',
                'ipr.coming',
            ])
            ->leftJoin('interview_processing as ipr', 'ipr.applicant_id', '=', 'applicants.id')
            ->leftJoin('sessions', 'sessions.id', '=', 'applicants.session_id')
            ->where('applicants.applicant_status', 'accept');

        if ($request->filled('school_year') && $request->school_year !== 'all') {
            $query->where('applicants.session_id', $request->school_year);
        }

        $response = $query->orderBy('applicants.last_name')->get();

        return ['response' => $response];
    }

    public function responseListByHighSchool(Request $request)
    {
        $query = Applicant::query()
            ->select([
                'applicants.id',
                'applicants.first_name',
                'applicants.last_name',
                'applicants.session_id',
                'sessions.name as session_name',
                'ipr.coming',
                'high_schools.hs_name',
            ])
            ->leftJoin('interview_processing as ipr', 'ipr.applicant_id', '=', 'applicants.id')
            ->leftJoin('high_schools', 'high_schools.id', '=', 'applicants.high_school_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'applicants.session_id')
            ->where('applicants.applicant_status', 'accept');

        if ($request->filled('school_year') && $request->school_year !== 'all') {
            $query->where('applicants.session_id', $request->school_year);
        }

        $grouped = $query->get()->groupBy('hs_name');

        $response = $grouped->map(function ($applicants, $schoolName) {
            $sessionName = optional($applicants->first())->session_name ?? 'Unknown';
            $totalApplicants = $applicants->count();
            $totalComing = $applicants->where('coming', 'yes')->count();

            return [
                'session_name'           => $sessionName,
                'high_school_name'       => $schoolName ?: 'Unknown',
                'total_applicant_count'  => $totalApplicants,
                'total_coming_count'     => $totalComing,
                'applicants'             => $applicants->map(fn ($a) => [
                    'id'         => $a->id,
                    'first_name' => $a->first_name,
                    'last_name'  => $a->last_name,
                    'coming'     => $a->coming,
                ])->values(),
            ];
        })->values();

        return ['response' => $response];
    }

    public function responseListByResponse(Request $request)
    {
        return [];
    }

}