<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\{Subject,Classes,AssignmentSubmission};
// use Illuminate\Support\Validator;
use App\Interfaces\Staff\AssignmentInterface;
use Illuminate\Support\Facades\{Auth,Log,DB,Validator};
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
            $subjects = $this->getTeacherSubjects($teacherId);
            // Log::info('Subjects: ', ['subjects' => $subjects]);

            $classes = $this->getTeacherClasses($teacherId);
            // Log::info('Classes: ', ['classes' => $classes]);

            $current = $this->assignmentRepo->getByStatus($teacherId, 1);
            $closed = $this->assignmentRepo->getByStatus($teacherId, 2);
            $requested = $this->assignmentRepo->getByStatus($teacherId, 0);

            // Log::info("Controller -> Current Count: " . $current->count());
            // Log::info("Controller -> Closed Count: " . $closed->count());
            // Log::info("Controller -> Requested Count: " . $requested->count());

            $data = [
                'title' => 'My Assignment',
                'subjects' => $subjects,
                'classes' => $classes,
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
        // Log::info('store assignment Request: ', ['request' => $request->all()]);

        if ($request->due_date) {
        $parts = explode('/', $request->due_date); 
            if (count($parts) === 3) {
                $formattedDate = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                $request->merge(['due_date' => $formattedDate]);
            }
        }

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:100',
            'grade' => 'required|numeric|min:0|max:100',
            'due_date' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string|max:5000',
            'file.*' => 'nullable|file|max:2048',
        ]);

        try {
            $user = Auth::user();
            $teacherId = $user->staff->id;

            $assignmentData = [
                'subject_id'    => $validated['subject_id'],
                'student_id'    => null,
                'class_id'      => $validated['class_id'],
                'title'         => $validated['title'],
                'grade'         => $validated['grade'],
                'due_date'      => $validated['due_date'],
                'assigned_date' => now(),
                'description'   => strip_tags($validated['description']),
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

    // private function getTeacherSubjects($teacherId)
    // {
    //     return Subject::whereHas('teachers', function($query) use ($teacherId) {
    //         $query->where('staff.id', $teacherId);
    //     })->get();
    // }

    private function getTeacherSubjects($teacherId)
    {
        // Log::info('Getting subjects for teacher:', ['teacherId' => $teacherId]);

        $subjects = Subject::whereHas('classes.teachers', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();
        
        // Log::info('Subjects query result:', ['count' => $subjects->count()]);
        return $subjects;
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
            //  Log::info('Assignment for evaluation: ',['assignment' => $assignment]);

            $submissions = $this->assignmentRepo->getSubmissionsForEvaluation($id);
            // Log::info('Submissions for evaluation: ',['submissions' => $submissions]);               

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
            // Log::info('store evaluation Request: ', ['request' => $request->all()]);

            $this->assignmentRepo->saveEvaluation($id, $request);

            return redirect()->route('staff.assignment.index')->with('success', 'Assignment evaluated successfully.');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    public function editAssignment($id)
    {
        try {
            $teacherId = Auth::user()->staff->id;
            $assignment = $this->assignmentRepo->find($id);
            Log::info('Assignment found:', ['assignment' => $assignment]);

            if (!$assignment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Assignment not found'
                ], 404);
            }

            $subjects = $this->getTeacherSubjects($teacherId);
            $classes = $this->getTeacherClasses($teacherId);

            // Log::info('Subjects count:', ['count' => $subjects->count()]);
            // Log::info('Classes count:', ['count' => $classes->count()]);
            // Log::info('Subjects:', ['subjects' => $subjects->pluck('name', 'id')]);
            // Log::info('Classes:', ['classes' => $classes->pluck('name', 'id')]);

            // Log::info("Assignment ID: {$assignment->id}, Subject: " . ($assignment->subject->name ?? 'NULL') . ", Status: {$assignment->status}");

            return response()->json([
                'status' => true,
                'data' => $assignment,
                'subjects' => $subjects,
                'classes' => $classes,
                'media' => $assignment->media
            ]);

        } catch (\Exception $e) {
            // Log::info('edit ')
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function getTeacherClasses($teacherId)
    {
        // Log::info('Getting classes for teacher:', ['teacherId' => $teacherId]);

        return Classes::whereHas('teachers', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();
    }


    public function updateAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:assignments,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'grade' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'due_date' => 'required|date' 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            
            $updated = $this->assignmentRepo->update($request->id, [
                'subject_id' => $request->subject_id,
                'class_id' => $request->class_id,
                'title' => $request->title,
                'grade' => $request->grade,
                'description' => $request->description,
                'due_date' => $request->due_date
            ]);

            if ($updated) {
                return response()->json([
                    'status' => true,
                    'message' => 'Assignment updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Assignment not found'
                ], 404);
            }

        } catch (\Exception $e) {
           Log::error('Update assignment error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteAssignment($id)
    {
        try {
            $assignment = $this->assignmentRepo->find($id);
            $title = $assignment->title;

            $assignment->delete();

            return response()->json([
                'status' => true,
                'message' => "You have deleted the '{$title}' Assignment successfully"
            ]);
        } catch (\Exception $e) {
            Log::error('Delete assignment error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }




   

}
