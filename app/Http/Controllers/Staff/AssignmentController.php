<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $data['title'] = 'My Assignment';
        return view('staff.assignment.assignment-index', compact('data'));
    }
}
