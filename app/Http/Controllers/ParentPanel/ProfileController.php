<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\{Auth,DB};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\ParentPanel\Profile\ProfileUpdateRequest;
use App\Http\Requests\ParentPanel\Profile\PasswordUpdateRequest;
use App\Models\StudentInfo\Student;

class ProfileController extends Controller
{
    private $user;

    function __construct(UserInterface $userInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->user       = $userInterface;
    }

    // public function profile()
    // {
    //     $first_student = Student::where('parent_guardian_id', Auth::id())->first();

    //     $student = Student::where('user_id', $first_student->user_id)->first();
    //     $data = DB::table('students')
    //         ->leftjoin('users', 'students.user_id', '=', 'users.id')
    //         ->leftJoin('uploads', 'users.upload_id', '=', 'uploads.id')
    //         ->leftJoin('parent_guardians', 'parent_guardians.student_id', '=', 'students.id')
    //         ->select('students.*', 'students.student_id as s_student_id', 'users.name as user_name', 'users.email', 'uploads.path as image_path', 'parent_guardians.*')
    //         ->where('students.user_id', $first_student->user_id)
    //         ->first();
    //     if (!$data) {
    //         return redirect()->back()->withErrors(['email' => 'User not found.']);
    //     }
    //     return view('parent-panel.profile.profile', compact('data'));
    // }

    //changes by nazmin
    public function profile()
    {
        try {
            $student = request()->get('currentStudent');

            if (!$student) {
                return redirect()->back()->withErrors(['error' => 'Student not found']);
            }

            // Fetch the class_id from student_class_mapping for the current student
            $mapping = DB::table('student_class_mapping')
                ->where('student_id', $student->id)
                ->first();

            $class_id = $mapping?->class_id;

            // Fetch session and year_status from classes -> sessions and year_statuses
            $session = null;
            $year_status = null;
            $semster = null;

            if ($class_id) {
                $class = DB::table('classes')
                    ->select('session_id', 'year_status_id', 'semester_id')
                    ->where('id', $class_id)
                    ->first();

                // @dd($class);

                if ($class) {
                    $session = DB::table('sessions')
                        ->where('id', $class->session_id)
                        ->first(); // or select specific columns if needed

                    $year_status = DB::table('year_status') // assuming table name is year_statuses
                        ->where('id', $class->year_status_id)
                        ->first(); // or select specific columns

                    $semster = DB::table('semesters') // assuming table name is year_statuses
                        ->where('id', $class->semester_id)
                        ->first(); // or select specific columns
                }
            }

            // Main profile data query
            $data = DB::table('students')
                ->leftJoin('users', 'students.user_id', '=', 'users.id')
                ->leftJoin('uploads', 'users.upload_id', '=', 'uploads.id')
                ->leftJoin('parent_guardians', 'parent_guardians.student_id', '=', 'students.id')
                ->select(
                    'students.*',
                    'students.student_id as s_student_id',
                    'users.name as user_name',
                    'users.email',
                    'uploads.path as image_path',
                    'parent_guardians.*'
                )
                ->where('students.id', $student->id)
                ->first();

            if (!$data) {
                return redirect()->back()->withErrors(['error' => 'Profile data not found.']);
            }

            // Pass everything to the view
            return view('parent-panel.profile.profile', compact('data', 'session', 'year_status', 'semster'));

        } catch (\Exception $e) {
            // Optional: log the error for debugging
            // \Log::error($e);

            return redirect()->route('parent-panel.dashboard')->with('error', 'Failed to get students.');
        }
    }


    public function edit()
    {
        $data['user']        = $this->user->show(Auth::user()->id);
        $data['title']       = "Profile Edit";
        return view('parent-panel.profile.edit', compact('data'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $result = $this->user->profileUpdate($request, Auth::user()->id);
        if ($result) {
            return redirect()->route('parent-panel.profile')->with('success', ___('alert.profile_updated_successfully'));
        }
        return redirect()->route('parent-panel.profile')->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }


    public function passwordUpdate()
    {
        $data['title'] = 'Password Update';
        return view('parent-panel.profile.update_password', compact('data'));
    }

    public function passwordUpdateStore(PasswordUpdateRequest $request)
    {
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $result = $this->user->passwordUpdate($request, Auth::user()->id);
            if ($result) {
                return redirect()->route('parent-panel.password-update')->with('success', ___('alert.password_updated_successfully'));
            }
            return redirect()->route('parent-panel.password-update')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        } else {
            return back()->with('danger', 'Current password is incorrect');
        }
    }
}
