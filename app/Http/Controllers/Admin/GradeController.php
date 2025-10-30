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
use App\Models\Attendance\Attendance;
use App\Models\StudentInfo\Student;
use App\Models\Examination\ExamType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class GradeController extends Controller
{
    //
 
    public function index(){
        return view('backend.grade_flow.index');
    }
 
   
 
    public function failing_grades(Request $request)
    {
        $sessions = Session::all();
        $yearStatus = YearStatus::all();
        $semesters = Semester::all();

        $classQuery = Classes::query();
        // dd($request->all());
        if ($request->filled('select-session')) {
            $classQuery->where('session_id', $request->input('select-session'));
        }
        if ($request->filled('select-year-status')) {
           $classQuery->where('year_status_id', $request->input('select-year-status'));
        }
 
        if ($request->filled('select-semester')) {
            $classQuery->where('semester_id', $request->input('select-semester'));
        }

        $classes = $classQuery->get();

        // now get all the students from the classess id from class_student table
        // $students

        $classQuery->join('class_student','class_student.class_id','=','classes.id')
                ->join('students','students.id','=','class_student.student_id')
                ->join('subjects','subjects.id','=','classes.subject_id')
                ->select('classes.name as class_name',
                        'classes.id as class_id',

                        'classes.session_id as class_session_id',

                        'subjects.id as subject_id',
                        'subjects.name as subject_name',
                        'subjects.allowed_absences as subject_allowed_absences',

                        'students.id as student_id',
                        'students.first_name as student_first_name',
                        'students.last_name as student_last_name',
                        );
        
        $failedStudents = $this->filter_failing_students($classQuery->get());
        
        // dd($classQuery->get()->toArray(),$failing_students);

        return view('backend.grade_flow.failing-grades',compact('sessions','yearStatus','semesters','failedStudents'));
    }
 
    public function missing_grades(Request $request)
    {
        $sessions = Session::all();
        $yearStatus = YearStatus::all();
        $semesters = Semester::all();

        $query = ExaminationResult::query()->whereNull('grade_name');
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



        $results = $query->with('student','subject','class')->paginate($perPage)->appends(request()->except('page'));
 
        // dd($results);

        return view('backend.grade_flow.missing-grades',compact('sessions','yearStatus','semesters','results'));
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




    public function filter_failing_students($students)
    {
        // fetch the attandence for this student

        $failing_students = $students->filter(function($student){
            $subject = Subject::find($student->subject_id);
            if (!$subject) {
                return false; 
            }
            // Log::info("attendance",['attendence' => 's','session_id'=>$student->class_session_id ,'class' => $student->class_id]);

            // dump($student->class_session_id,$student->class_id);
            $attendences = Attendance::where('session_id',$student->class_session_id)->where('classes_id',$student->class_id)->where('student_id',$student->student_id)->get();
            // Log::info("attendance",['attendence' => $attendences->toArray(),'session_id'=>$student->class_session_id ,'class' => $student->class_id]);

            // dump($attendences->toArray());
            //3 means absent 2 means late 
            $absenceCount = $attendences->where('attendance', 3)->count();
            // dump($absenceCount);
            $lateCount = $attendences->where('attendance', 2)->count();
            // dump("late count".$lateCount);

            Log::info("student $student->student_first_name id is_  $student->student_id and absence is $absenceCount and late count $lateCount");
            $lateToAbsence = 0;
            if($subject->number_latenesses_equal_absence > 0)
            {

                $lateToAbsence = floor($lateCount / $subject->number_latenesses_equal_absence);
            }

            $totalAbsences = $absenceCount + $lateToAbsence;

            //check if the student is failing or not
            $isFailed = $totalAbsences > $subject->allowed_absences;

            if($isFailed)
            {
                $student->average = 0;
                $student->reduced = 0;
            }
            return $isFailed;
        });


        return $failing_students;

    }
 
 
}