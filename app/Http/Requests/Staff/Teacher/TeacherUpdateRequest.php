<?php

namespace App\Http\Requests\Staff\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Staff\Staff;


class TeacherUpdateRequest extends FormRequest
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
        $teacherId = $this->route('id');
        $teacher   = Staff::find($teacherId); // get teacher to find its user_id
        $userId    = $teacher?->user_id; // null-safe

        return [
            'title'                 => 'nullable|string|max:255',
            'first_name'            => 'nullable|string|max:255',
            'last_name'             => 'nullable|string|max:255',

            'hebrew_title'          => 'nullable|string|max:255',
            'hebrew_first_name'     => 'nullable|string|max:255',
            'hebrew_last_name'      => 'nullable|string|max:255',

            'identification_number' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('staff', 'identification_number')->ignore($teacherId, 'id'),
            ],

            'dob'                   => 'nullable|date|before:today',
            'hebrew_dob'            => 'nullable|date|before_or_equal:today',

            'neighborhood'          => 'nullable|string|max:255',
            'ssn'                   => 'nullable|string|max:50',

            'home_phone'            => 'nullable|max:20',
            'cell_phone'            => 'nullable|max:20',

            'email'                 => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId, 'id'), // FIXED: now ignores correct user record
            ],

            'position'              => 'nullable|string|max:255',
            'inactive'              => 'nullable|boolean',
            'address'               => 'nullable|string|max:255',
            'city'                  => 'nullable|string|max:255',
            'zip_code'              => 'nullable|string|max:20',
            'country'               => 'nullable|string|max:255',

            'fileUpload'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
