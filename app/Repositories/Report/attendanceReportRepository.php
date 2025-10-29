<?php

namespace App\Repositories\Report;

use App\Interfaces\Report\AttendanceReportInterface;
use App\Models\Academic\Semester;
use App\Models\Attendance\Attendance;
use App\Models\StudentInfo\Student;
use App\Models\Academic\Classes;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AttendanceReportRepository implements AttendanceReportInterface
{
    protected array $reportHandlers = [
        'attendance-student'        => 'handleStudentAttendance',
        'attendance-details-class'  => 'handleClassAttendanceDetails',
        'class-absences-summary'    => 'handleClassAbsencesSummary',
        'excessive-absence-student' => 'handleExcessiveAbsenceStudent',
        'excessive-absence-class'   => 'handleExcessiveAbsenceClass',
    ];

    public function generateReport(array $data): array
    {
        try {
            $pdfs = [];
            $html = null;

            foreach ($data['report_types'] ?? [] as $type) {
                $handler = $this->reportHandlers[$type] ?? null;
                if (!$handler || !method_exists($this, $handler)) {
                    Log::warning("Invalid report type: {$type}");
                    continue;
                }

                $result = $this->{$handler}($data);

                $viewData = array_merge($result['viewData'], [
                    'data' => $data,
                    'generated_at' => now(),
                ]);

                $view = $this->getViewByType($type);
                $pdf = Pdf::loadView($view, $viewData)
                    ->setPaper('a4')
                    ->setOptions(['defaultFont' => 'DejaVu Sans']);

                $filename = $this->generateFilename(
                    $type,
                    $result['filename_id'] ?? 0,
                    $data['start_date'],
                    $data['end_date']
                );

                $base64 = 'data:application/pdf;base64,' . base64_encode($pdf->output());
                $pdfs[] = compact('filename', 'base64');

                if (!empty($data['print_preview']) && count($data['report_types']) === 1) {
                    $html = view($view, $viewData)->render();
                }
            }

            return compact('pdfs', 'html');
        } catch (\Throwable $e) {
            Log::error('Report Error: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            throw $e;
        }
    }

    // ==================== HANDLERS ====================

    protected function handleStudentAttendance(array $data): array
    {
        $student = Student::select('id', 'first_name', 'last_name', 'admission_no')
            ->findOrFail($data['student_id']);

        $student->full_name = $student->first_name . ' ' . $student->last_name;
        $student->class_name = $student->currentClass?->name ?? 'N/A';

        $attendances = Attendance::with(['class:id,name'])
            ->where('student_id', $data['student_id'])
            ->where('session_id', $data['school_year'])
            ->where('year_status_id', $data['year_status'])
            ->where('semester_id', $data['semester'])
            ->whereBetween('date', [Carbon::parse($data['start_date']), Carbon::parse($data['end_date'])])
            ->where('attendance', 4)
            ->orderBy('date')
            ->get();

        $subjectStats = $this->calculateSubjectTotals($attendances);

        return [
            'viewData' => [
                'student' => $student,
                'attendances' => $attendances,
                'startDate' => Carbon::parse($data['start_date']),
                'endDate' => Carbon::parse($data['end_date']),
                'semesterName' => Semester::find($data['semester'])->name,
                'subjectStats' => $subjectStats,
            ],
            'filename_id' => $data['student_id']
        ];
    }

    protected function handleClassAttendanceDetails(array $data): array
    {
        $studentId = $data['student_id']; // We have student_id from form

        // Get ONE attendance record to extract class_id
        $sample = Attendance::where('student_id', $studentId)
            ->where('session_id', $data['school_year'])
            ->where('year_status_id', $data['year_status'])
            ->where('semester_id', $data['semester'])
            ->whereBetween('date', [
                Carbon::parse($data['start_date'])->format('Y-m-d'),
                Carbon::parse($data['end_date'])->format('Y-m-d')
            ])
            ->first();
            

        if (!$sample) {
            throw new \Exception("No attendance records found for this student in the selected period.");
        }

        $classId = $sample->classes_id;
        $class   = Classes::findOrFail($classId);

        $attendances = Attendance::with(['student:id,first_name,last_name'])
            ->where('classes_id', $classId)
            ->where('session_id', $data['school_year'])
            ->where('year_status_id', $data['year_status'])
            ->where('semester_id', $data['semester'])
            ->whereBetween('date', [
                Carbon::parse($data['start_date']),
                Carbon::parse($data['end_date'])
            ])
            ->get()
            ->groupBy('student_id');

        return [
            'viewData' => [
                'class'        => $class,
                'attendances'  => $attendances,
                'startDate'    => Carbon::parse($data['start_date']),
                'endDate'      => Carbon::parse($data['end_date']),
                'semesterName' => Semester::find($data['semester'])->name,
            ],
            'filename_id' => $classId
        ];
    }
    

    protected function handleClassAbsencesSummary(array $data): array
    {
        $summary = Attendance::selectRaw('
                student_id,
                COUNT(CASE WHEN attendance = 4 THEN 1 END) as absent,
                COUNT(CASE WHEN attendance = 3 THEN 1 END) as late,
                COUNT(*) as total
            ')
            ->where('class_id', $data['class_id'])
            ->where('session_id', $data['school_year'])
            ->where('year_status_id', $data['year_status'])
            ->where('semester_id', $data['semester'])
            ->groupBy('student_id')
            ->with('student:id,first_name,last_name')
            ->get()
            ->map(function ($row) {
                $row->rate = $row->total > 0 ? round((($row->total - $row->absent) / $row->total) * 100, 1) : 0;
                return $row;
            });

        return [
            'viewData' => [
                'class' => Classes::find($data['class_id']),
                'summary' => $summary,
                'semesterName' => Semester::find($data['semester'])->name,
            ],
            'filename_id' => '2'
        ];
    }


    protected function handleExcessiveAbsenceStudent(array $data): array
    {
        $startDate = Carbon::parse($data['start_date']);
        $endDate   = Carbon::parse($data['end_date']);

        // 1. Get every student who has at least one absence in the period
        $absences = Attendance::query()
            ->selectRaw('student_id, COUNT(*) as total_absent')
            ->where('session_id', $data['school_year'])
            ->where('year_status_id', $data['year_status'])
            ->where('semester_id', $data['semester'])
            ->where('attendance', 4) // 4 = Absent
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('student_id')
            ->havingRaw('COUNT(*) > 0') // ensures at least one absence
            ->orderByDesc('total_absent')
            ->get();

        // 2. Load student details + current class in ONE query
        $studentIds = $absences->pluck('student_id')->all();

        $students = Student::whereIn('id', $studentIds)
            ->get()
            ->keyBy('id');

        // 3. Combine: student model + absence count
        $result = $absences->map(function ($row) use ($students) {
            $student = $students->get($row->student_id);

            return [
                'student' => $student,
                'count'   => $row->total_absent,
            ];
        });

        return [
            'viewData' => [
                'students'     => $result,
                'semesterName' => Semester::find($data['semester'])->name ?? 'N/A',
                'dateRange'    => [
                    'start' => $startDate->format('d M Y'),
                    'end'   => $endDate->format('d M Y'),
                ],
            ],
            'filename_id' => 2
        ];
    }

    protected function handleExcessiveAbsenceClass(array $data): array
    {
        $threshold = $data['absence_threshold'] ?? 15;
        $classes = Classes::whereHas('attendances', function ($q) use ($data, $threshold) {
            $q->where('session_id', $data['school_year'])
              ->where('year_status_id', $data['year_status'])
              ->where('semester_id', $data['semester'])
              ->where('attendance', 4)
              ->groupBy('class_id')
              ->havingRaw('COUNT(*) > ?', [$threshold]);
        })->get();

        return [
            'viewData' => [
                'classes' => $classes,
                'threshold' => $threshold,
                'semesterName' => Semester::find($data['semester'])->name,
            ],
            'filename_id' => 'excessive_class'
        ];
    }

    // ==================== HELPERS ====================

    protected function calculateSubjectTotals(Collection $attendances): Collection
    {
        return $attendances->groupBy('subject_id')->map(function ($rows) {
            $total = $rows->count();
            $E = $rows->where('excused', 1)->count();
            $P = $rows->where('attendance', 1)->count();
            $P_star = $rows->where('attendance', 3)->count();
            $NC = $total - $E - $P - $P_star;
            $percent = $total > 0 ? round((($P + $P_star) / $total) * 100, 1) : 0;

            return [
                'name' => $rows->first()->subject?->name ?? 'Unknown',
                'E' => $E,
                'P' => $P,
                'P_star' => $P_star,
                'NC' => $NC,
                'percent' => $percent,
                'points' => 0
            ];
        })->values();
    }

    protected function getViewByType(string $type): string
    {
        return match ($type) {
            'attendance-student'        => 'backend.report.attendance.pdf.by_student',
            'attendance-details-class'  => 'backend.report.attendance.pdf.by_class',
            'class-absences-summary'    => 'backend.report.attendance.pdf.class_summary',
            'excessive-absence-student' => 'backend.report.attendance.pdf.excessive_student',
            'excessive-absence-class'   => 'backend.report.attendance.pdf.excessive_class',
        };
    }

    protected function generateFilename(string $type, int $id, string $start, string $end): string
    {
        $prefix = str_replace('-', '_', $type);
        $range = str_replace('-', '', $start) . '_to_' . str_replace('-', '', $end);
        return "{$prefix}_{$id}_{$range}.pdf";
    }

    // ==================== INTERFACE METHODS ====================

    public function getStudentAttendance(int $studentId, string $startDate, string $endDate): Collection
    {
        return Attendance::where('student_id', $studentId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
    }

    public function generatePdf(string $view, array $data, string $filename): string
    {
        $pdf = Pdf::loadView($view, $data)
            ->setPaper('a4')
            ->setOptions(['defaultFont' => 'DejaVu Sans']);
        return 'data:application/pdf;base64,' . base64_encode($pdf->output());
    }
}