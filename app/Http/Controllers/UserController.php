<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = User::with(['role'])->withTrashed(); // Include soft-deleted users and their roles

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhereHas('role', function ($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $users = $query->orderBy('name')->get(); // Fetch all users
        $roles = Role::all();

        return view('user-creation', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'user_role' => 'required|exists:roles,id',
        ], [
            'password.confirmed' => 'The password field confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->user_role,
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $roles = Role::all();
        return view('user-edit', compact('user', 'roles')); // Assume an edit view exists
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'user_role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::withTrashed()->findOrFail($id);
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role_id' => $request->user_role,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User soft deleted successfully!');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->deleted_at) {
            $user->restore();
            return redirect()->back()->with('success', 'User restored successfully!');
        }
        return redirect()->back()->with('error', 'User is not deleted.');
    }
}