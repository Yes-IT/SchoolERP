<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Academic\Semester;
use App\Models\Academic\YearStatus;
use App\Models\Session;
use Illuminate\Http\Request;

class StaffSessionController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'session_id'     => 'required|exists:sessions,id',
            'semester_id'    => 'required|exists:semesters,id',
            'year_status_id' => 'required|exists:year_status,id',
        ]);

        $data = [
            'session_id'      => $request->session_id,
            'session_name'    => Session::find($request->session_id)->name,
            'semester_id'     => $request->semester_id,
            'semester_name'   => Semester::find($request->semester_id)->name,
            'year_status_id'  => $request->year_status_id,
            'year_status_name'=> YearStatus::find($request->year_status_id)->name,
        ];

        session(['staff_active_session' => $data]);

        return response()->json(['success' => true]);
    }
}