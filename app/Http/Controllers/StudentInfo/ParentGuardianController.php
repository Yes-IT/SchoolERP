<?php

namespace App\Http\Controllers\StudentInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\StudentInfo\ParentGuardianRepository;
use App\Http\Requests\StudentInfo\ParentGuardian\ParentGuardianStoreRequest;
use App\Http\Requests\StudentInfo\ParentGuardian\ParentGuardianUpdateRequest;
use  App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\Student;

class ParentGuardianController extends Controller
{
    private $repo;
    private $studentRepo;

    function __construct(
        ParentGuardianRepository $repo,
        StudentRepository $studentRepo,
        )
    {
        $this->repo       = $repo;
        $this->studentRepo = $studentRepo;
    }

  public function index()
{
    $data['title']   = ___('student_info.parent_list');
    $data['parents'] = $this->repo->getPaginateAll(); // parent repo

   
    $students = Student::whereNotNull('parent_guardian_id')->get();

    $data['students'] = $students;

    return view('backend.student-info.parent.index', compact('data'));
}
    public function search(Request $request)
    {
        $data['title']   = ___('student_info.parent_list');
        $data['request'] = $request;
        $data['parents'] = $this->repo->searchParent($request);

        $students = Student::whereNotNull('parent_guardian_id')->get();
        $data['students'] = $students;

        return view('backend.student-info.parent.index', compact('data'));
    }

    public function create()
    {
        $students = Student::get()->toArray();
        $data['students'] = $students;
        $data['title']              = ___('student_info.parent_create');
        return view('backend.student-info.parent.create', compact('data'));
    }

    public function getParent(Request $request)
    {
        $result = $this->repo->getParent($request);
        return response()->json($result);
    }

    public function store(ParentGuardianStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('parent.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $students = Student::get()->toArray();
        $data['students'] = $students;
        $data['student_data']      = $this->studentRepo->show($id);
        $data['title']       = ___('student_info.parent_create');
        return view('backend.student-info.parent.edit', compact('data'));
    }

    public function update(ParentGuardianUpdateRequest $request, $id)
    {
        
        // print_r($request->all());die;
        $result = $this->repo->update($request, $id);
        if($result){
            return redirect()->route('parent.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->repo->destroy($id);
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

    public function filterByYearParent(Request $request)
{
    $year = $request->year;

    $data['parents'] = ParentGuardian::with(['user', 'children'])
        ->when($year, function($query) use ($year) {
            $query->whereYear('created_at', $year);
        })
        ->get();

  return response()->json([
    'html' => view('backend.student-info.parent.parent-list', compact('data'))->render()
]);

}

public function filterByStudent(Request $request)
{
    $studentId = $request->student_id;


    $students = Student::whereNotNull('parent_guardian_id')->get();

    $data['students'] = $students;

  
    $parentIds = $students->pluck('parent_guardian_id')->unique();

    
    $parents = ParentGuardian::whereIn('id', $parentIds)->get();

    $data['parents'] = $parents;

 
    return response()->json([
        'html' => view('backend.student-info.parent.parent-list', compact('data'))->render()
    ]);
}

public function phoneLog(){
    return view('backend.student-info.parent.phone-log');
}

}
