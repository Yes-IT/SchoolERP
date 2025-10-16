<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantCheckList extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'applicant_check_list';
    protected $fillable = [
        'applicant_id',
        'fee',
        'cc_last_4',
        'date_deposited',
        'reference',
        'pictures',
        'hold_hebrew',
        'hold_english',
        'transcript_english',
        'transcript_hebrew',
    ];
}
