<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    use HasFactory;

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
