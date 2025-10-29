<?php

namespace App\Interfaces\Report;

use Illuminate\Support\Collection;

interface AttendanceReportInterface
{
    /**
     * Generate one or more attendance reports.
     */
    public function generateReport(array $data): array;

    /**
     * Optional: Get raw attendance data.
     */
    public function getStudentAttendance(int $studentId, string $startDate, string $endDate): Collection;

    /**
     * Optional: Generate standalone PDF.
     */
    public function generatePdf(string $view, array $data, string $filename): string;
}