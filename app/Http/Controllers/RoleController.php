<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        Log::info('RoleController::index called');
        $search = $request->query('search');
        $query = Role::withTrashed(); // Include soft-deleted roles

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $roles = $query->orderBy('name')->paginate(10);

        return view('user-roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|max:255|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Role::create(['name' => $request->role]);

        return redirect()->back()->with('success', 'Role added successfully!');
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
}