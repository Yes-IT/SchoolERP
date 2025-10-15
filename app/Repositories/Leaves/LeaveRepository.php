<?php

namespace App\Repositories\Leaves;

use App\Interfaces\Leaves\LeaveRepositoryInterface;
use App\Models\College;
use App\Models\Leave;
use App\Models\Transcript;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class LeaveRepository implements LeaveRepositoryInterface
{

    public function getStudentLeaves(Request $request)
    {
        $tab = $request->input('tab', 'applied');
        $perPage = $request->input('per_page', 2);
        $currentPage = $request->input('page', 1);

        // Fetch all leaves with student relation
        $leaves = Leave::with('student')->whereNull('teacher_id')->get();

        $appliedLeaves = [];
        $extendedLeaves = [];

        foreach ($leaves as $leave) {
            $fromDate = Carbon::parse($leave->from_date);
            $toDate   = Carbon::parse($leave->to_date);
            $days     = $fromDate->diffInDays($toDate) + 1;

            if ($days > 4) {
                $extendedLeaves[] = $leave;
            } else {
                $appliedLeaves[] = $leave;
            }
        }

        // Select collection based on tab
        $leavesCollection = $tab === 'extended'
            ? collect($extendedLeaves)
            : collect($appliedLeaves);

        // Paginate
        $paginatedLeaves = new LengthAwarePaginator(
            $leavesCollection->forPage($currentPage, $perPage),
            $leavesCollection->count(),
            $perPage,
            $currentPage,
            ['path' => route('leave.student.data'), 'query' => ['tab' => $tab]]
        );

        // Render Blade partial
        $html = view('backend.leave.student.list', [
            'appliedLeaves'  => $tab === 'applied' ? $paginatedLeaves : collect([]),
            'extendedLeaves' => $tab === 'extended' ? $paginatedLeaves : collect([]),
            'tab'            => $tab
        ])->render();

        return [
            'html'       => $html,
            'pagination' => (string) $paginatedLeaves->links('backend.partials.pagination', [
                'routeName' => 'leave.student.data',
                'query'     => array_merge($request->query(), ['tab' => $tab])
            ])
        ];
    }
    
    public function getTeacherLeaves(Request $request)
    {
        $tab = $request->input('tab', 'pending');
        $perPage = $request->input('per_page', 2);
        $currentPage = $request->input('page', 1);
        $filters = $request->only(['year', 'year_status', 'semester']);

        // Build query for teacher leaves
        $query = Leave::whereNull('student_id');

        // Apply filters if provided
        if (!empty($filters['year'])) {
            $query->whereYear('apply_date', $filters['year']);
        }
        if (!empty($filters['year_status'])) {
            $query->where('status', $filters['year_status']);
        }
        if (!empty($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        // Filter based on tab
        if ($tab === 'pending') {
            $query->where('is_approved', 0);
        } else {
            $query->whereIn('is_approved', [1, 2]);
        }

        // Paginate directly from database
        $paginatedLeaves = $query->paginate($perPage, ['*'], 'page', $currentPage);

        // Render Blade partial
        $html = view('backend.leave.teacher.list', [
            'pendingLeaves' => $tab === 'pending' ? $paginatedLeaves : collect([]),
            'appliedLeaves' => $tab === 'applied' ? $paginatedLeaves : collect([]),
            'tab' => $tab
        ])->render();

        return [
            'html' => $html,
            'pagination' => (string) $paginatedLeaves->links('backend.partials.pagination', [
                'routeName' => 'leave.teacher.data',
                'query' => array_merge($request->query(), ['tab' => $tab])
            ])
        ];
    }

    public function getCollegeRecords(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $currentPage = $request->input('page', 1);
        $filters = $request->only(['year']);

        // Build query for college records
        $query = College::query();

        $query->orderByDesc('date');

        // Paginate directly from database
        $paginatedColleges = $query->paginate($perPage, ['*'], 'page', $currentPage);

        // Render Blade partial
        $html = view('backend.leave.college.list', [
            'colleges' => $paginatedColleges
        ])->render();

        return [
            'html'       => $html,
            'pagination' => (string) $paginatedColleges->links('backend.partials.pagination', [
                'routeName' => 'transcript.college.data',
                'query'     => $request->query()
            ])
        ];
    }


public function getTranscriptRequests(Request $request)
    {
        $tab = $request->input('tab', 'pending');
        $perPage = $request->input('per_page', 2);
        $currentPage = $request->input('page', 1);

        // Fetch all transcripts
        $query = Transcript::query();
        $transcripts = $query->get();

        // Split into pending and final
        $pendingTranscripts = [];
        $finalTranscripts = [];

        foreach ($transcripts as $transcript) {
            if ($transcript->status === 'pending') {
                $pendingTranscripts[] = $transcript;
            } else {
                $finalTranscripts[] = $transcript;
            }
        }

        // Select collection based on tab
        $transcriptsCollection = $tab === 'pending'
            ? collect($pendingTranscripts)
            : collect($finalTranscripts);

        // Paginate
        $paginatedTranscripts = new LengthAwarePaginator(
            $transcriptsCollection->forPage($currentPage, $perPage),
            $transcriptsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => route('transcript.data'), 'query' => array_merge($request->query(), ['tab' => $tab])]
        );

        // Render Blade partial
        $html = view('backend.leave.transcript.list', [
            'pendingTranscripts' => $tab === 'pending' ? $paginatedTranscripts : collect([]),
            'finalTranscripts' => $tab === 'final' ? $paginatedTranscripts : collect([]),
            'tab' => $tab,
            'perPage' => $perPage,
            'pagination' => $paginatedTranscripts->links('backend.partials.pagination', [
                'routeName' => 'transcript.data',
                'query' => array_merge($request->query(), ['tab' => $tab])
            ])->toHtml()
        ])->render();

        return [
            'html' => $html,
            'pagination' => $paginatedTranscripts->links('backend.partials.pagination', [
                'routeName' => 'transcript.data',
                'query' => array_merge($request->query(), ['tab' => $tab])
            ])->toHtml()
        ];
    }    

    
}
