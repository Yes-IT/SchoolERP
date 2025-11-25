<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Academic\Subject;
use App\Models\Academic\Assignment;

use App\Interfaces\Academic\AssignmentInterface;

class AssignmentController extends Controller
{
    protected $assignments;

    public function __construct(AssignmentInterface $assignments)
    {
        $this->assignments = $assignments;
    }

    public function index()
    {
        $data['title'] = 'My Assignment';

        $data['subjects'] = Subject::all();

        $data['assignments'] = Assignment::all();

        return view('staff.assignment.assignment-index', compact('data'));
    }

    public function filterSubjects(Request $request)
    {
        try {
            $query = Subject::query();

            if ($request->has('class_id') && !empty($request->class_id)) {
                $query->where('class_id', $request->class_id);
            }

            $subjects = $query->get(['id', 'name']);

            return response()->json(['status' => 'success', 'data' => $subjects]);

        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
