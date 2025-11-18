<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Leaves\LeaveRepositoryInterface;
use App\Models\Academic\Classes;
use App\Models\Academic\SchoolYear;
use App\Models\Academic\Semester;
use App\Models\Academic\Subject;
use App\Models\Academic\YearStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Transcript;
use App\Models\College;
use App\Models\Leave;
use App\Models\Session;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    private $leaveRepository;

    public function __construct(LeaveRepositoryInterface $leaveRepository)
    {
        $this->leaveRepository = $leaveRepository;
    }

    public function studentIndex()
    {

        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = Session::all();
        $subjects = Subject::all();
    
        return view('backend.leave.student.index', [
            'title' => 'Student Leaves',
            'classes' => $classes,
            'yearStatuses' => $yearStatuses,
            'semesters' => $semesters,
            'schoolYears' => $schoolYears,
            'subjects' => $subjects,
        ]);
    }

    public function studentData(Request $request)
    {
        $result = $this->leaveRepository->getStudentLeaves($request);
        return response()->json($result);
    }

    public function teacherIndex()
    {
        $classes = Classes::all();
        $yearStatuses = YearStatus::all();
        $semesters = Semester::all();
        $schoolYears = Session::all();
        $subjects = Subject::all();

        return view('backend.leave.teacher.index', [
            'title' => 'Student Leaves',
            'classes' => $classes,
            'yearStatuses' => $yearStatuses,
            'semesters' => $semesters,
            'schoolYears' => $schoolYears,
            'subjects' => $subjects,
        ]);
    }

    public function teacherData(Request $request)
    {
        $result = $this->leaveRepository->getTeacherLeaves($request);
        return response()->json($result);
    }

    public function updateTeacherLeave(Request $request)
    {
        $request->validate([
            'leave_id' => 'required|exists:leaves,id',
            'action' => 'required|in:approve,reject',
        ]);

        try {
            $leave = Leave::findOrFail($request->input('leave_id'));
            
            if ($leave->is_approved !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Leave has already been processed.'
                ], 400);
            }

            if ($request->input('action') === 'approve') {
                $leave->is_approved = 1; // Approved
                $leave->approved_date = now();
            } elseif ($request->input('action') === 'reject') {
                $leave->is_approved = 2; // Rejected
                $leave->approved_date = null;
            }

            $leave->save();

            return response()->json([
                'success' => true,
                'message' => 'Leave status updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating leave status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update leave status. Please try again.'
            ], 500);
        }
    }


    public function transcriptIndex(Request $request)
    {
        $tab = $request->input('tab', 'pending');
        $perPage = $request->input('per_page', 2);
        $currentPage = $request->input('page', 1);

        // Fetch transcript data using the repository
        $result = $this->leaveRepository->getTranscriptRequests($request);

        // Extract pagination HTML from the result
        $pagination = $result['pagination'];

        // Fetch paginated transcripts for both pending and final tabs
        $pendingTranscripts = $this->getPaginatedTranscripts($request, 'pending');
        $finalTranscripts = $this->getPaginatedTranscripts($request, 'final');

        return view('backend.leave.transcript.index', [
            'title' => 'Transcript Requests',
            'tab' => $tab,
            'pendingTranscripts' => $pendingTranscripts,
            'finalTranscripts' => $finalTranscripts,
            'perPage' => $perPage,
            'pagination' => $pagination
        ]);
    }

    public function transcriptData(Request $request)
    {
        $result = $this->leaveRepository->getTranscriptRequests($request);
        return response()->json($result);
    }

    public function updateTranscriptStatus(Request $request)
    {
        $request->validate([
            'transcript_id' => 'required|exists:transcripts,id',
            'action' => 'required|in:approve,reject'
        ]);


        $transcript = Transcript::find($request->transcript_id);
        $transcript->status = $request->action === 'approve' ? 'approved' : 'rejected';
        $transcript->save();

        return response()->json([
            'success' => true,
            'message' => 'Transcript ' . $transcript->status . ' successfully.'
        ]);
    }

    /**
     * Helper method to get paginated transcripts for a specific tab
     */
    private function getPaginatedTranscripts(Request $request, $tab)
    {
        $perPage = $request->input('per_page', 2);
        $currentPage = $request->input('page', 1);

        // Fetch all transcripts
        $query = Transcript::query();
        $transcripts = $query->get();

        // Split into pending and final
        $pendingTranscripts = [];
        $finalTranscripts = [];

        foreach ($transcripts as $transcript) {
            if ($transcript->status === 'pending') {
                $pendingTranscripts[] = $transcript;
            } else {
                $finalTranscripts[] = $transcript;
            }
        }

        // Select collection based on tab
        $transcriptsCollection = $tab === 'pending'
            ? collect($pendingTranscripts)
            : collect($finalTranscripts);

        // Paginate
        return new LengthAwarePaginator(
            $transcriptsCollection->forPage($currentPage, $perPage),
            $transcriptsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => route('transcript.data'), 'query' => array_merge($request->query(), ['tab' => $tab])]
        );
    }


    public function collegeIndex()
    {
        return view('backend.leave.college.index', [
            'title' => 'College Records'
        ]);
    }

    public function collegeData(Request $request)
    {
        $result = $this->leaveRepository->getCollegeRecords($request);
        return response()->json($result);
    }

    public function storeCollege(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_funded' => 'required|boolean',
            'amount' => 'required_if:is_funded,1|numeric|min:0|nullable',
        ]);

        College::create([
            'name' => $validated['name'],
            'is_funded' => $validated['is_funded'],
            'amount' => $validated['is_funded'] ? $validated['amount'] : null,
            'date' => now(), // Set server time
            'status' => 'pending', // Default status
        ]);

        return response()->json(['success' => true, 'message' => 'College record added successfully']);
    }



}