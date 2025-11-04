<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // Applicant info
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'usa_cell' => 'nullable|string|max:20',
            'high_school' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'highschool_application' => 'nullable|string|max:255',

            // Parents (nested array)
            'parents' => 'array|nullable',
            'parents.*.father_name' => 'nullable|string|max:100',
            'parents.*.mother_name' => 'nullable|string|max:100',
            'parents.*.father_email' => 'nullable|email|max:255',
            'parents.*.mother_email' => 'nullable|email|max:255',

            // Camps
            'camps' => 'array|nullable',
            'camps.*.camp' => 'nullable|string|max:255',
            'camps.*.position' => 'nullable|string|max:255',

            // Checklist
            'checklist' => 'array|nullable',
            'checklist.fee' => 'nullable|string|max:50',
            'checklist.cc_last_4' => 'nullable|string|max:10',
            'checklist.date_deposited' => 'nullable|string|max:50',
            'checklist.reference' => 'nullable|string|max:255',

            // Processing
            'processing' => 'array|nullable',
            'processing.interview_date' => 'nullable|date',
            'processing.interview_time' => 'nullable|string|max:50',
            'processing.interview_location' => 'nullable|string|max:255',
            'processing.status' => 'nullable|string|max:50',
        ];
    }
}
