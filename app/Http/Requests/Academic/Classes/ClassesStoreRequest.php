<?php

namespace App\Http\Requests\Academic\Classes;

use Illuminate\Foundation\Http\FormRequest;

class ClassesStoreRequest extends FormRequest
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
            'class_name'      => 'required|max:255|unique:classes,name',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:staff,id',
            'session_id' => 'required|exists:sessions,id',
            'semester_id' => 'required|exists:semesters,id',
            'year_status_id' => 'required|exists:year_status,id',
            

        ];
    }
}
