<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;

use App\Models\User;

use App\Interfaces\{
    RoleInterface,
    PermissionInterface,
    ModuleInterface,
    PanelInterface,
    RolePanelPermissionInterface,
};

use App\Interfaces\Staff\DesignationInterface;

class RoleController extends Controller
{
    public function __construct(
        RoleInterface $role,
        PermissionInterface $permission,
        PanelInterface $panel,
        ModuleInterface $module,
        DesignationInterface $designation,
        RolePanelPermissionInterface $rolePanelPermission
    ) {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }

        $this->role = $role;
        $this->permission = $permission;
        $this->panel = $panel;
        $this->module = $module;
        $this->designation = $designation;
        $this->rolePanelPermission = $rolePanelPermission;
    }

    public function index()
    {
        $data['roles'] = $this->role->customLatest();
        $data['title'] = ___('common.roles');
        return view('backend.roles.create', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('common.create_role');
        $data['permissions'] = $this->permission->all();
        return view('backend.roles.create', compact('data'));
    }

    public function store(RoleStoreRequest $request)
    {
        $result = $this->role->store($request);
        $msg = $result
            ? ['success', ___('alert.role_created_successfully')]
            : ['danger', ___('alert.something_went_wrong_please_try_again')];

        return redirect()->route('roles.index')->with($msg[0], $msg[1]);
    }

    public function edit($id)
    {
        $data['role'] = $this->role->show($id);
        $data['title'] = ___('common.roles');
        $data['permissions'] = $this->permission->all();
        return view('backend.roles.edit', compact('data'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $result = $this->role->update($request, $id);
        $msg = $result
            ? ['success', ___('alert.role_updated_successfully')]
            : ['danger', ___('alert.something_went_wrong_please_try_again')];

        return redirect()->route('roles.index')->with($msg[0], $msg[1]);
    }

    public function delete($id)
    {
        $success = [];
        if ($this->role->destroy($id)) {
            $success = [___('alert.deleted_successfully'), 'success', ___('alert.deleted'), ___('alert.OK')];
        } else {
            $success = [___('alert.something_went_wrong_please_try_again'), 'error', ___('alert.oops')];
        }
        return response()->json($success);
    }

    public function assignAccess()
    {
        $data['roles'] = $this->role->custom();
        $data['title'] = ___('common.roles');
        $data['panels'] = $this->panel->all();
        $data['modules'] = $this->module->all();
        return view('backend.roles.assign-access', compact('data'));
    }

    public function modulesByPanel(Request $request)
    {
        $panelIds = $request->panel_ids ?? [];

        $modules = $this->module->getByPanels($panelIds);

        // dd($modules->toArray());

        $html = view('backend.roles.partials.assign-module-permissions', compact('modules'))->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    public function storePermission(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'role_id' => 'required|integer',
            'panel_ids' => 'required|array',
            'module_ids' => 'required|array',
            'permissions' => 'required|array',
        ]);

        $this->rolePanelPermission->storePermissions($request->role_id, $request->permissions);

        return response()->json(['message' => 'Permissions saved successfully!']);
    }

    public function assignedRole(Request $request)
    {
        $query = User::select('id', 'name', 'email', 'role_id')
            ->with([
                'role:id,name,is_system',
                'role.panels:id,name'
            ])
            ->whereHas('role', fn ($q) => $q->where('is_system', 0));

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Filter by Role
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        // Filter by Panel
        if ($request->filled('panel_id')) {
            $query->whereHas('role.panels', function ($q) use ($request) {
                $q->where('panels.id', $request->panel_id);
            });
        }

        $data['users']        = $query->get();
        $data['roles']        = $this->role->custom();
        $data['panels']       = $this->panel->all();
        $data['modules']      = $this->module->all();
        $data['designations'] = $this->designation->all();
        $data['title']        = ___('common.roles');

        return view('backend.roles.assigned-roles', compact('data'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'designation_id' => 'required|exists:designations,id',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->token = Str::random(30);
        $user->role_id = $request->role_id;
        $user->designation_id = $request->designation_id;
        $user->uuid = Str::uuid();
        $user->save();

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function showUser($id)
    {
        $user = User::select('id', 'name', 'email', 'role_id', 'designation_id', 'password')
                    ->where('id', $id)
                    ->first();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'User retrieved successfully',
            'data'    => $user,
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found.'
            ], 404);
        }

        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'name'            => 'required|string|max:150',
            'role_id'         => 'required|exists:roles,id',
            'designation_id'  => 'required|exists:designations,id',
        ]);

        $user->name           = $validated['name'];
        $user->role_id        = $validated['role_id'];
        $user->designation_id = $validated['designation_id'];

        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'User updated successfully.',
        ]);
    }

    public function fetchUserPanelsAndPermissions($userId)
    {
        $user = User::with('role')->findOrFail($userId);

        $grouped = $user->role->rolePanelPermissions()
            ->with(['panel:id,name', 'module:id,name,panel_id'])
            ->get()
            ->groupBy('panel_id');

        $html = view('backend.roles.partials.modal-assigned-permissions', compact('grouped'))->render();

        return response()->json(['html' => $html]);
    }

    public function deleteRoleUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($data['user_id']);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found',
            ], 404);
        }

        try {
            $user->delete();

            return response()->json([
                'status'  => true,
                'message' => 'User deleted successfully',
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Unable to delete user, please try again',
            ], 500);
        }
    }

}