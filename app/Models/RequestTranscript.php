<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTranscript extends Model
{
    use HasFactory;
    protected $table = 'request_transcript'; 

    protected $fillable = [
        'student_id',
        'request_date',
        'destination',
        'type',
    ];
}
