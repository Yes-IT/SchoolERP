<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearStatus extends Model
{
    use HasFactory;

    protected $table= 'year_status';

    protected $fillable = [
        'name',
    ];
}
