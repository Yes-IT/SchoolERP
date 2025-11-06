<?php

namespace App\Repositories\Report;

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
        return [];
    }

    public function getAlumniHomeAddressLabels($request)
    {
        return [];
    }
}