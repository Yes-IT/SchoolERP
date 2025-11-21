<?php

namespace App\Http\Requests\Staff\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
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
            'title'                 => 'required|string|max:255',
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',

            'hebrew_title'          => 'required|string|max:255',
            'hebrew_first_name'     => 'nullable|string|max:255',
            'hebrew_last_name'      => 'nullable|string|max:255',

            'identification_number' => 'required|string|max:50|unique:staff,identification_number',

            'dob'                   => 'required|date|before:today',
            'hebrew_dob'            => 'nullable|date|before_or_equal:today',

            'neighborhood'          => 'nullable|string|max:255',
            'ssn'                   => 'nullable|string|max:50',

            'home_phone'            => 'nullable|max:20',
            'cell_phone'            => 'required|max:20',

            'email'                 => 'required|max:255|unique:users,email',

            'position'              => 'required|string|max:255',
            
            'address'               => 'required|string|max:255',
            'city'                  => 'required',
            'country'               => 'required',
            'zip_code'              => 'required|string|max:20',
        ];
    }
}
