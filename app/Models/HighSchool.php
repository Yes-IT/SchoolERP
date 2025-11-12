<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HighSchool extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table="high_schools";
    protected $fillable = [
        'name',
    ];
}
