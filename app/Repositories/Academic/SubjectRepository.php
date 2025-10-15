<?php

namespace App\Repositories\Academic;

use App\Enums\Settings;
use App\Interfaces\Academic\SubjectInterface;
use App\Models\Academic\Subject;
use App\Traits\ReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectRepository implements SubjectInterface
{
    use ReturnFormatTrait;
    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function getDistinctNames()
    {
        return $this->subject->select('name')->distinct()->get();
    }

    public function getFiltered(Request $request, $perPage)
    {
        $query = $this->subject->query();
        if ($subjectName = $request->query('subject_name')) {
            $query->where('name', $subjectName);
        }
        return $query->latest()->paginate($perPage)->appends($request->query());
    }

    
    // In your SubjectRepository
    public function store($request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:100|unique:subjects,code',
            'name' => 'required|string|max:255',
            'credits' => 'required|numeric|min:0|max:100',
            'allowed_absences' => 'required|integer|min:0',
            'allowed_penalty_amount' => 'required|numeric|min:0',
            'number_latenesses_equal_absence' => 'required|integer|min:0',
            'attendance_percent_auto_fail' => 'nullable|boolean',
            'hebrew_attendance' => 'nullable|boolean',
            'report_card' => 'nullable|boolean',
            'attendance_percent_amount' => 'required|numeric|min:0|max:100',
            'attendance_percent_fail_grade' => 'required|string|max:50',
            'gpa_weight' => 'required|numeric|min:0|max:10',
            'prec_rc' => 'required|string|max:100',
            'transcript_name' => 'required|string|max:255',
            'course_number' => 'required|string|max:50',
            'college_transcript' => 'nullable|boolean',
            'prec_transcript' => 'required|string|max:50',
            'charter_oak_transcript' => 'nullable|boolean',
            'co_year_long' => 'nullable|boolean',
            'co_department' => 'required|string|max:255',
            'elective' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            // Return validation errors in the format your controller expects
            return $this->responseWithError('Validation failed', $validator->errors()->messages());
        }

        try {
            $subject = $this->subject->create([
                'code' => $request->code,
                'name' => $request->name,
                'course_number' => $request->course_number,
                'transcript_name' => $request->transcript_name,
                'co_department' => $request->co_department,
                'credits' => $request->credits,
                'gpa_weight' => $request->gpa_weight,
                'allowed_absences' => $request->allowed_absences,
                'number_latenesses_equal_absence' => $request->number_latenesses_equal_absence,
                'attendance_percent_auto_fail' => $request->boolean('attendance_percent_auto_fail'),
                'attendance_percent_amount' => $request->attendance_percent_amount,
                'attendance_percent_fail_grade' => $request->attendance_percent_fail_grade,
                'allowed_penalty_amount' => $request->allowed_penalty_amount,
                'hebrew_attendance' => $request->boolean('hebrew_attendance'),
                'report_card' => $request->boolean('report_card'),
                'prec_rc' => $request->prec_rc,
                'college_transcript' => $request->boolean('college_transcript'),
                'prec_transcript' => $request->prec_transcript,
                'charter_oak_transcript' => $request->boolean('charter_oak_transcript'),
                'co_year_long' => $request->boolean('co_year_long'),
                'elective' => $request->boolean('elective'),
                'comment' => $request->comment,
            ]);

            return $this->responseWithSuccess(__('created_successfully'), $subject);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function show($id)
    {
        try {
            $subject = $this->subject->findOrFail($id);
            return $this->responseWithSuccess(__('alert.fetched_successfully'), $subject);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function update($request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'credits' => 'required|numeric|min:0|max:100',
            'allowed_absences' => 'required|integer|min:0',
            'allowed_penalty_amount' => 'required|numeric|min:0',
            'number_latenesses_equal_absence' => 'required|integer|min:0',
            'attendance_percent_auto_fail' => 'nullable|boolean',
            'hebrew_attendance' => 'nullable|boolean',
            'report_card' => 'nullable|boolean',
            'attendance_percent_amount' => 'required|numeric|min:0|max:100',
            'attendance_percent_fail_grade' => 'required|string|max:50',
            'gpa_weight' => 'required|numeric|min:0|max:10',
            'prec_rc' => 'required|string|max:100',
            'transcript_name' => 'required|string|max:255',
            'course_number' => 'required|string|max:100',
            'college_transcript' => 'nullable|boolean',
            'prec_transcript' => 'required|string|max:100',
            'charter_oak_transcript' => 'nullable|boolean',
            'co_year_long' => 'nullable|boolean',
            'co_department' => 'required|string|max:255',
            'elective' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()->first(), []);
        }

        try {
            $subject = $this->subject->findOrFail($id);
            $subject->update([
                'name' => $request->name,
                'course_number' => $request->course_number,
                'transcript_name' => $request->transcript_name,
                'co_department' => $request->co_department,
                'credits' => $request->credits,
                'gpa_weight' => $request->gpa_weight,
                'allowed_absences' => $request->allowed_absences,
                'number_latenesses_equal_absence' => $request->number_latenesses_equal_absence,
                'attendance_percent_auto_fail' => $request->attendance_percent_auto_fail ?? 0,
                'attendance_percent_amount' => $request->attendance_percent_amount,
                'attendance_percent_fail_grade' => $request->attendance_percent_fail_grade,
                'allowed_penalty_amount' => $request->allowed_penalty_amount,
                'hebrew_attendance' => $request->hebrew_attendance ?? 0,
                'report_card' => $request->report_card ?? 0,
                'prec_rc' => $request->prec_rc,
                'college_transcript' => $request->college_transcript ?? 0,
                'prec_transcript' => $request->prec_transcript,
                'charter_oak_transcript' => $request->charter_oak_transcript ?? 0,
                'co_year_long' => $request->co_year_long ?? 0,
                'elective' => $request->elective ?? 0,
                'comment' => $request->comment,
            ]);

            return $this->responseWithSuccess(__('alert.updated_successfully'), $subject);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $subject = $this->subject->findOrFail($id);
            $subject->delete();
            return $this->responseWithSuccess(__('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong_please_try_again'), []);
        }
    }
}