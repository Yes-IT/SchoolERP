<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Repositories\Staff\TeacherRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileRepo;

    public function __construct(ProfileRepository $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    public function index()
    {
        $user = auth()->user();
        $data = $this->profileRepo->getProfile($user);

        return response()->json([
            'status' => true,
            'message' => 'Profile fetched successfully',
            'data' => $data,
        ]);
    }

    public function show(Request $request)
    {
        $user = auth()->user();
        $data = $this->profileRepo->getProfile($user);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function edit(Request $request)
    {
        $user = auth()->user();
        $data = $this->profileRepo->getProfile($user);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'mobile'    => 'nullable|string|max:20',
            'password'  => 'nullable|min:6|confirmed',
        ]);

        $updated = $this->profileRepo->updateProfile($user, $validated);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $updated,
        ]);
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();

        $this->profileRepo->deleteProfile($user);

        return response()->json([
            'status' => true,
            'message' => 'Profile deleted successfully',
        ]);
    }
}