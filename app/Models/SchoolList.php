<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolList extends Model
{
    use HasFactory;

    protected $table = 'school_list'; // table name

    protected $fillable = [
        'name',
        'status',
        'student_switch_cost',
    ];

    public static function getDestination()
    {
        return self::where('status', 1)
            ->pluck('name');
    }
}
