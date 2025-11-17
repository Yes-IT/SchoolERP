<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeroomClass extends Model
{
    use HasFactory;

    protected $table = 'homeroom_class';
    protected $fillable = [
        'name'
    ];
}
