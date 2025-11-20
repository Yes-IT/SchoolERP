<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Leave;

class ApplyLeaveController extends Controller
{
    public function index()
    {
        $data['title'] = 'Apply Leave';

        $authUser = auth()->user();

        $data['leaves'] = $authUser->staff->leaves()->with('teacher')->get();

        return view('staff.apply-leave.apply-leave-index', compact('data'));
    }
}
