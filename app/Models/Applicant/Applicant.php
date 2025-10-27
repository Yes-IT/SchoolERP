<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentInfo\ParentGuardian;

class Applicant extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'applicants';
    protected $fillable = [
        'custom_id',
        'last_name',
        'first_name',
        'high_school',
        'date_of_birth',
        'usa_cell',
        'email',
        'highschool_application',
    ];

   public function parents()
    {
        return $this->belongsToMany(
            ParentGuardian::class,
            'applicant_parents', 
            'applicant_id',      
            'parent_id'         
        );
    }

    public function checklist()
    {
        return $this->hasOne(ApplicantCheckList::class);
    }

    public function processing()
    {
        return $this->hasOne(ApplicationProcessing::class);
    }

    public function camps()
    {
        return $this->hasMany(ApplicantCamps::class);
    }
}
