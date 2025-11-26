<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\StudentClassMapping;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Count unique students mapped to this teacher
        $totalStudent = StudentClassMapping::where('teacher_id', $teacherId)
            ->distinct('student_id')
            ->count('student_id');

        return view('staff.dashboard', compact('totalStudent'));
    }
}
