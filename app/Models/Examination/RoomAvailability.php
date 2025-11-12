<?php

namespace App\Models\Examination;

use App\Models\Academic\ClassRoom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomAvailability extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'room_availabilities';

    protected $fillable = [
        'room_id',
        'exam_date',
        'start_time',
        'end_time',
        'is_booked',
        'exam_schedule_id',
        
    ];

    // belongs to a Room
    public function room()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    // belongs to a schedule (if booked)
    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class);
    }
}
