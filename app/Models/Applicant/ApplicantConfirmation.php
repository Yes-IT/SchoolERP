<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantConfirmation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ='aplicant_confirmation';
    protected $fillable=[
        'id',
        'application_id',
        'parent_email',
        'confirm_applicant',
        'applicant_date',
        'applicant_signature',
        'guardian_name',
        'gaurdian_date',
        'guardian_signature',
        'agree',
        'billing_email',
        'billing_address',
        'billing_state',
        'billing_city',
        'billing_zip',
        'billing_country',
        'billing_card',
        'exp_date',
        'security_code',
        'card_holder_name',
        'reference',
        'pictures',
        'transcript_hebrew',
        'transcript_english',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
