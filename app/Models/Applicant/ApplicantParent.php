<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantParent extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'applicant_parents';
    protected $fillable = [
        
        'applicant_id',
        'parent_id',
        'relation_type',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'marital_status',
        'marital_comment',
        'home_phone',
        
    ];
}
