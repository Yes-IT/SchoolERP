<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassStudent extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'class_student';

    protected $fillable = [
        'class_id',
        'student_id',
        'status',
    ];

}
