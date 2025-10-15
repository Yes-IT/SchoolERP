<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentInfo\Student;
class Apply_Leave extends Model
{
    use HasFactory;

    protected $table = 'apply_leaves';

    protected $fillable = [
        'from_date',
        'to_date',
        'reason',
        'status',
        'student_id',
    ];

    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
