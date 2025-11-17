<?php

namespace App\Repositories;

use App\Interfaces\RolePanelPermissionInterface;
use App\Models\RolePanelPermission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RolePanelPermissionRepository implements RolePanelPermissionInterface
{
    public function storePermissions(int $roleId, array $permissions): bool
    {
        $moduleIds = array_keys($permissions);

        $modulePanels = DB::table('modules')
            ->whereIn('id', $moduleIds)
            ->pluck('panel_id', 'id');

        DB::transaction(function () use ($roleId, $permissions, $modulePanels) {
            RolePanelPermission::where('role_id', $roleId)->delete();
            $insertData = [];

            foreach ($permissions as $moduleId => $perm) {
                $ordered = [
                    'read'   => $perm['read']   ?? '',
                    'create' => $perm['create'] ?? '',
                    'update' => $perm['update'] ?? '',
                    'delete' => $perm['delete'] ?? '',
                ];

                $insertData[] = [
                    'role_id'    => $roleId,
                    'panel_id'   => $modulePanels[$moduleId] ?? null,
                    'module_id'  => $moduleId,
                    'permissions'=> json_encode($ordered),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            RolePanelPermission::insert($insertData);

            $flatPermissions = collect($permissions)
                ->map(fn($p) => array_values(array_filter($p)))
                ->flatten()
                ->unique()
                ->values()
                ->toArray();

            Role::find($roleId)->update([
                'permissions' => $flatPermissions
            ]);
        });

        return true;
    }
}