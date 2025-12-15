<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\Student;

class ParentStudentComposer
{
    public function compose(View $view)
    {
        if (!Auth::check()) {
            $view->with('students', collect());
            return;
        }

        $user = Auth::user();

        //  Parent role check (role_id = 10)
        if ($user->role_id !== 10) {
            $view->with('students', collect());
            return;
        }

        $students = Student::where(
            'parent_guardian_id',
            $user->id
        )->get();

        $view->with('students', $students);
    }
}
