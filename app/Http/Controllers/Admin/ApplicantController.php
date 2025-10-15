<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(){
        return view('backend.applicant.index');
    }

    public function dashboard(){
        return view('backend.applicant.dashboard');
    }

    public function calender(){
        return view('backend.applicant.calender');
    }

    public function schedule_interview(){
        return view('backend.applicant.schedule_interview');
    }

    public function profile(){
        return view('backend.applicant.profile');
    }

    public function add_new_applicant(){
        return view('backend.applicant.add-new-applicant');
    }

    public function edit_applicant(){
        return view('backend.applicant.edit-applicant');
    }

    public function custom_applicant_chart(){
        return view('backend.applicant.custom-applicant-chart');
    }

    public function contacts(){
        return view('backend.applicant.contacts');
    }
}
