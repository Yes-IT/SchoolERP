<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentInfo\Student;


class Assignment extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'assignments';

    protected $fillable = [
        'class_id',
        'subject_id',
        // 'student_id',
        'title',
        'grade',
        'description',
        'due_date',
        'assigned_date',
        'status',
        'created_by',
        'total_students',
        'submitted_count',
        'pending_count',
        
    ];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function class() {
        return $this->belongsTo(Classes::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function media()
    {
        return $this->hasMany(AssignmentMedia::class, 'assignment_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id')
                    ->with(['student', 'evaluator']);
    }


    
    


}
