<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
         return [
            // Applicant fields
            'custom_id' => 'nullable|string|max:1000',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'high_school' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'usa_cell' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'highschool_application' => 'nullable|string|max:255',

            //application checklist


            //application processing
            

            //  Parent fields
            'father_title' => 'nullable|string|max:100',
            'father_name' => 'nullable|string|max:255',
            'mother_title' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:100',
            'marital_comment' => 'nullable|string',
            'home_phone' => 'nullable|string|max:50',
            'father_cell' => 'nullable|string|max:50',
            'mother_cell' => 'nullable|string|max:50',
            'father_email' => 'nullable|email|max:255',
            'mother_email' => 'nullable|email|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'additional_phone_no' => 'nullable|string|max:255',
            'additional_emails' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
        ];
    }
}