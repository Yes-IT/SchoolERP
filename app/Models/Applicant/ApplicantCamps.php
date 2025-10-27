<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantCamps extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = 'applicant_camps';
    protected $fillable = [
        'id',
        'applicant_id',
        'camp',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
