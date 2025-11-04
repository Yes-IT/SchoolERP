<?php

namespace App\Repositories\Report;
use App\Models\Academic\Classes;
use App\Models\Session;

class AlumniReportRepository
{
    public function getSessions($id)
    {
        return Session::where('id', $id)->get(['id', 'name']);
    }

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
        return [];
    }

    public function getAlumniHomeAddressLabels($request)
    {
        return [];
    }
}