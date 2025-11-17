<?php

namespace App\Repositories\Academic;

use App\Interfaces\Academic\AssignmentInterface;
use App\Models\Academic\Assignment;
use Illuminate\Support\Facades\Log;
use Exception;

class AssignmentRepository implements AssignmentInterface
{
    private $model;

    public function __construct(Assignment $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['subject', 'class', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();
    }



    public function store($request)
    {
        return Assignment::create([
            'subject_id'      => $request->subject_id,
            'class_id'        => $request->class_id,
            'title'           => $request->title,
            'grade'           => $request->grade,
            'attachment'      => $request->attachment,
            'description'     => $request->description,
            'due_date'        => $request->due_date,
            'created_by'      => auth()->id(),
            'total_students'  => $request->total_students ?? 0,
            'submitted_count' => 0,
            'pending_count'   => $request->total_students ?? 0,
            'status'          => 1,
        ]);
    }

    

    public function show($id)
    {
        try {
            $assignment = $this->model
                ->with([
                    'class',
                    'subject',
                    'creator',
                    'media',
                    'submissions.student',
                    'submissions.evaluator'
                ])
                ->find($id);

            if (!$assignment) {
                Log::warning("Assignment not found for ID: {$id}");
                return null; 
            }

            return $assignment;

        } catch (Exception $e) {
            Log::error("Error fetching assignment ID {$id}: " . $e->getMessage());
            return null; 
        }
    }


    public function update($request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->update($request->all());
        return $assignment;
    }

    public function destroy($id)
    {
        return Assignment::destroy($id);
    }

    public function getPendingAssignmentRequests()
    {
        return Assignment::where('status', 0)
            ->with(['class', 'subject', 'creator'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function getAcceptedAssignmentRequests($request = null)
    {
        $query = Assignment::where('status', 1) 
            ->with(['class', 'subject', 'creator']);

        // If request object is provided, apply filters
        if ($request) {
            // Apply filters from request
            if ($request->has('year_id') && $request->year_id != '') {
                $query->whereHas('class.session', function($q) use ($request) {
                    $q->where('id', $request->year_id);
                });
            }
            
            if ($request->has('year_status_id') && $request->year_status_id != '') {
                $query->whereHas('class.yearStatus', function($q) use ($request) {
                    $q->where('id', $request->year_status_id);
                });
            }
            
            if ($request->has('semester_id') && $request->semester_id != '') {
                $query->whereHas('class.semester', function($q) use ($request) {
                    $q->where('id', $request->semester_id);
                });
            }
            
            if ($request->has('class_id') && $request->class_id != '') {
                $query->where('class_id', $request->class_id);
            }
            
            if ($request->has('subject_id') && $request->subject_id != '') {
                $query->where('subject_id', $request->subject_id);
            }
            
            // Date range filter
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('assigned_date', '>=', $request->start_date);
            }
            
            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('assigned_date', '<=', $request->end_date);
            }
        }

        return $query->orderByDesc('assigned_date')->get();
    }


    public function getRejectedAssignmentRequests()
    {
        return Assignment::where('status', 2)
            ->with(['class', 'subject', 'creator'])
            ->orderByDesc('updated_at')
            ->get();
    }

    public function changeStatus($id, $status)
    {
        $assignment = Assignment::findOrFail($id);

        if ($status == 1 && $assignment->status != 1) {
            $assignment->assigned_date = now();
        }

        $assignment->status = $status;
        $assignment->save();

        return $assignment;
    }

    public function filterAssignments(array $filters)
    {
        $acceptedQuery = $this->model->where('status', 'accepted');
        $pendingQuery = $this->model->where('status', 'pending');

        $applyFilters = function ($query) use ($filters) {
            if (!empty($filters['year_id'])) {
                $query->where('year_id', $filters['year_id']);
            }
            if (!empty($filters['year_status_id'])) {
                $query->where('year_status_id', $filters['year_status_id']);
            }
            if (!empty($filters['semester_id'])) {
                $query->where('semester_id', $filters['semester_id']);
            }
            if (!empty($filters['class_id'])) {
                $query->where('class_id', $filters['class_id']);
            }
            if (!empty($filters['subject_id'])) {
                $query->where('subject_id', $filters['subject_id']);
            }
            if (!empty($filters['date'])) {
                $query->whereDate('due_date', $filters['date']);
            }
        };

        $applyFilters($acceptedQuery);
        $applyFilters($pendingQuery);

        return [
            'accepted' => $acceptedQuery
                ->with(['subject', 'class', 'creator'])
                ->get(),

            'pending' => $pendingQuery
                ->with(['subject', 'class', 'creator'])
                ->get(),
        ];
    }



}
