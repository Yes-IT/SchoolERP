<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\YearStatus;
use App\Models\Session;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ParentController extends Controller
{

    public function index()
    {
        $sessions     = Session::get();
        $yearStatuses = YearStatus::get();
        $students     = Student::get();

        return view('backend.parent.index', compact(
            'sessions',
            'yearStatuses',
            'students'
        ));
    }


    public function addParent(){

        return view('backend.parent.add-parent');

    }
   

}