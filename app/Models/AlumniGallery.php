<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniGallery extends Model
{
    protected $table = 'alumni_gallery'; // Table name

    protected $fillable = [
        'filename',
        'encoded_name',
        'path',
        'type',
        'size',
        'title',
        'description',
    ];

    protected $casts = [
        'type' => 'string', // Cast type to string
        'size' => 'integer', // Cast size to integer
    ];
}