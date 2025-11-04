<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Report\StudentReportRepository;
use Illuminate\Support\Facades\Log;
use PDF;
use Exception;
use Throwable;

class StudentReportController extends Controller
{
    protected StudentReportRepository $repo;

    public function __construct(StudentReportRepository $repo)
    {
        $this->repo = $repo;
    }

    protected function getReportConfig(string $reportType): array
    {
        return match ($reportType) {
            'student_home_address' => [
                'view' => 'backend.report.student_reports.pdf.student_home_address_pdf',
            ],
            'parent_home_address' => [
                'view' => 'backend.report.student_reports.pdf.parent_home_address_pdf',
            ],
            'student_name_labels' => [
                'view' => 'backend.report.student_reports.pdf.student_name_labels_pdf',
            ],
            'student_name_labels_full_sheet' => [
                'view' => 'backend.report.student_reports.pdf.student_name_labels_full_pdf',
                'orientation' => 'landscape',
            ],
            default => throw new Exception("Invalid report type: {$reportType}"),
        };
    }

    /**
     * Generate and download a PDF report.
     */
    public function generatePDF(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'paper_size'  => 'required|string|in:A4,letter',
        ]);

        try {
            $reportType = $request->input('report_type');
            $config = $this->getReportConfig($reportType);

            $data = $this->repo->generateReportData($reportType, $request);

            $pdf = PDF::loadView($config['view'], compact('data'))
                ->setPaper(
                    $request->paper_size,
                    $config['orientation'] ?? 'portrait'
                );

            $fileName = sprintf(
                '%s_report_%s.pdf',
                $reportType,
                now()->format('Ymd_His')
            );

            return $pdf->download($fileName);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate PDF report.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Preview the report in browser instead of downloading.
     */
    public function previewReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'paper_size'  => 'nullable|string|in:A4,letter',
        ]);

        try {
            $reportType = $request->input('report_type');
            $config = $this->getReportConfig($reportType);

            $data = $this->repo->generateReportData($reportType, $request);

            $paperSize = $request->input('paper_size', 'A4');

            $pdf = PDF::loadView($config['view'], compact('data'))
                ->setPaper(
                    $paperSize,
                    $config['orientation'] ?? 'portrait'
                );

            $fileName = sprintf('%s_preview_%s.pdf', $reportType, now()->format('Ymd_His'));

            return response($pdf->stream($fileName), 200, [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to preview PDF report.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}