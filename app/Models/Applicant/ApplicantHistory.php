<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ApplicantHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aplicant_history';
    protected $fillable = [
        'applicant_id',
        'school',
        'school_tel',
        'grade',
        'advisor_name',
        'home',
        'home_cell',
        'email_address',
        'relation_name',
        'relation_address',
        'relation_phone',
        'relation_relationship',
        'school_name',
        'school_grades',
        'camp_names',
        'camp_years',
        'modified',
        'allergies',
        'medication',
        'surgery',
        'question',
        'about',
        'attendance_upload',
        'transcript_upload',
        'recommendation_upload',

    ];

    protected $casts = [
        'school_name' => 'array',
        'school_grades' => 'array',
        'camp_names' => 'array',
        'camp_years' => 'array',
    ];


}
