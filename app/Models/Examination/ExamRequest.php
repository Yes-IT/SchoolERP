<?php

namespace App\Models\Examination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Academic\Classes;
use App\Models\Academic\ClassRoom;
use App\Models\Staff\Staff;
use App\Models\Academic\Subject;
use App\Enums\ExamRequestStatus;


class ExamRequest extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'exam_requests';

    protected $fillable = [
        'exam_type_id',
        'subject_id',
        'room_id',    
        'teacher_id',
        'class_id',
        'exam_date',
        'start_time',
        'end_time',
        'duration',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'status' => ExamRequestStatus::class,
    ];


     public function examType()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }

   
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

   
    public function room()
    {
        return $this->belongsTo(ClassRoom::class, 'room_id');
    }

  
    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id')
            ->where('role_id', 5); 
        // dd($this->teacher);
    }

    

    //  Accessor for Full Name (Optional: can also put inside Staff model)
    public function getTeacherNameAttribute()
    {
        return $this->teacher ? $this->teacher->first_name . ' ' . $this->teacher->last_name : null;
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }


}
