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
        'student_id',
        'classes_id',
        'semester_id',
        'school_years_id',
        'average',
        'personal_absences',
        'excused_absences',
        'reduced',
        'percentage',
        'report_card',
        'transcript',
    ];
}