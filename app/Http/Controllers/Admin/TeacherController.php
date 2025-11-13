<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Staff\TeacherInterface;
use App\Http\Requests\Staff\Teacher\{TeacherStoreRequest,TeacherUpdateRequest};
use App\Models\Staff\Staff;
use Illuminate\Support\Facades\{Log,DB};


class TeacherController extends Controller
{
     private $repo;

    public function __construct(TeacherInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
        $data['title'] = ___('staff.teacher');
        $data['teachers'] = $this->repo->getPaginateAll();

        return view('backend.teacher.index',compact('data'));
    }

    public function teacher_info($id){

        $teacher = $this->repo->show($id)->load('upload');
        $classes = $this->repo->fetchClasses($id);
        // dd($classes->toArray()[0]['year_status']['name']);
        if (! $teacher) {
            abort(404, 'Teacher not found');
        }

        return view('backend.teacher.teacher-info', compact('teacher','classes'));
    }

    public function create(){
        $data['title'] = ___('staff.teacher');

        // Get last teacher directly from repo's model
        $lastTeacher = $this->repo->all()->sortByDesc('id')->first();

        $nextNumber = $lastTeacher
            ? ((int) filter_var($lastTeacher->identification_number, FILTER_SANITIZE_NUMBER_INT)) + 1
            : 1;

        $nextTeacherId = 'TCHR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        // Log::info('nextTeacherId', ['nextTeacherId' => $nextTeacherId]);

        return view('backend.teacher.add-teacher', compact('data','nextTeacherId'));
    }

    public function store(TeacherStoreRequest $request){
         $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('teacher.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id){
        $data['title'] = ___('staff.teacher_edit');

        $teacher = $this->repo->show($id);
        if (!$teacher) {
            return redirect()->route('teacher.index')->with('danger', 'Teacher not found.');
        }

        // Log::info('teacher', ['teacher' => $teacher]);

        return view('backend.teacher.edit-teacher',compact('data','teacher'));
    }
    
    public function update(TeacherUpdateRequest $request, $id)
    {
        // dd(9);
        // Log::info('Validation passed, request in update', ['request' => request()->all()]);

        $result = $this->repo->update($request, $id);

        if ($result['status']) {
            return redirect()->route('teacher.index')->with('success', $result['message']);
        }
       
        //  Log::error('Teacher update failed', ['result' => $result]);
        return back()->withErrors($result['message'])->withInput();
    }

    public function toggleInactive(Request $request, $teacherId)
    {

        $teacher = $this->repo->show($teacherId);
        // Log::info('teacher in toggleInactive', ['teacher status' => $teacher->inactive]);

        $teacher->inactive = $request->inactive ? 1 : 0;
        $teacher->save();

        return response()->json([
             'success' => true,
             'inactive' => $teacher->inactive
        ]);
    }

    public function delete($id)
    {
        try {
            $teacher = $this->repo->show($id);

            if (!$teacher) {
                return redirect()->route('teacher.index')->with('danger', 'Teacher not found');
            }

            $teacher->delete(); 
            return redirect()->route('teacher.index')->with('success', 'Teacher deleted successfully');
        } catch (\Throwable $th) {
            Log::error('teacher delete error', ['error' => $th->getMessage()]);
            return redirect()->route('teacher.index')->with('danger', 'Something went wrong');
        }
    }


    // public function filter(Request $request)
    // {
    //     try {
    //         $teacherId = $request->id;
    //         $perPage = $request->per_page ?? 10;
    //         $page = $request->page ?? 1;

    //         $query = Staff::query();
            
    //         if ($teacherId && $teacherId !== 'all') {
    //             $query->where('id', $teacherId);
    //         }

    //         // Keep filters in generated page URLs
    //         $teachers = $query->paginate($perPage, ['*'], 'page', $page)
    //                         ->appends($request->except('page'));

    //         $html = view('backend.teacher.partials.teacher-rows', compact('teachers'))->render();
    //         $pagination = view('backend.teacher.partials.teacher-pagination', ['teachers' => $teachers])->render();

    //         return response()->json([
    //             'html' => $html,
    //             'pagination' => $pagination
    //         ]);
    //     } catch (\Throwable $th) {
    //         Log::error('teacher filter error', [
    //             'error' => $th->getMessage(), 
    //             'trace' => $th->getTraceAsString()
    //         ]);
        
    //         return response()->json(['error' => 'Server error'], 500);
    //     }
    // }

    public function filter(Request $request)
    {
        try {
            $teachers = $this->repo->filter($request);

            $html = view('backend.teacher.partials.teacher-rows', compact('teachers'))->render();
            $pagination = view('backend.teacher.partials.teacher-pagination', ['teachers' => $teachers])->render();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination
            ]);
        } catch (\Throwable $th) {
            Log::error('teacher filter error', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return response()->json(['error' => 'Server error'], 500);
        }
    }



}
