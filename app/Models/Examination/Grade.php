<?php

namespace App\Models\Examination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    // Fillable columns
    protected $fillable = [
        'class',
        'average',
        'personal_absences',
        'excused_absences',
        'reduced',
        'percentage',
        'report_card',
        'transcript',
        'semester',
        'year',
    ];

    public static $semesterOptions = [
        0 => 'Full Year',
        1 => 'First Semester',
        2 => 'Second Semester',
    ];



    public function scopeFilter($query, $year = null, $semester = null)
    {
        if ($year !== null) {
            $query->where('year', $year);
        }

        if ($semester !== null) {
            $query->where('semester', $semester);
        }

        return $query;
    }
}
