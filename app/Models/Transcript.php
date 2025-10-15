<?php

namespace App\Models;

use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcript extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'destination',
        'payment_requirement',
        'payment_status',
        'payment_receipt_link',
        'status',
    ];

    protected $casts = [
        'payment_requirement' => 'string',
        'payment_status' => 'integer',
        'status' => 'integer',
    ];

    // Accessor for payment_status
    public function getPaymentStatusAttribute($value)
    {
        return match ($value) {
            0 => 'pending',
            1 => 'paid',
            2 => 'failed',
            default => 'unknown',
        };
    }

    // Accessor for status
    public function getStatusAttribute($value)
    {
        return match ($value) {
            0 => 'pending',
            1 => 'approved',
            2 => 'rejected',
            default => 'unknown',
        };
    }

    // Mutator for payment_status
    public function setPaymentStatusAttribute($value)
    {
        $this->attributes['payment_status'] = match (strtolower($value)) {
            'pending' => 0,
            'paid' => 1,
            'failed' => 2,
            default => 0,
        };
    }

    // Mutator for status
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = match (strtolower($value)) {
            'pending' => 0,
            'approved' => 1,
            'rejected' => 2,
            default => 0,
        };
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}