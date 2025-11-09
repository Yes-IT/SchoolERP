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
        'father_last_name',
        'father_title',
        'father_name',
        'father_email',
        'father_cell',
        'father_occupation',
        'mother_title',
        'mother_name',
        'mother_email',
        'mother_cell',
        'mother_occupation',
        'maiden_name',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'marital_status',
        'marital_comment',
        'home_phone',
        'additional_phone_no',
        'additional_email_addresses',
        
    ];
}
