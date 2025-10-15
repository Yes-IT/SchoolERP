<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Examination\Type\ExamTypeStoreRequest;
use App\Http\Requests\Examination\Type\ExamTypeUpdateRequest;
use App\Interfaces\Examination\ExamTypeInterface;

class ExamScheduleController extends Controller
{

    protected $examType;

    public function __construct(ExamTypeInterface $examType)
    {
        $this->examType = $examType;
    }

    public function index(){

        $data['title']              = ___('examination.exam_schedule');
       

        return view ('backend.examination.exam-schedule.index',compact('data'));
    }

    public function createExamType(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $data['title']              = ___('examination.exam_type');
        $data['exam_types'] = $this->examType->getPaginateAll($perPage);

        // dd($data);
        return view ('backend.examination.exam-schedule.create-exam-type',compact('data'));
    }

    public function storeExamType(ExamTypeStoreRequest $request)
    {
        $result = $this->examType->store($request);

        if($result['status']){
            return redirect()->route('exam-schedule.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function editExamType($id)
    {
        $examType = $this->examType->show($id);
        if (!$examType) {
            return response()->json(['status' => false, 'message' => 'Exam type not found'], 404);
        }

        // dd($examType);
        return response()->json(['status' => true, 'data' => $examType]);
    }



    public function updateExamType(ExamTypeUpdateRequest $request, $id)
    {
        $result = $this->examType->update($request, $id);
        if($result['status']){
            return redirect()->route('exam-schedule.createExamType')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function createExamScheduleType()
    {
        $data['title']              = ___('examination.exam_type');
        return view ('backend.examination.exam-schedule.create-exam-schedule-type',compact('data'));
    }

    public function checkAvailablity(){
        return view ('backend.examination.exam-schedule.check-availablity');
    }

    public function roomAvailability(){
        return view ('backend.examination.exam-schedule.room-availability');
    }
}
