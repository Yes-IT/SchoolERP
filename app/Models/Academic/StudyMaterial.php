<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;

    protected $table = 'study_materials';



    protected $fillable = [
        'subject',
        'book_name',
        'publisher',
        'author',
        'rental_price',
        'status',
        'resource_link',
    ];
}
