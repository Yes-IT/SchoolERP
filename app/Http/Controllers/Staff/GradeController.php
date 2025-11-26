<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classes;
use App\Models\Academic\Semester;
use App\Models\Academic\Subject;
use App\Models\Academic\YearStatus;
use App\Models\Examination\ExamType;
use App\Models\Examination\Grade;
use App\Models\Examination\GradeMap;
use App\Models\Session;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GradeController extends Controller{

    public function index()
    {

        $teacherId = Auth::id();
        $assignedClassIds = StudentClassMapping::where('teacher_id', $teacherId)->distinct()->pluck('class_id');
        $classes = Classes::whereIn('id', $assignedClassIds)->get();
        $subjects = Subject::get();
        $years = Session::orderByDesc('id')->get();
        $yearStatuses = YearStatus::orderByDesc('id')->get();
        $semesters = Semester::orderByDesc('id')->get();
        $examTypes = ExamType::get();

        return view('staff.grade.index', compact(
            'classes',
            'subjects',
            'years',
            'yearStatuses',
            'semesters',
            'examTypes'
        ));

    }

    public function filterAssignGrades(Request $request)
    {
        $request->validate([
            'year_id'        => 'required',
            'year_status_id' => 'required',
            'semester_id'    => 'required',
            'class_id'       => 'required',
        ]);

        $teacherId  = Auth::id();
        $sessionId  = $request->year_id;
        $semesterId = $request->semester_id;
        $classId    = $request->class_id;
        $perPage    = in_array($request->per_page, [10,25,50,100]) ? $request->per_page : 20;

        $paginator = StudentClassMapping::with('student')
            ->where('teacher_id', $teacherId)
            ->where('class_id', $classId)
            ->whereHas('student')
            ->paginate($perPage)
            ->appends($request->query());

        $grades = DB::table('grades')
            ->where('session_id', $sessionId)
            ->where('semester_id', $semesterId)
            ->where('classes_id', $classId)
            ->whereIn('student_id', $paginator->pluck('student_id')->toArray())
            ->pluck('percentage', 'student_id');

            $paginator->getCollection()->transform(function ($item) use ($grades) {
                $marks = $grades->get($item->student->id);
                return (object)[
                    'student_id'     => $item->student->id,
                    'student_name'   => trim($item->student->first_name . ' ' . ($item->student->last_name ?? '')),
                    'marks_achieved' => $marks ? (int)$marks : null,
                    'grade'          => $this->calculateGrade($marks),
                ];
            });

            // ONLY RETURN TABLE — NO PAGINATION HERE
            return response()->json([
            'table'      => view('staff.grade.grades_table', compact('paginator'))->render(),
            'pagination' => $paginator->links('backend.partials.pagination')
                            ->with(['routeName' => 'staff.grade.assign-grades.filter'])
                            ->render(),
            'total'      => $paginator->total(),
        ]);
        
    }


    public function saveMarks(Request $request)
    {
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'marks_achieved'  => 'required|numeric|min:0|max:100',
            'year_id'         => 'required',
            'year_status_id'  => 'required',
            'semester_id'     => 'required',
            'class_id'        => 'required',
            // 'subject_id'   => 'required', // optional if needed later
        ]);

        $data = [
            'student_id'     => $request->student_id,
            'session_id'     => $request->year_id,
            'semester_id'    => $request->semester_id,
            'classes_id'     => $request->class_id,
            'percentage'     => $request->marks_achieved,
            'updated_by'     => Auth::id(),
            'updated_at'     => now(),
        ];

        // Upsert: update if exists, insert if not
        Grade::updateOrCreate(
            [
                'student_id'  => $request->student_id,
                'session_id'  => $request->year_id,
                'semester_id' => $request->semester_id,
                'classes_id'  => $request->class_id,
            ],
            $data
        );

        $gradeLetter = $this->calculateGrade($request->marks_achieved);

        return response()->json([
            'success' => true,
            'grade'   => $gradeLetter,
            'message' => 'Marks saved successfully'
        ]);
    }

    // Optional helper
    private function calculateGrade($marks)
    {
        if ($marks === null) {
            return '-';
        }

        $gradeMap = GradeMap::where('grade_input', '<=', $marks)
            ->orderByDesc('grade_input')
            ->first();

        return $gradeMap ? $gradeMap->grade : 'F';
    }



}