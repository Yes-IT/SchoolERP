<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Academic\SubjectInterface;
use App\Models\Academic\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function __construct(SubjectInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getSubjectList($request);
        }

        // Get all subjects for the dropdown
        $allSubjects = $this->subjectRepository->getDistinctNames();

        return view('backend.subject.index', compact('allSubjects'));
    }

    public function getSubjectList(Request $request)
    {
        // Handle per page selection
        $perPage = $request->query('per_page', 2);

        // Get filtered and paginated subjects
        $subjects = $this->subjectRepository->getFiltered($request, $perPage);

        return response()->json([
            'html' => view('backend.subject.list', compact('subjects'))->render(),
        ]);
    }

    public function viewSubjectDetails($id)
    {
        $subjectDetails = Subject::findorfail($id);
        return view('backend.subject.view-details', compact('subjectDetails'));
    }

    public function add()
    {
        return view('backend.subject.add');
    }

    
    public function store(Request $request)
    {
        $result = $this->subjectRepository->store($request);
        

        // Handle array response from ReturnFormatTrait
        $status = is_array($result) ? ($result['status'] ?? false) : ($result->status ?? false);
        $message = is_array($result) ? ($result['message'] ?? 'Failed to create subject.') : ($result->message ?? 'Failed to create subject.');

        if ($request->ajax()) {
            if ($status) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                ]);
            }

            $errors = is_array($result) ? ($result['data'] ?? []) : ($result->errors ?? []);
            
            // DEBUG: Log the errors structure
            \Log::info('Errors Structure:', ['errors' => $errors]);

            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => $errors,
            ], 422);
        }

        if ($status) {
            return redirect()->route('superadmin.subject.index')->with('success', $message);
        }

        return redirect()->back()->with('error', $message)->withInput();
    }
    

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('backend.subject.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->subjectRepository->update($request, $id);

        // Handle array response from ReturnFormatTrait
        $status = is_array($result) ? ($result['status'] ?? false) : ($result->status ?? false);
        $message = is_array($result) ? ($result['message'] ?? 'Failed to update subject.') : ($result->message ?? 'Failed to update subject.');

        if ($request->ajax()) {
            if ($status) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                ]);
            }

            $errors = is_array($result) ? ($result['data'] ?? []) : ($result->errors ?? []);

            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => $errors,
            ], 422);
        }

        if ($status) {
            return redirect()->route('superadmin.subject.index')->with('success', $message);
        }

        return redirect()->back()->with('error', $message)->withInput();
    }


    public function destroy($id)
    {
        $result = $this->subjectRepository->destroy($id);

        if ($result->status) {
            return redirect()->route('superadmin.subject.index')->with('success', $result->message);
        }

        return redirect()->back()->with('error', $result->message);
    }
}