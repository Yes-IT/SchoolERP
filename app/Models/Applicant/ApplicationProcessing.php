<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Applicant\Applicant;

class ApplicationProcessing extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'interview_processing';
    
    protected $fillable = [
        'applicant_id',
        'interview_mode',
        'interview_date',
        'interview_time',
        'interview_link',
        'start_time',
        'end_time',
        'interview_location',
        'status',
        'coming',
        'application_comment',
        'scholarship_comment',
        'tution_comment',
        'letter_sent',
        'interview_status',
         
        ];

    protected $casts = [
        'interview_date' => 'datetime',
    ];


    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }

}
