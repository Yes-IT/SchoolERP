<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePanelPermission extends Model
{
    use HasFactory;

    protected $table = 'role_panel_permissions';

    protected $fillable = [
        'role_id',
        'panel_id',
        'module_id',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}
