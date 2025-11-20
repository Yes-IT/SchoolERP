<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Interfaces\Staff\StudentInterface;
use Illuminate\Http\Request;
use App\Models\Academic\{YearStatus,Subject};
use Illuminate\Support\Facades\{DB,Log};


class StudentController extends Controller
{
    protected $students;

    public function __construct(StudentInterface $students)
    {
        $this->students = $students;
    }


    public function index(Request $request){
        try{

            $yearstatuses = YearStatus::whereIn('id',[1,2])->get();
            $subjects = Subject::where('status',1)->get();

            if ($request->has('filter')) {
                $students = $this->students->filter($request);
            } else {
                $students = $this->students->all();
               Log::info('All students', ['students' => $students]);
            }

            return view('staff.students', compact('yearstatuses', 'subjects','students'));
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('staff.dashboard')->with('error', 'Failed to get students.');
        }
    }

    public function Filter(Request $request)
{
    try {
        $students = $this->students->filter($request);

        $html = view('staff.partials.student_list', compact('students'))->render();
        
        $paginationHtml = '';
        if ($students->hasPages()) {
            $paginationHtml = view('backend.partials.pagination', [
                'paginator' => $students, 
                'routeName' => 'staff.students.index',
                'queryParams' => $request->except('page')
            ])->render();
        }

        return response()->json([
            'status' => true,
            'html' => $html,
            'paginationHtml' => $paginationHtml,
            'total' => $students->total(),
            'from' => $students->firstItem(),
            'to' => $students->lastItem()
        ]);

    } catch (\Exception $e) {
        Log::error($e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Error loading data'
        ], 500);
    }
}


}
