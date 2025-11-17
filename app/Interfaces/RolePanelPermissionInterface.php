<?php

namespace App\Interfaces;

interface RolePanelPermissionInterface
{
    public function storePermissions(int $roleId, array $permissions): bool;
}