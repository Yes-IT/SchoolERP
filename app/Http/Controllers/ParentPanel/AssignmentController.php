<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;


class AssignmentController extends Controller
{


    public function index(Request $request)
    {

        $user = Student::where('parent_guardian_id', Auth::user()->id)->first();
        $student = DB::table('students')->where('id', $user->id)->first();

        // ⭐ Get per-page values (default 5)
        // $pendingPerPage = $request->pending_per_page ?? 5;
        // $completedPerPage = $request->completed_per_page ?? 5;

        // Active Tab – default = pending
        $tab = $request->get('tab', 'pending');

        // Pending per page
        $pendingPerPage = $request->input('pending_per_page', 5);

        // Completed per page
        $completedPerPage = $request->input('completed_per_page', 5);

        // ⭐ PENDING ASSIGNMENTS
        $pending = DB::table('assignments')
            ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->whereNull('assignments.grade')
            ->select('assignments.*', 'subjects.name as subject_name')
            ->orderBy('assignments.assigned_date', 'desc')
            // ->paginate(5, ['*'], 'pending_page');
            ->paginate($pendingPerPage, ['*'], 'pending_page');

        // ⭐ COMPLETED ASSIGNMENTS
        $completed = DB::table('assignments')
            ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->whereNotNull('assignments.grade')
            ->select('assignments.*', 'subjects.name as subject_name')
            ->orderBy('assignments.assigned_date', 'desc')
            // ->paginate(5, ['*'], 'completed_page');
            ->paginate($completedPerPage, ['*'], 'completed_page');

        // ⭐ Collect IDs
        $assignmentIds = $pending->pluck('id')->merge($completed->pluck('id'));

        // ⭐ Fetch uploaded media + file size
        $media = DB::table('assignment_media')
            ->whereIn('assignment_id', $assignmentIds)
            ->where('student_id', $student->id)
            ->get()
            ->map(function ($item) {
                $fullPath = public_path($item->path);

                if (file_exists($fullPath)) {
                    $item->size = $this->formatFileSize(filesize($fullPath));
                } else {
                    $item->size = 'N/A';
                }

                return $item;
            })
            ->groupBy('assignment_id');

        // ⭐ Attach media to pending + completed
        foreach ($pending as $item) {
            $item->media = $media[$item->id] ?? collect();
            $item->last_updated = $item->updated_at; // add this
        }

        foreach ($completed as $item) {
            $item->media = $media[$item->id] ?? collect();
            $item->last_updated = $item->updated_at; // add this
        }

        $activeTab = $request->get('tab', 'pending');

        return view('parent-panel.assignment',compact('pending', 'completed', 'activeTab', 'tab'));
    }
    private function formatFileSize($bytes)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        if ($bytes == 0) return '0 B';
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }
}
