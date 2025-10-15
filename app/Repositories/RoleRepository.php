<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Str;
use App\Interfaces\RoleInterface;

class RoleRepository implements RoleInterface
{

    private $model;

    public function __construct(Role $roleModel)
    {
        $this->model = $roleModel;
    }

    public function student_parent_roles()
    {
        return $this->model->active()->whereIn('id', [6,7])->get();
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getAll()
    {
        return Role::latest()->paginate(10);
    }

    public function store($request)
    {
        try {
            $roleStore              = new $this->model;
            $roleStore->name        = $request->name;
            $roleStore->slug        = Str::slug($request->name);
            $roleStore->status      = $request->status;
            $roleStore->permissions = $request->permissions;
            $roleStore->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {
            if($id == 1)
                return false;

            $roleUpdate              = $this->model->findOrfail($id);
            $roleUpdate->name        = $request->name;
            $roleUpdate->status      = $request->status;
            $roleUpdate->permissions = $request->permissions;
            $roleUpdate->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            if($id <= 7)
                return false;

            $roleDestroy = $this->model->find($id);
            $roleDestroy->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
