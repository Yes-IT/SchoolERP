<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssignmentMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assignment_media';

    protected $fillable = [
        'assignment_id',
        'student_id',
        'media_type',
        'file_name',
        'path',
        'status',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

}
