<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\StudentInfo\Student;


class AssignmentSubmission extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'assignment_submissions';
    protected $fillable = [
        'assignment_id',
        'student_id',
        'evaluated_by',
        'subject_id',
        'grade',
        'note',
        'file_path',
        'status',
        'submitted_at',
        'evaluated_at',
    ];

    protected $dates = ['submitted_at', 'evaluated_at'];

    
        public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

        public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by')
                    ->where('role_id', 5); // only teachers
    }

        public function assignment()
        {
        return $this->belongsTo(Assignment::class, 'assignment_id');
        }


}
