<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function create()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view(
            'crm_emanager.backend.role&permission.create',
            compact('roles', 'permissions')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'required|exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role);

        $permissions = Permission::whereIn(
            'id',
            $request->input('permissions', [])
        )->get();

        // Add new permissions without removing existing permissions
        $role->givePermissionTo($permissions);

        return redirect()->back()->with(
            'success',
            'Permissions Assigned Successfully'
        );
    }
}
