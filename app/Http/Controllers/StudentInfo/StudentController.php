<?php

namespace App\Http\Controllers\StudentInfo;

use App\Models\Staff\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentInfo\Student\StudentImportRequest;
use App\Repositories\GenderRepository;
use App\Repositories\ReligionRepository;
use App\Repositories\BloodGroupRepository;
use App\Repositories\Academic\ShiftRepository;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\StudentInfo\ParentGuardianRepository;
use App\Http\Requests\StudentInfo\Student\StudentStoreRequest;
use App\Http\Requests\StudentInfo\Student\StudentUpdateRequest;
use App\Interfaces\StudentInfo\StudentCategoryInterface;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\StudentInfo\StudentCategoryRepository;
use Maatwebsite\Excel\Exceptions\ImportValidationException;
use App\Imports\StudentsImport;
use App\Repositories\Staff\DepartmentRepository;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    private $repo;
    private $classRepo;
    private $sectionRepo;
    private $classSetupRepo;
    private $shiftRepo;
    private $bloodRepo;
    private $religionRepo;
    private $genderRepo;
    private $categoryRepo;
    private $examAssignRepo;
    private $departmentRepo;
    private $parentGuardianRepo;

    function __construct(
        StudentRepository $repo,
        ClassesRepository $classRepo,
        SectionRepository $sectionRepo,
        ClassSetupRepository $classSetupRepo,
        ShiftRepository   $shiftRepo,
        BloodGroupRepository         $bloodRepo,
        ReligionRepository           $religionRepo,
        GenderRepository             $genderRepo,
        StudentCategoryRepository    $categoryRepo,
        ExamAssignRepository         $examAssignRepo,
        DepartmentRepository         $departmentRepo,
        ParentGuardianRepository    $parentGuardianRepo,
    ) {
        $this->repo               = $repo;
        $this->classRepo          = $classRepo;
        $this->sectionRepo        = $sectionRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->shiftRepo          = $shiftRepo;
        $this->bloodRepo          = $bloodRepo;
        $this->religionRepo       = $religionRepo;
        $this->genderRepo         = $genderRepo;
        $this->categoryRepo       = $categoryRepo;
        $this->examAssignRepo     = $examAssignRepo;
        $this->departmentRepo     = $departmentRepo;
        $this->parentGuardianRepo = $parentGuardianRepo;
    }

    public function index()
    {
      
        $data['classes']  = $this->classRepo->assignedAll();
        $data['sections'] = [];
        $data['title']    = ___('student_info.student_list');
        $data['students'] = $this->repo->getPaginateAll();

        return view('backend.student-info.student.index', compact('data'));
    }

    public function search(Request $request)
    {
        $data['classes']  = $this->classRepo->assignedAll();
        $data['sections'] = $this->classSetupRepo->getSections($request->class);
        $data['request']  = $request;
        $data['title']    = ___('student_info.student_list');
        $data['students'] = $this->repo->searchStudents($request);
        return view('backend.student-info.student.index', compact('data'));
    }

    public function create()
    {
        $data['title']           = ___('student_info.student_create');
        $data['classes']         = $this->classRepo->assignedAll();
        $data['sections']        = [];
        $data['shifts']          = $this->shiftRepo->all();
        $data['departments']     = $this->departmentRepo->getAsOptions();
        $data['bloods']          = $this->bloodRepo->all();
        $data['religions']       = $this->religionRepo->all();
        $data['genders']         = $this->genderRepo->all();
        $data['school_years']    = DB::table('school_years')->get();
        $data['categories']      = $this->categoryRepo->all();
        $data['parentGuardians'] = $this->parentGuardianRepo->get();
        $data['teachers']        = DB::table('staff')->where('role_id', 5)->get();

        return view('backend.student-info.student.create', compact('data'));
    }

    public function addNewDocument(Request $request)
    {
        $counter = $request->counter;
        return view('backend.student-info.student.add-document', compact('counter'))->render();
    }
    public function getStudents(Request $request)
    {
        $examAssign = $this->examAssignRepo->getExamAssign($request);
        // dd($examAssign->mark_distribution);
        $students = $this->repo->getStudents($request);
        return view('backend.student-info.student.students-list', compact('students', 'examAssign'))->render();
    }



    public function store(StudentStoreRequest $request)
    {
        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('student.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    // public function edit($id)
    // {
    //     $data['title']                 = ___('student_info.student_edit');
    //     $data['session_class_student'] = $this->repo->getSessionStudent($id);
    //     $data['student']               = $this->repo->show($data['session_class_student']->student_id);
    //     $data['classes']               = $this->classRepo->assignedAll();
    //     $data['departments']           = $this->departmentRepo->getAsOptions();
    //     $data['sections']              = $this->classSetupRepo->getSections($data['session_class_student']->classes_id);
    //     $data['shifts']                = $this->shiftRepo->all();
    //     $data['bloods']                = $this->bloodRepo->all();
    //     $data['religions']             = $this->religionRepo->all();
    //     $data['genders']               = $this->genderRepo->all();
    //     $data['categories']            = $this->categoryRepo->all();
    //     $data['parentGuardians']       = $this->parentGuardianRepo->get();

    //     return view('backend.student-info.student.edit', compact('data'));
    // }


    public function edit($id)
    {
        $student = $this->repo->show($id);
        if (!$student) {
            abort(404, 'Student not found');
        }
        $data['title']           = ___('student_info.student_edit');
        $data['student']         = $student;
        $data['classes']         = $this->classRepo->assignedAll();
        $data['sections']        = $this->classSetupRepo->getSections($student->classes_id ?? null);
        $data['shifts']          = $this->shiftRepo->all();
        $data['departments']     = $this->departmentRepo->getAsOptions();
        $data['bloods']          = $this->bloodRepo->all();
        $data['religions']       = $this->religionRepo->all();
        $data['genders']         = $this->genderRepo->all();
        $data['categories']      = $this->categoryRepo->all();
        $data['parentGuardians'] = $this->parentGuardianRepo->get();
        $data['teachers']        = DB::table('staff')->where('role_id', 5)->get();
        $data['classMappings']     = DB::table('student_class_mapping')->where('student_id', $id)->get();
        $data['requestTranscripts'] = DB::table('request_transcript')->where('student_id', $id)->get();
        $data['formChecklists']    = DB::table('form_checklist')->where('student_id', $id)->get(); // usually one
        // dd($data);
        return view('backend.student-info.student.edit', compact('data'));
    }


    public function show($id)
    {
        $data = $this->repo->show($id);

        return view('backend.student-info.student.show', compact('data'));
    }





    public function update(StudentUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);

        if ($result['status']) {
            return redirect()->route('student.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    public function delete($id)
    {

        $result = $this->repo->destroy($id);
        if ($result['status']):
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

    public function import()
    {
        $data['title']     = ___('student_info.student_import');
        $data['classes']   = $this->classRepo->assignedAll();
        $data['categories']   = $this->categoryRepo->all();
        $data['sections']  = [];
        return view('backend.student-info.student.import', compact('data'));
    }

    public function importSubmit(StudentImportRequest $request)
    {
        try {
            Excel::import(new StudentsImport($request->class, $request->section), $request->file('file'));
            return redirect()->route('student.index')->with('success', ___('alert.Operation Successful'));
        } catch (ImportValidationException $e) {
            $errors = $e->errors();
            return back()->withErrors($errors)->withInput();
        }
    }

    public function sampleDownload()
    {
        $filePath = public_path('student_bulk_import_sample.xlsx');
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found!');
        }
    }
}
