<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\Academic\Semester;
use App\Models\StudentInfo\Student;
use App\Models\Leave;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExtendedLeavesController extends Controller
{
    
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        $sessionId   = $request->get('year');      // year = session_id
        $semesterId  = $request->get('semester');  // semester_id

        $student = Student::where('parent_guardian_id', Auth::id())->first();
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'No student found for this parent.']);
        }

        $years     = Session::orderByDesc('id')->get();
        $semesters = Semester::get();

        $query = Leave::where('student_id', $student->id)
                    ->whereRaw('DATEDIFF(to_date, from_date) >= 3');

        // === FILTERS ===
        if ($sessionId && $sessionId != '') {
            $query->where('session_id', $sessionId);
        }

        if ($semesterId && $semesterId != '') {
            $query->where('semester_id', $semesterId);
        }
        // =================

        $query->orderBy('created_at', 'desc');

        $leaves = $query->paginate($perPage)->appends($request->query());

        // If request is AJAX → return only table + pagination
        if ($request->ajax()) {
            return view('parent-panel.extended_leaves_table', compact(
                'leaves', 'perPage'
            ))->render();
        }

        return view('parent-panel.extended-leaves', compact(
            'leaves', 'perPage', 'years', 'semesters', 'student'
        ));
    }

}