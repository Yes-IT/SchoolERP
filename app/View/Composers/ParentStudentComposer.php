<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\StudentInfo\Student;

class ParentStudentComposer
{
    // public function compose(View $view)
    // {
    //     if (!Auth::check()) {
    //         $view->with('students', collect());
    //         return;
    //     }

    //     $user = Auth::user();

    //     //  Parent role check (role_id = 10)
    //     if ($user->role_id !== 10) {
    //         $view->with('students', collect());
    //         return;
    //     }

    //     $students = Student::where(
    //         'parent_guardian_id',
    //         $user->id
    //     )->get();

    //     $view->with('students', $students);
    // }

    public function compose(View $view)
    {
        Log::info(' ParentStudentComposer HIT');
        if (!Auth::check()) {
            $view->with('students', collect());
            return;
        }

        Log::info('Auth check', [
            'logged_in' => Auth::check(),
            'user_id' => Auth::id(),
            'role_id' => optional(Auth::user())->role_id,
        ]);


        $user = Auth::user();

        // Parent role (role_id = 10)
        if ($user->role_id !== 7) {
            $view->with('students', collect());
            return;
        }

        $students = Student::where('parent_guardian_id', $user->id)->get();

        Log::info('Student query', [
            'count' => $students->count(),
            'parent_id' => $user->id
        ]);

        //  Ensure default selected student is set
        if (!session()->has('selected_student_id') && $students->isNotEmpty()) {
            session(['selected_student_id' => $students->first()->id]);
        }

        // Ensure session student still belongs to parent
        if (
            session()->has('selected_student_id') &&
            !$students->pluck('id')->contains(session('selected_student_id'))
        ) {
            session(['selected_student_id' => $students->first()->id]);
        }

        $view->with('students', $students);
    }

}
