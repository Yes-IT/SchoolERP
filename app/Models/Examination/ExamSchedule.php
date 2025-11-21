<?php

namespace App\Models\Examination;

use App\Models\Academic\ClassRoom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSchedule extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'exam_schedules';

    protected $fillable = [
        'exam_request_id',
        'room_id',
        'exam_date',
        'start_time',
        'end_time',
        'allocated_students',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    // belongs to Exam Request
    public function examRequest()
    {
        return $this->belongsTo(ExamRequest::class);
    }

    // belongs to Room
    public function room()
    {
        return $this->belongsTo(ClassRoom::class,'room_id');
    }

    // each schedule may have availability slots
    public function availabilities()
    {
        return $this->hasMany(RoomAvailability::class);
    }
}
