<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends BaseModel
{
    use HasFactory;

    protected $table = 'class_rooms';

    protected $fillable = [
        'room_no','capacity'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'room_id');
    }
}
