<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\ExaminationResult;
use App\Models\Examination\GradeMap;
use App\Models\Academic\YearStatus;
use App\Models\Academic\Semester;
use App\Models\Academic\Subject;
use App\Models\Academic\Classes;
use App\Models\Examination\ExamType;
use Illuminate\Support\Facades\DB;
class GradeController extends Controller
{
    //
 
    public function index(){
        return view('backend.grade_flow.index');
    }
 
   
 
    public function failing_grades()
    {
        return view('backend.grade_flow.failing-grades');
    }
 
    public function missing_grades()
    {
        return view('backend.grade_flow.missing-grades');
    }
 
    public function assign_grade(Request $request){
        $sessions = Session::all();
        $yearStatus = YearStatus::all();
        $semesters = Semester::all();
        $subjects = Subject::all();
        $classes = Classes::all();
        $examTypes = ExamType::all();
 
        // dd($classes);
        $query = ExaminationResult::query();
        $perPage = $request->input('per_page', 10);
        if ($request->filled('select-session')) {
            $query->where('session_id', $request->input('select-session'));
        }
 
       
        if ($request->filled('select-year-status')) {
           $query->where('year_status_id', $request->input('select-year-status'));
        }
 
        if ($request->filled('select-semester')) {
            $query->where('semester_id', $request->input('select-semester'));
        }
 
       
        if ($request->filled('select-subject')) {
            $query->where('subject_id', $request->input('select-subject'));
        }
 
       
        if ($request->filled('select-class')) {
            $query->where('classes_id', $request->input('select-class'));
        }
 
       
        if ($request->filled('select-exam-type')) {
            $query->where('exam_type_id', $request->input('select-exam-type'));
        }
 
       
        $results = $query->with('student')->paginate($perPage)->appends(request()->except('page'));
 
       
       
 
        return view('backend.grade_flow.assign-grade',compact('sessions','yearStatus','semesters','subjects','classes','examTypes','results'));
    }
 
    public function assign_grade_submit(Request $request)
    {
        $results = $request->input('results', []);
        // dd($results);
        if (empty($results)) {
            return response()->json(['success' => false, 'message' => 'No data provided']);
        }
 
        try {
 
            $gradeMap = GradeMap::all();
            // dd($gradeMap->toArray(),$gradeMap->firstWhere('grade_input', $marksAchieved));
 
            \DB::transaction(function () use ($results,$gradeMap) {
                foreach ($results as $res) {
                    if(isset($res['id'], $res['marks_achieved']))
                    {
                        $grade = $gradeMap->firstWhere('grade_input',  $res['marks_achieved']);
                       
                        ExaminationResult::where('id', $res['id'])
                            ->update([
                                'marks_achieved' => $res['marks_achieved'],
                                'grade_name' => $grade->grade,
                            ]);
                    }
                }
            });
 
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Update failed', 'error' => $e->getMessage()]);
        }
    }
 
 
}