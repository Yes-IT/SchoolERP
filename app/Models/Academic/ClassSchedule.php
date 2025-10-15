<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'class_schedules';
    protected $fillable = [
        'class_id','day','period','start_time','end_time','room_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function room()
    {
        return $this->belongsTo(ClassRoom::class, 'room_id');
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

}
