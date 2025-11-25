<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunicateController extends Controller
{
    public function index()
    {
        $data['title'] = 'Communicate';
        return view('staff.communicate.communicate-index', compact('data'));
    }
}
