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

    protected function getReportConfig(string $reportType): array
    {
        return match ($reportType) {
            'alumni_list' => [
                'view' => 'backend.report.alumni_reports.pdf.alumni_list_pdf',
                'orientation' => 'landscape',
            ],
            'alumni_home_address_labels' => [
                'view' => 'backend.report.alumni_reports.pdf.alumni_home_address_labels_pdf',
            ],
            default => throw new Exception("Invalid report type: {$reportType}"),
        };
    }

    public function generateReport(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'report_type'       => 'required|string|in:alumni_list,alumni_home_address_labels',
            'school_year'        => 'required|integer',
            'year_status'    => 'required|string',
            'sort_order'        => 'required|string|in:name,year',
            'show_year'        => 'sometimes|boolean',
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
            $reportType = $request->input('report_type');
            $exportFormat = $request->input('export_format');
            $isPreview = $request->boolean('is_preview', false);

            $config = $this->getReportConfig($reportType);
            $data = $this->repo->generateReportData($reportType, $request);

            switch ($exportFormat) {
                case 'pdf':
                    return $isPreview
                        ? $this->previewPDF($reportType, $config, $data)
                        : $this->generatePDF($reportType, $config, $data);
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

    protected function generatePDF($reportType, array $config, $data)
    {
        $pdf = PDF::loadView($config['view'], compact('data'))
            ->setPaper('A4', $config['orientation'] ?? 'portrait');

        $fileName = sprintf('%s_report_%s.pdf', $reportType, now()->format('Ymd_His'));
        return $pdf->download($fileName);
    }

    protected function previewPDF($reportType, array $config, $data)
    {
        $pdf = PDF::loadView($config['view'], compact('data'))
            ->setPaper('A4', $config['orientation'] ?? 'portrait');

        $fileName = sprintf('%s_preview_%s.pdf', $reportType, now()->format('Ymd_His'));
        return $pdf->stream($fileName, [
            'Content-Type'  => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
        ]);
    }
}