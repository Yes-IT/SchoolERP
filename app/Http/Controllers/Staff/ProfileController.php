<?php

namespace App\Http\Controllers\Staff;

use App\Models\Staff\Staff;
use App\Models\Academic\Classes;

use App\Http\Controllers\Controller;
use App\Repositories\Staff\TeacherRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profile;

    public function __construct(TeacherRepository $profile)
    {
        $this->profile = $profile;
    }

    public function index()
    {
        $data['title'] = 'Profile';

        $authUser = auth()->user();
        
        $data['staff'] = Staff::with('upload')
                        ->where('user_id', $authUser->id)->first();

        return view('staff.profile.profile-index', compact('data'));
    }
}