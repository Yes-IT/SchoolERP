<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\StudentInfo\ParentGuardian;
use App\Enums\ApplicantStatus;
use App\Models\Applicant\{ApplicationProcessing,ApplicantHistory,ApplicantConfirmation,PaymentTransaction,ApplicantParent};
use App\Models\HighSchool;

class Applicant extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'applicants';
    protected $fillable = [
        'custom_id',
        'last_name',
        'first_name',
        'high_school',
        'high_school_id',
        'other_high_school',
        'date_of_birth',
        'usa_cell',
        'email',
        'highschool_application',
        'user_id',
        'prefered_name',
        'hebrew_first_name',
        'hebrew_name',
        'address',
        'city',
        'state',
        'country',
        'cell',
        'number',
        'hdob',
        'applicant_status',
        'session_id',
        'year_status_id',
        
    ];

    protected $casts = [
        'applicant_status' => ApplicantStatus::class,
    ];

    public function parents()
    {
        return $this->hasMany(ApplicantParent::class, 'applicant_id', 'id')
            ->whereNull('deleted_at');
    }


    

    public function processing()
    {
        return $this->hasOne(ApplicationProcessing::class, 'applicant_id')->withDefault([
            'interview_state' => 0,
            'interview_status' => 'pending',
        ]);
    }

    public function camps()
    {
        return $this->hasMany(ApplicantCamps::class);
    }

      
    public function confirmation()
    {
        return $this->hasOne(ApplicantConfirmation::class, 'applicant_id');
    }

    public function transaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'applicant_id');
    }

    public function history()
    {
        return $this->hasMany(ApplicantHistory::class, 'applicant_id');
    }

    public function highSchool()
    {
        return $this->belongsTo(HighSchool::class, 'high_school_id');
    }




}
