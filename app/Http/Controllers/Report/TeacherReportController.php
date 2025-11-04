<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Report\TeacherReportRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PDF;
use Exception;
use Throwable;

class TeacherReportController extends Controller
{
    protected TeacherReportRepository $repo;

    public function __construct(TeacherReportRepository $repo)
    {
        $this->repo = $repo;
    }

    protected function getReportConfig(string $reportType): array
    {
        return match ($reportType) {
            'teacher_list' => [
                'view' => 'backend.report.teacher_reports.pdf.teacher_list_pdf',
                'orientation' => 'landscape',
            ],
            'teacher_home_address_labels' => [
                'view' => 'backend.report.teacher_reports.pdf.teacher_home_address_labels_pdf',
            ],
            'teacher_name_labels' => [
                'view' => 'backend.report.teacher_reports.pdf.teacher_name_labels_pdf',
            ],
            default => throw new Exception("Invalid report type: {$reportType}"),
        };
    }

    /**
     * Generate and download a PDF report.
     */
    public function generatePDF(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_type'    => 'required|string',
            'session_id'     => 'required|integer',
            'year_status_id' => 'required|integer',
            'class_id'       => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $reportType = $request->input('report_type');
            $config = $this->getReportConfig($reportType);

            $data = $this->repo->generateReportData($reportType, $request);

            $pdf = PDF::loadView($config['view'], compact('data'))
                ->setPaper('A4', $config['orientation'] ?? 'portrait');

            $fileName = sprintf('%s_report_%s.pdf', $reportType, now()->format('Ymd_His'));

            return $pdf->download($fileName);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => 'error',
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
        $validator = Validator::make($request->all(), [
            'report_type'    => 'required|string',
            'session_id'     => 'required|integer',
            'year_status_id' => 'required|integer',
            'class_id'       => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $reportType = $request->input('report_type');
            $config = $this->getReportConfig($reportType);

            $data = $this->repo->generateReportData($reportType, $request);

            $pdf = PDF::loadView($config['view'], compact('data'))
                ->setPaper('A4', $config['orientation'] ?? 'portrait');

            $fileName = sprintf('%s_preview_%s.pdf', $reportType, now()->format('Ymd_His'));

            // return response($pdf->stream($fileName), 200, [
            //     'Content-Type' => 'application/pdf',
            //     'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            // ]);

            return $pdf->stream($fileName, [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma'        => 'no-cache',
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