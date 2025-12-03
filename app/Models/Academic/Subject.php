<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\SubjectAssignChildren;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Staff\Staff;


class Subject extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name','code','type','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function subjectAssignChildrens(): HasMany
    {
        return $this->hasMany(SubjectAssignChildren::class, 'subject_id', 'id');
    }

    //newly relationship
    public function classes()
    {
        return $this->hasMany(Classes::class, 'subject_id', 'id');
    }

    // public function teachers()
    // {
    //     return $this->hasManyThrough(
    //         Staff::class,
    //         Classes::class,
    //         'subject_id',   // FK on classes table
    //         'id',           // PK on teachers table
    //         'id',           // PK on subjects table
    //         'teacher_id'    // FK on classes table
    //     )->where('role_id', 5);
    // }

    public function teachers()
    {
        return $this->hasManyThrough(
            Staff::class,
            Classes::class,
            'subject_id',    // FK in classes
            'id',            // PK in staff
            'id',            // PK in subject
            'teacher_id'     // FK in classes
        );
    }








    
}
