<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationProcessing extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'application_processing';
    protected $fillable = [
        'applicant_id',
        'interview_date',
        'interview_time',
        'interview_location',
        'status',
        'coming',
        'application_comment',
        'scholarship_comment',
        'tution_comment',
        'letter_sent',
         
        ];
}
