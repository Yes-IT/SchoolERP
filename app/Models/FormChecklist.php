<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentInfo\Student;

class FormChecklist extends Model
{
    use HasFactory;
    protected $table = 'form_checklist';

    protected $fillable = [
        'student_id',
        'school_year',
        'year_status',
        'travel_from',
        'flight_date',
        'flight_info',
        'checklist',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
