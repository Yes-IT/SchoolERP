<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'applicant';
    protected $fillable = [
        'custom_id',
        'last_name',
        'first_name',
        'high_school',
        'date_of_birth',
        'usa_cell',
        'email',
        'highschool(application)',
    ];
}
