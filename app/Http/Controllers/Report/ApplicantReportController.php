<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Report\ApplicantReportRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PDF;
use Exception;
use Throwable;

class ApplicantReportController extends Controller
{
    protected ApplicantReportRepository $repo;

    public function __construct(ApplicantReportRepository $repo)
    {
        $this->repo = $repo;
    }

    protected function getReportConfig(string $reportOption): array
    {
        return match ($reportOption) {
            'applicant_status_by_name' => [
                'view' => 'backend.report.applicant_reports.pdf.applicant_status_by_name',
            ],
            'applicant_status_by_school' => [
                'view' => 'backend.report.applicant_reports.pdf.applicant_status_by_school',
            ],
            'applicant_status_by_camp' => [
                'view' => 'backend.report.applicant_reports.pdf.applicant_status_by_camp',
            ],
            'applicant_status_by_status' => [
                'view' => 'backend.report.applicant_reports.pdf.applicant_status_by_status',
            ],
            default => throw new Exception("Invalid report type: {$reportOption}"),
        };
    }

    public function generateReport(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'report_type'       => 'required|string',
            'report_option'       => 'required|string',
            'school_year'        => 'required|integer',
            'export_format'    => 'required|string|in:pdf',
            'is_preview'       => 'required|boolean',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validated->errors(),
            ], 422);
        }

        try {
            $reportOption = $request->input('report_option');
            $exportFormat = $request->input('export_format');
            $isPreview = $request->boolean('is_preview', false);

            $config = $this->getReportConfig($reportOption);
            $data = $this->repo->generateReportData($reportOption, $request);

            switch ($exportFormat) {
                case 'pdf':
                    return $isPreview
                        ? $this->previewPDF($reportOption, $config, $data)
                        : $this->generatePDF($reportOption, $config, $data);
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unsupported export format.'
                    ], 400);
            }

        } catch (Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to generate PDF report.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    protected function generatePDF($reportOption, array $config, $data)
    {
        $pdf = PDF::loadView($config['view'], compact('data'))
            ->setPaper('A4', $config['orientation'] ?? 'portrait');

        $fileName = sprintf('%s_report_%s.pdf', $reportOption, now()->format('Ymd_His'));
        return $pdf->download($fileName);
    }

    protected function previewPDF($reportOption, array $config, $data)
    {
        $pdf = PDF::loadView($config['view'], compact('data'))
            ->setPaper('A4', $config['orientation'] ?? 'portrait');

        $fileName = sprintf('%s_preview_%s.pdf', $reportOption, now()->format('Ymd_His'));
        return $pdf->stream($fileName, [
            'Content-Type'  => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
        ]);
    }
}