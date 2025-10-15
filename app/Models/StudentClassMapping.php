<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\Classes;
use App\Models\Staff\Staff;

class StudentClassMapping extends Model
{
    use HasFactory;
    protected $table = 'student_class_mapping';

    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_id',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id'); 
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id'); 
    }
}
