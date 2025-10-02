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
        $this->authorize('User List'); // Ensure permission to view user list
        $search = $request->query('search');
        $query = User::with(['role'])->withTrashed();

        $query->when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('username', 'LIKE', "%{$search}%")
              ->orWhereHas('role', function ($q) use ($search) {
                  $q->where('name', 'LIKE', "%{$search}%");
              });
        });

        $users = $query->orderBy('name')->get(); // Changed from paginate(5) to get() for unlimited results
        $roles = Role::all();

        return view('user-creation', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('User Create');
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

        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => $request->user_role,
            ]);

            return redirect()->back()->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $this->authorize('User Edit');
        $user = User::withTrashed()->findOrFail($id);
        $roles = Role::all();
        return view('user-edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('User Edit');
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'user_role' => 'required|exists:roles,id',
        ];

        // Add password validation only if provided
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules, [
            'password.confirmed' => 'The password field confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::withTrashed()->findOrFail($id);
            $updateData = [
                'name' => $request->name,
                'username' => $request->username,
                'role_id' => $request->user_role,
            ];

            // Update password only if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $this->authorize('User Delete');
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'User soft deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $this->authorize('User Delete');
        try {
            $user = User::withTrashed()->findOrFail($id);
            if ($user->deleted_at) {
                $user->restore();
                return redirect()->back()->with('success', 'User restored successfully!');
            }
            return redirect()->back()->with('error', 'User is not deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore user: ' . $e->getMessage());
        }
    }
}