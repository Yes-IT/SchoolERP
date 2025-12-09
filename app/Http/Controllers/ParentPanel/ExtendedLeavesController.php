<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Leave;
use Carbon\Carbon;
use DB;


class ExtendedLeavesController extends Controller
{
  

    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 4);

        $student = Student::where('parent_guardian_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        $yearOptions = DB::table('school_years')->pluck('name', 'id')->toArray();
        $semesteroptions = DB::table('semesters')->pluck('name', 'id')->toArray();

        $query = Leave::where('student_id', $student->id)
            ->orderBy('created_at', 'desc');

        if ($request->filled('year')) {
            $yearName = DB::table('school_years')->where('id', $request->year)->value('name');
            if ($yearName) {
                [$yearStart, $yearEnd] = explode('-', $yearName);
                $startOfYear = \Carbon\Carbon::createFromDate($yearStart, 6, 1)->startOfMonth();
                $endOfYear   = \Carbon\Carbon::createFromDate($yearEnd, 5, 31)->endOfMonth();
                $query->whereBetween('from_date', [$startOfYear, $endOfYear]);
            }
        }

        if ($request->filled('semester')) {
            $query->where('semester_id', $request->semester);
        }


        $leaves = $query->paginate($perPage);
        return view('parent-panel.extended-leaves', [
            'leaves' => $leaves,
            'perPage' => $perPage,
            'yearOptions' => $yearOptions,
            'semesteroptions' => $semesteroptions
        ]);
    }

   
}
