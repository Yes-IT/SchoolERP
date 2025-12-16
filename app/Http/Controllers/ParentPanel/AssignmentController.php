<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB,Log};
use PDF;



class AssignmentController extends Controller
{


    // public function index(Request $request)
    // {

    //     $user = Student::where('parent_guardian_id', Auth::user()->id)->first();
    //     // dd($user);

    //     $student = DB::table('students')->where('id', $user->id)->first();

    //     $tab = $request->get('tab', 'pending');

    //     $pendingPerPage = $request->input('pending_per_page', 5);

    //     $completedPerPage = $request->input('completed_per_page', 5);

    //     $pending = DB::table('assignments')
    //         ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
    //         ->whereNull('assignments.grade')
    //         ->select('assignments.*', 'subjects.name as subject_name')
    //         ->orderBy('assignments.assigned_date', 'desc')
    //         ->paginate($pendingPerPage, ['*'], 'pending_page');

    //     $completed = DB::table('assignments')
    //         ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
    //         ->whereNotNull('assignments.grade')
    //         ->select('assignments.*', 'subjects.name as subject_name')
    //         ->orderBy('assignments.assigned_date', 'desc')
    //         ->paginate($completedPerPage, ['*'], 'completed_page');

    //     $assignmentIds = $pending->pluck('id')->merge($completed->pluck('id'));

    //     // Fetch uploaded media + file size
    //     $media = DB::table('assignment_media')
    //         ->whereIn('assignment_id', $assignmentIds)
    //         ->where('student_id', $student->id)
    //         ->get()
    //         ->map(function ($item) {
    //             $fullPath = public_path($item->path);

    //             if (file_exists($fullPath)) {
    //                 $item->size = $this->formatFileSize(filesize($fullPath));
    //             } else {
    //                 $item->size = 'N/A';
    //             }

    //             return $item;
    //         })
    //         ->groupBy('assignment_id');

    //     foreach ($pending as $item) {
    //         $item->media = $media[$item->id] ?? collect();
    //         $item->last_updated = $item->updated_at; 
    //     }

    //     foreach ($completed as $item) {
    //         $item->media = $media[$item->id] ?? collect();
    //         $item->last_updated = $item->updated_at; 
    //     }

    //     $activeTab = $request->get('tab', 'pending');

    //     return view('parent-panel.assignment',compact('pending', 'completed', 'activeTab', 'tab'));
    // }


    //changes by nazmin
    public function index(Request $request)
    {
        try {

            $student = request()->get('currentStudent');
            $studentId = $student->id;

            // dd($studentId);

            $tab = $request->get('tab', 'pending');
            $activeTab = $tab;

            $pendingPerPage = $request->input('pending_per_page', 5);
            $completedPerPage = $request->input('completed_per_page', 5);

            $pending = DB::table('assignments')
                ->leftJoin('assignment_submissions', function ($join) use ($studentId) {
                    $join->on('assignments.id', '=', 'assignment_submissions.assignment_id')
                        ->where('assignment_submissions.student_id', '=', $studentId);
                })
                ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
                ->where(function ($q) {
                    $q->whereNull('assignment_submissions.id')   
                    ->orWhere('assignment_submissions.status', 0); 
                })
                ->select(
                    'assignments.*',
                    'subjects.name as subject_name',
                    'assignment_submissions.status as submit_status'
                )
                ->orderBy('assignments.assigned_date', 'desc')
                ->paginate($pendingPerPage)
                ->appends([
                    'tab' => 'pending',
                    'pending_per_page' => $pendingPerPage
                ]);

            // Log::info('Pending Assignment IDs:', $pending->pluck('id')->toArray());

            $completed = DB::table('assignments')
                ->join('assignment_submissions', function ($join) use ($studentId) {
                    $join->on('assignments.id', '=', 'assignment_submissions.assignment_id')
                        ->where('assignment_submissions.student_id', '=', $studentId)
                        ->whereIn('assignment_submissions.status', [1, 2]); // submitted / evaluated
                })
                ->leftJoin('subjects', 'assignments.subject_id', '=', 'subjects.id')
                ->select(
                    'assignments.*',
                    'subjects.name as subject_name',
                    'assignment_submissions.status as submit_status',
                    'assignment_submissions.grade',
                    'assignment_submissions.percentage',
                    'assignment_submissions.note',
                    'assignment_submissions.file_path'
                )
                ->orderBy('assignments.assigned_date', 'desc')
                ->paginate($completedPerPage)
                ->appends([
                    'tab' => 'completed',
                    'completed_per_page' => $completedPerPage
                ]);

            // Log::info('Completed Assignment IDs:', $completed->pluck('id')->toArray());

            $assignmentIds = collect($pending->items())
                            ->pluck('id')
                            ->merge(collect($completed->items())->pluck('id'))
                            ->filter()        
                            ->unique()
                            ->values();

            // Log::info('Merged Assignment IDs:', $assignmentIds->toArray());
           
            $media = DB::table('assignment_media')
                    ->whereIn('assignment_id', $assignmentIds)
                    ->where('student_id', $studentId)
                    ->get()
                    ->map(function ($item) {
                        $item->extension = pathinfo($item->path, PATHINFO_EXTENSION);
                        $fullPath = public_path($item->path);
                        $item->size = file_exists($fullPath)
                            ? $this->formatFileSize(filesize($fullPath))
                            : 'N/A';

                        return $item;
                    })
                    ->groupBy('assignment_id');

        //    Log::info('Media:', $media->toArray());


           foreach ($pending as $item) {
                $item->media = $media[$item->id] ?? collect();
                $item->last_updated = $item->updated_at;
            }

            foreach ($completed as $item) {
                $item->media = $media[$item->id] ?? collect();
                $item->last_updated = $item->updated_at;
            }

            return view(
                'parent-panel.assignment',
                compact('pending', 'completed', 'tab','activeTab')
            );

        } catch (\Exception $e) {
            Log::error('Assignment loading error: '.$e->getMessage());
            return redirect()->route('parent-panel-dashboard.index')->with('error', 'Failed to load assignments.');

        }
    }

    public function assignment_download($filename)
    {
        Log::info("Download request received", [
            'raw_filename' => $filename,
        ]);

        $decoded = urldecode($filename);

        Log::info("Decoded filename", [
            'decoded' => $decoded
        ]);

        $filePath = public_path($decoded);

        Log::info("Full file path", [
            'filePath' => $filePath,
            'exists' => file_exists($filePath) ? 'YES' : 'NO'
        ]);

        if (!file_exists($filePath)) {
            Log::error("FILE NOT FOUND - Cannot download", [
                'path_attempted' => $filePath
            ]);
            abort(404, "File not found on server");
        }

        Log::info("File FOUND. Preparing download...");

        return response()->download($filePath);
    }



    private function formatFileSize($bytes)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        if ($bytes == 0) return '0 B';
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }
}
