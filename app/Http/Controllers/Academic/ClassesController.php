<?php

namespace App\Http\Controllers\Academic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Repositories\LanguageRepository;
use App\Interfaces\Academic\ClassesInterface;
use App\Http\Requests\Academic\Classes\{ClassesStoreRequest,ClassesUpdateRequest};
use App\Models\Academic\{SchoolYear,Semester,Subject,YearStatus,ClassRoom};
use App\Models\Staff\Staff;
use Illuminate\Support\Facades\{Log,DB};
use App\Models\StudentInfo\{Student,StudentInfo};
use App\Models\Session;
use Exception;



class ClassesController extends Controller
{
    private $classes;
    private $lang_repo;

    function __construct(ClassesInterface $classes, LanguageRepository $lang_repo)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->classes       = $classes;
        $this->lang_repo       = $lang_repo;
    }

    public function index()
    {
        $data['classes'] = $this->classes->getAll();
        // Log::info('records in classes', ['classes' => $data['classes']]);
        $data['teachers'] = Staff::where('role_id', 5)->get();

        // dd($data['teachers']);

        $data['title'] = ___('academic.class');
        return view('backend.academic.class.index', compact('data'));
    }

    public function getSubjectJson($id)
    {
        $data = $this->classes->getSubjectDetails($id);

        if (!$data) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        return response()->json($data);
    }

    public function create()
    {
        $data['title']       = ___('academic.create_class');
        $subjects            = Subject::all(['id', 'name']);
        $rooms               = ClassRoom::all();
        $teachers            = Staff::where('role_id', 5)
                                ->select('id', 'first_name', 'last_name')
                                ->get(); 

        $currentYear = date('Y');
        // dd($currentYear);
        $sessions = Session::where('name', 'LIKE', "$currentYear-%")->get(['id', 'name']);

        // dd($sessions);
        $semesters         = Semester::all(['id', 'name']);
        $yearStatuses      = YearStatus::all(['id', 'name']);
        // $students          = Student::all();
        $students = Student::with([
            'schoolDetail:id,student_id,homeroom_class,group,division'
        ])->get(['id', 'first_name', 'last_name', 'user_id','student_id']);

        Log::info('students', ['students' => $students]);
        $lastClass = $this->classes->all()->sortByDesc('id')->first();
        // Log::info('lastClass', ['lastClass' => $lastClass]);
        $nextNumber = $lastClass ? ((int) filter_var($lastClass->identification_number, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
        // dd($nextNumber);
        $nextClassId = 'CLS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Log::info('nextClassId', ['nextClassId' => $nextClassId]);

        return view('backend.academic.class.create', compact('data','sessions','nextClassId','students','subjects', 'teachers', 'semesters', 'rooms','yearStatuses'));
    }

    public function store(ClassesStoreRequest $request)
    {
        $result = $this->classes->store($request);
        if($result['status']){
            return redirect()->route('classes.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    public function translate($id)
    {
        $data['class']        = $this->classes->show($id);
        $data['translates']      = $this->classes->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('academic.edit_class');
        return view('backend.academic.class.translate', compact('data'));
    }

    public function translateUpdate(Request $request, $id){

        $result = $this->classes->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('classes.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['title']       = ___('academic.Classes');
        $classes      = $this->classes->show($id);
        if (!$classes) {
            return redirect()->route('classes.index')->with('danger', 'Class not found');
        }

        $subjects     = Subject::all(['id', 'name']);
        $rooms    = ClassRoom::all();
        $teachers     =  Staff::where('role_id', 5)
                        ->select('id', 'first_name', 'last_name')
                        ->get(); 
        $schoolYears  = SchoolYear::all(['id', 'name']); 
        $semesters    = Semester::all(['id', 'name']);
        $yearStatuses = YearStatus::all(['id', 'name']);
        $students = Student::all();

        $allStudents = Student::all();
        
         // Get assigned student IDs
        $assignedStudentIds = $classes->students->pluck('id')->toArray();
        
        // Filter available students (not already assigned to this class)
        $availableStudents = $allStudents->filter(function($student) use ($assignedStudentIds) {
            return !in_array($student->id, $assignedStudentIds);
        });

        dd($classes->subjects);

        if(!$classes){
            return redirect()->route('classes.index')->with('danger', 'Class not found');
        }

        return view('backend.academic.class.edit', compact('availableStudents','subjects','teachers','schoolYears','semesters','rooms','yearStatuses','students','data','classes'));
    }

    public function update(ClassesUpdateRequest $request, $id)
    {
        $result = $this->classes->update($request, $id);
        if($result['status']){
            return redirect()->route('classes.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->classes->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;
    }

    public function class_info($id)
    {
        $class = $this->classes->show($id);
        if(!$class){
           return redirect()->route('classes.index')->with('danger', 'Class not found');
        }

        // dd($class);

        return view('backend.academic.class.class-info',compact('class'));
    }

   


    public function filter(Request $request)
    {
        // Log::info('Filter request received', $request->all());
        
        try {
            $classes = $this->classes->filter($request->all()); 

            $html = view('backend.academic.class.partials.class-rows', compact('classes'))->render();
            $pagination = view('backend.academic.class.partials.class-pagination', compact('classes'))->render();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        } catch (Exception $e) {
            Log::error('Error filtering classes', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to load classes'], 500);
        }
    }

}
