<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Leave;

class ApplyLeaveController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $data['title'] = 'Apply Leave';

        $authUser = auth()->user();

        if (!$authUser || !$authUser->staff) {
            abort(403, 'Staff record not found for this user.');
        }

        $data['leaves'] = $authUser->staff
            ->leaves()
            ->with('teacher')
            ->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        if ($request->ajax()) {
            $view = view('staff.apply-leave.leave-list', compact('data', 'perPage'))->render();
            return response()->json(['html' => $view]);
        }

        return view('staff.apply-leave.apply-leave-index', compact('data', 'perPage'));
    }

    public function applyForLeave(Request $request)
    {

        $authUser = auth()->user();

        if (!$authUser) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found',
            ]);
        }

        $validated = $request->validate([
            'from_date' => 'required|date_format:Y-m-d',
            'to_date'   => 'required|date_format:Y-m-d|after_or_equal:from_date',
            'reason'    => 'required|string|max:500',
        ],[
            'from_date.required' => 'The From Date field is required.',
            'to_date.required' => 'The To Date field is required.',
            'to_date.after_or_equal' => 'To Date must be after or same as From Date.',
        ]);

        $leave = new Leave();
        $leave->teacher_id = $authUser->staff->id;
        $leave->from_date = $validated['from_date'];
        $leave->to_date = $validated['to_date'];
        $leave->reason = $validated['reason'];
        $leave->apply_date = now();
        $leave->is_approved = 0;
        $leave->save();

        return response()->json([
            'status'  => true,
            'message' => 'Leave request submitted successfully.',
        ]);
    }

    public function showLeave($id)
    {
        $leave = Leave::where('id', $id)->first();

        if (!$leave) {
            return response()->json([
                'status'  => false,
                'message' => 'Leave request not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $leave,
        ]);
    }

    public function updateLeave(Request $request, $id)
    {
        $leave = Leave::where('id', $id)->first();

        if (!$leave) {
            return response()->json([
                'status'  => false,
                'message' => 'Leave request not found.',
            ], 404);
        }

        $validated = $request->validate([
            'from_date' => 'required|date_format:Y-m-d',
            'to_date'   => 'required|date_format:Y-m-d|after_or_equal:from_date',
            'reason'    => 'required|string|max:500',
        ],[
            'from_date.required' => 'The From Date field is required.',
            'to_date.required' => 'The To Date field is required.',
            'to_date.after_or_equal' => 'To Date must be after or same as From Date.',
        ]);

        $leave->from_date = $validated['from_date'];
        $leave->to_date = $validated['to_date'];
        $leave->reason = $validated['reason'];
        $leave->save();

        return response()->json([
            'status'  => true,
            'message' => 'Leave request updated successfully.',
        ]);
    }

    public function deleteLeave(Request $request, $id)
    {
        $leave = Leave::where('id', $id)->first();

        if (!$leave) {
            return response()->json([
                'status'  => false,
                'message' => 'Leave request not found.',
            ], 404);
        }

        $leave->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Leave request deleted successfully.',
        ]);
    }

}
