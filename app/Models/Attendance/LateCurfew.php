<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentInfo\Student;

class LateCurfew extends Model
{
    use HasFactory;

    protected $table = 'late_curfew';

    protected $fillable = [
        'date',
        'time',
        'room',
        'reason',
        'status',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
