<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        Log::info('RoleController::index called');
        $search = $request->query('search');
        $query = Role::with('permissions')->withTrashed();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $roles = $query->orderBy('name')->get();

        return view('user-roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create(['name' => $request->role]);

        if ($request->has('permissions')) {
            $permissionIds = Permission::whereIn('name', $request->permissions)->pluck('id');
            $role->permissions()->attach($permissionIds);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::withTrashed()->findOrFail($id);
        $role->update(['name' => $request->name]);

        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('success', 'Role soft deleted successfully!');
    }

    public function restore($id)
    {
        $role = Role::withTrashed()->findOrFail($id);
        if ($role->deleted_at) {
            $role->restore();
            return redirect()->back()->with('success', 'Role restored successfully!');
        }
        return redirect()->back()->with('error', 'Role is not deleted.');
    }

    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $permissionIds = Permission::whereIn('name', $request->permissions ?? [])->pluck('id');
        $role->permissions()->sync($permissionIds);

        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
    }

    public function getPermissions($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role->permissions->pluck('name')->toArray());
    }
}