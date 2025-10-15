<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $table = 'colleges';

    protected $fillable = [
        'name',
        'is_funded',
        'amount',
        'date',
        'status',
    ];

    protected $casts = [
        'is_funded' => 'boolean',
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
