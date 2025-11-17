<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Academic\AssignmentInterface;
use Illuminate\Support\Facades\{Log,DB};
use App\Models\Academic\{Assignment,AssignmentSubmission,SchoolYear,Semester,YearStatus,Subject,Classes};
use App\Models\Session;
use Exception;



class AssignmentController extends Controller
{
    protected $assignments;

    public function __construct(AssignmentInterface $assignments)
    {
        $this->assignments = $assignments;
    }
    
    public function index()
    {
        try {
            $data['classes'] = Classes::all();
            $data['subjects'] = Subject::all();

            $currentYear = date('Y');
            $data['sessions'] = Session::where('name', 'LIKE', "$currentYear-%")->get(['id', 'name']);
            $data['semesters'] = Semester::all(['id', 'name']);
            $data['yearStatuses'] = YearStatus::all(['id', 'name']);

            // Debug: Check which classes have assignments
            Log::info('Request data:', request()->all());
            
            $allAssignments = Assignment::where('status', 1)->with('class')->get();
            Log::info('All assignments with their classes:');
            foreach ($allAssignments as $assignment) {
                Log::info("Assignment ID: {$assignment->id}, Class ID: " . ($assignment->class_id ?? 'null') . ", Class Name: " . ($assignment->class->name ?? 'null'));
            }

            $data['assignments'] = $this->assignments->getAcceptedAssignmentRequests(request());
            Log::info('Filtered assignments count: ' . $data['assignments']->count());

            $data['pendingAssignments'] = $this->assignments->getPendingAssignmentRequests();

            return view('backend.assignment.index', $data);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    public function filterClasses(Request $request)
    {
        try {
            $query = Classes::query();
            
            if ($request->has('year_id') && $request->year_id != '') {
                $query->where('session_id', $request->year_id);
            }
            
            if ($request->has('semester_id') && $request->semester_id != '') {
                $query->where('semester_id', $request->semester_id);
            }
            
            if ($request->has('year_status_id') && $request->year_status_id != '') {
                $query->where('year_status_id', $request->year_status_id);
            }
            
            $classes = $query->get(['id', 'name']);
            
            return response()->json([
                'success' => true,
                'classes' => $classes
            ]);
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error filtering classes'
            ], 500);
        }
    }


    public function assignment_details($id)
    {
        $assignment = $this->assignments->show($id);

        $assignment->media_files = $assignment->media->map(function($file) {
           
            $filePath = $file->path; 
            return [
                'url'  => asset($filePath), 
                'name' => $file->file_name . '.' . pathinfo($file->path, PATHINFO_EXTENSION), 
                'type' => $file->media_type,
            ];
        });



        return response()->json($assignment);
    }

    public function evaluation_details($id)        
    {
        Log::info("Evaluation details for assignment {$id}");
        $assignment = $this->assignments->show($id);
    
        //  Check what submissions exist for this assignment
        $submissionsCount = AssignmentSubmission::where('assignment_id', $id)->count();
        Log::info("Submissions count for assignment {$id}: {$submissionsCount}");
        
        //  Get actual submissions data
        $actualSubmissions = AssignmentSubmission::where('assignment_id', $id)
            ->with(['student', 'evaluator'])
            ->get();
        Log::info("Actual submissions:", $actualSubmissions->toArray());
        
        Log::info($assignment);
    
        return response()->json($assignment);
    }

    public function approve_assignment($id)
    {
        $this->assignments->changeStatus($id, 1); // 0 → 1 (assigned)
        return response()->json(['success' => true, 'message' => 'Assignment approved successfully.']);
    }

    public function reject_assignment($id)
    {
        $this->assignments->changeStatus($id, 2); // optional: or handle “rejected” separately
        return response()->json(['success' => true, 'message' => 'Assignment rejected successfully.']);
    }

    // public function filter(Request $request)
    // {
    //     $filters = $request->only([
    //         'year_id', 'year_status_id', 'semester_id', 'class_id', 'subject_id', 'date',
    //     ]);

    //     $result = $this->assignments->filterAssignments($filters);

    //     return response()->json([
    //         'assignments' => $result['accepted'],
    //         'pendingAssignments' => $result['pending'],
    //     ]);
    // }

    public function filter(Request $request)
    {
        try {
            $assignments = $this->getFilteredAssignments($request);
            
            return response()->json([
                'success' => true,
                'assignments' => $assignments
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error filtering assignments'
            ], 500);
        }
    }




}
