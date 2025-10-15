<?php

namespace App\Models;

use App\Models\Academic\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedClass extends Model
{
    use HasFactory;

    protected $table = 'recorded_classes';

    protected $fillable = [
        'title',
        'author',
        'speaker',
        'class_id',
        'date',
        'filename',
        'coded_name',
        'path',
        'type',
        'size',
    ];

    /**
     * Relation: RecordedClass belongs to a Class
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
