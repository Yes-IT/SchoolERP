<?php
namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Repositories\Report\AttendanceReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AttendanceReportController extends Controller
{
    protected $reportRepo;

    public function __construct(AttendanceReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }

    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_types'   => 'required|array|min:1',
            'report_types.*' => 'in:attendance-student,attendance-details-class,class-absences-summary,excessive-absence-student,excessive-absence-class',
            'student_id'     => 'required_if:report_types,attendance-student,excessive-absence-student',
            'class_id'       => 'required_if:report_types,attendance-details-class,class-absences-summary,excessive-absence-class',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'absence_threshold' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->reportRepo->generateReport($request->all());

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Attendance Report Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'PDF Error: ' . $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ], 500);
        }
    }

}