<?php

namespace App\Models;

use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'session_id',
        'classes_id',
        'section_id',
        'semester_id',
        'apply_date',
        'from_date',
        'to_date',
        'is_approved',
        'approved_date',
        'reason',
    ];

    // Example relationships (if needed)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
   

}
