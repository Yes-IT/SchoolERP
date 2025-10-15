<?php

namespace App\Models\Academic;

use App\Models\Academic\ClassSetup;
use App\Models\BaseModel;
use App\Models\ClassTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Staff\Staff;
use App\Models\StudentInfo\Student;

class Classes extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'identification_number',
        'subject_id',
        'teacher_id',
        'school_year_id',
        'semester_id',
        'year_status_id',
        'abbreviation',
        'is_class_scheduling',
        'composite_average',
        'composite_class_1',
        'composite_class_2',
        'composite_class_1_weight',
        'composite_class_2_weight',
    ];

    protected $appends = ['class_tran'];

    public function getClassTranAttribute()
    {
        $translation = $this->defaultTranslate()->first();
        return $translation->name ?? $this->name;

    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }
    public function classSetup()
    {
        return $this->hasOne(ClassSetup::class);
    }

    public function defaultTranslate()
    {
        $relation = $this->hasOne(ClassTranslate::class, 'class_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(ClassTranslate::class, 'class_id')->where('locale', 'en');
        }
    }


    public function translations()
    {
        return $this->hasMany(ClassTranslate::class, 'class_id', 'id');
    }

    //newly relationship
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id')
            ->where('role_id', 5); 
    }


    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }

    public function yearStatus()
    {
        return $this->belongsTo(YearStatus::class, 'year_status_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    // 1 class → many schedules
    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

    // 1 class → many rooms (through schedules)
    public function rooms()
    {
        return $this->hasManyThrough(
            ClassRoom::class,       
            ClassSchedule::class,   
            'class_id',             // FK on class_schedules table
            'id',                   // PK on class_rooms table
            'id',                   // PK on classes table
            'room_id'               // FK on class_schedules table
        );
    }


    public function students()
    {
        return $this->belongsToMany(
            Student::class, 
            'class_student',
            'class_id', 
            'student_id'
        ) 
         ->withPivot('status')      
         ->withTimestamps();        
    }

}
