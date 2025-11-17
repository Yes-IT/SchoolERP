<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    use HasFactory;

    protected $guarded = ["id"];

    protected $casts = [
        'permissions' => 'array',
    ];

    //get active all roles
    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function scopeCustomRole($query)
    {
        return $query->where('is_system', false);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function rolePanelPermissions()
    {
        return $this->hasMany(RolePanelPermission::class);
    }

    public function panels()
    {
        return $this->belongsToMany(
            Panel::class,
            'role_panel_permissions',
            'role_id',   // FK in pivot
            'panel_id'   // FK to panels
        )
        ->select('panels.id', 'panels.name')
        ->distinct();
    }

}