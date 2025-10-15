<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function assign_grade(){
        return view('backend.grade_flow.assign-grade');
    }
}
