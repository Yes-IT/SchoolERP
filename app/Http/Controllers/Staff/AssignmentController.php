<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\{Subject,Classes,AssignmentSubmission};

use App\Interfaces\Staff\AssignmentInterface;
use Illuminate\Support\Facades\{Auth,Log,DB};
use Exception;


class AssignmentController extends Controller
{
    protected $assignmentRepo;

    public function __construct(AssignmentInterface $assignmentRepo)
    {
        $this->assignmentRepo = $assignmentRepo;
    }

    public function index()
    {
        try {

            $teacherId = Auth::user()->staff->id;
            // Log::info("Teacher Staff ID: " . $teacherId);

            $current = $this->assignmentRepo->getByStatus($teacherId, 1);
            $closed = $this->assignmentRepo->getByStatus($teacherId, 2);
            $requested = $this->assignmentRepo->getByStatus($teacherId, 0);

            // Log::info("Controller -> Current Count: " . $current->count());
            // Log::info("Controller -> Closed Count: " . $closed->count());
            // Log::info("Controller -> Requested Count: " . $requested->count());

            $data = [
                'title' => 'My Assignment',
                'subjects' => $this->getTeacherSubjects($teacherId),
                'current_assignments' => $current,
                'closed_assignments' => $closed,
                'requested_assignments' => $requested,
            ];

            return view('staff.assignment.assignment-index', compact('data'));
        } catch (Exception $e) {
            Log::error('Assignment index error: ' . $e->getMessage());
            return redirect()->route('staff.dashboard')->with('error', 'Failed to load assignments.');
        }
        
    }

    public function store_assignment(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:100',
            'grade' => 'required|numeric|min:0|max:100',
            'due_date' => 'required|date|after:today',
            'description' => 'nullable|string',
            'file.*' => 'nullable|file|max:2048',
        ]);

        try {
            $user = Auth::user();
            $teacherId = $user->staff->id;

            $assignmentData = [
                'subject_id'    => $validated['subject_id'],
                'student_id'    => null,
                'class_id'      => $user->class_id,
                'title'         => $validated['title'],
                'grade'         => $validated['grade'],
                'due_date'      => $validated['due_date'],
                'assigned_date' => now(),
                'description'   => $validated['description'],
                'status'        => 0,// 0=requested
                'created_by'    => $teacherId,
            ];

           $assignment = $this->assignmentRepo->createAssignment(
                $assignmentData, 
                $request->file('file', [])
            );

           return response()->json([
                'success' => true,
                'message' => 'Your assignment request sent successfully to admin.'
            ]);

        } catch (Exception $e) {
            Log::error('Assignment store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create assignment.'
            ], 500);
        }
    }

    private function getTeacherSubjects($teacherId)
    {
        return Subject::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('staff.user_id', $teacherId);
        })->get();
    }

 
   
    public function uploadAssignmentMedia(Request $request)
    {
        try{
            $response = $this->assignmentRepo->uploadMedia(
                $request->assignment_id,
                $request->file('file')
            );

        return response()->json($response);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
       
    }

    public function getAssignementMedia($id)
    {
        try{
           $media = $this->assignmentRepo->getMedia($id);
           return response()->json($media);
           
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
        
    }

    public function assignmentEvaluation($id)
    {
        try{
             $assignment = $this->assignmentRepo->find($id);
             Log::info('Assignment for evaluation: ',['assignment' => $assignment]);

            $submissions = $this->assignmentRepo->getSubmissionsForEvaluation($id);
            Log::info('Submissions for evaluation: ',['submissions' => $submissions]);               

             return view('staff.assignment.assignment-evaluation',compact('assignment','submissions'));
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
       
    }

    public function saveAssignmentEvaluation(Request $request, $id)
    {

        $request->validate([
            'grades.*' => 'nullable|numeric|min:0|max:100',
            'notes.*'  => 'nullable|string',
        ], [
            'grades.*.min' => 'Marks cannot be less than 0.',
            'grades.*.max' => 'Marks cannot be more than 100.',
            'grades.*.numeric' => 'Marks must be a valid number.',
        ]);
        
        try {
            Log::info('store evaluation Request: ', ['request' => $request->all()]);

            $this->assignmentRepo->saveEvaluation($id, $request);

            return redirect()->route('staff.assignment.index')->with('success', 'Assignment evaluated successfully.');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

   

}
