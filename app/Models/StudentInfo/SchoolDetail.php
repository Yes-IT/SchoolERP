<?php

namespace App\Models\StudentInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class SchoolDetail extends BaseModel
{
    use HasFactory;

    protected $table = 'school_details';

    protected $fillable = [
        'school_id',
        'student_id',
        'school_year',
        'year_status',
        'college',
        'withdraw_date',
        'homeroom_class',
        'group',
        'division',
        'floor',
        'room',
        'homeroom_id',
        'group_id',
        'division_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}

