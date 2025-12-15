<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\ParentPanel\Profile\ProfileUpdateRequest;
use App\Http\Requests\ParentPanel\Profile\PasswordUpdateRequest;
use App\Models\StudentInfo\Student;
use DB;

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

    public function profile()
    {
        $first_student = Student::where('parent_guardian_id', Auth::id())->first();

        $student = Student::where('user_id', $first_student->user_id)->first();
        $data = DB::table('students')
            ->leftjoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('uploads', 'users.upload_id', '=', 'uploads.id')
            ->leftJoin('parent_guardians', 'parent_guardians.student_id', '=', 'students.id')
            ->select('students.*', 'students.student_id as s_student_id', 'users.name as user_name', 'users.email', 'uploads.path as image_path', 'parent_guardians.*')
            ->where('students.user_id', $first_student->user_id)
            ->first();
        if (!$data) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }
        return view('parent-panel.profile.profile', compact('data'));
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
