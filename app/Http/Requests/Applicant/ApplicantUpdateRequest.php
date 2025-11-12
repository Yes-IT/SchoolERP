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
       return true;
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'usa_cell' => 'nullable|string|max:20',
            'high_school_id' => 'required', 
            'high_school' => 'nullable|string|max:255|required_if:high_school_id,other',
            'date_of_birth' => 'nullable|date',
            'highschool_application' => 'nullable|string|max:50',

            // Parents (nested array)
            'parents' => 'array|nullable',
            'parents.father_title' => 'nullable|string|max:50',
            'parents.father_name' => 'nullable|string|max:100',
            'parents.father_last_name' => 'nullable|string|max:100',
            'parents.mother_title' => 'nullable|string|max:50',
            'parents.mother_name' => 'nullable|string|max:100',
            'parents.maiden_name' => 'nullable|string|max:100',
            'parents.address' => 'nullable|string|max:255',
            'parents.city' => 'nullable|string|max:100',
            'parents.state' => 'nullable|string|max:100',
            'parents.zip_code' => 'nullable|string|max:6',
            'parents.country' => 'nullable|string|max:100',
            'parents.marital_status' => 'nullable|string|max:50',
            'parents.marital_comment' => 'nullable|string|max:255',
            'parents.home_phone' => 'nullable|string|max:20',
            'parents.father_cell' => 'nullable|string|max:20',
            'parents.mother_cell' => 'nullable|string|max:20',
            'parents.father_email' => 'nullable|email|max:255',
            'parents.mother_email' => 'nullable|email|max:255',
            'parents.father_occupation' => 'nullable|string|max:100',
            'parents.mother_occupation' => 'nullable|string|max:100',
            'parents.additional_phone_no' => 'nullable|string|max:20',
            'parents.additional_emails' => 'nullable|string|max:255',
            // 'parents.siblings' => 'nullable|integer|min:0',

            // Camp history (arrays)
            'school_name' => 'array|nullable',
            'school_name.*' => 'nullable|string|max:255',
            'school_grades' => 'array|nullable',
            'school_grades.*' => 'nullable|string|max:50',

            // Transaction
            'transaction' => 'array|nullable',
            'transaction.amount' => 'nullable|numeric',
            'transaction.card_last4' => 'nullable|string|max:4',

            // Checklist (Confirmation)
            'checklist' => 'array|nullable',
            'checklist.date_deposited' => 'nullable|date',
            'checklist.reference' => 'nullable|string|max:255',
            'checklist.pictures' => 'nullable|string|max:50',
            'checklist.transcript_hebrew' => 'nullable|boolean',
            'checklist.transcript_english' => 'nullable|boolean',

            // Processing
            'processing' => 'array|nullable',
            'processing.interview_date' => 'nullable|date',
            'processing.interview_time' => 'nullable|string|max:50',
            'processing.interview_location' => 'nullable|string|max:255',
            'processing.interview_status' => 'nullable|integer|in:0,1,2',
            'processing.coming' => 'nullable|string|max:50',
            'processing.application_comment' => 'nullable|string',
            'processing.scholarship_comment' => 'nullable|string',
            'processing.tution_comment' => 'nullable|string',
            'processing.letter_sent' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'high_school.required_if' => 'The other high school field is required when "Other" is selected.',
        ];
    }

    
   
}
