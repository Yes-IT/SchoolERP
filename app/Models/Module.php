<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'attribute', 'slug');
    }

    public function rolePanelPermissions()
    {
        return $this->hasMany(RolePanelPermission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
