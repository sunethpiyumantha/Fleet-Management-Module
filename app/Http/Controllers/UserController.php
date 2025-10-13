<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Added for optional error logging

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('User List');
        $search = $request->query('search');
        $query = User::with(['role.permissions', 'establishment'])->withTrashed(); // Eager-load permissions

        $query->when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('username', 'LIKE', "%{$search}%")
              ->orWhereHas('role', function ($q) use ($search) {
                  $q->where('name', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('establishment', function ($q) use ($search) {
                  $q->where('e_name', 'LIKE', "%{$search}%");
              });
        });

        $users = $query->orderBy('name')->get();
        $roles = Role::all();
        $establishments = Establishment::all();

        return view('user-creation', compact('users', 'roles', 'establishments'));
    }

    public function store(Request $request)
    {
        $this->authorize('User Create');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'user_role' => 'required|exists:roles,id',
            'establishment_id' => 'required|exists:establishments,e_id',
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
                'establishment_id' => $request->establishment_id,
            ]);

            return redirect()->back()->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage()); // Optional logging
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $this->authorize('User List'); // Or a specific 'User View' permission if added
        $user = User::with(['role.permissions', 'establishment'])->withTrashed()->findOrFail($id);
        return view('user-show', compact('user')); // Assuming a show view
    }

    public function edit($id)
    {
        $this->authorize('User Edit');
        $user = User::with(['role.permissions', 'establishment'])->withTrashed()->findOrFail($id); // Eager-load permissions
        $roles = Role::all();
        $establishments = Establishment::all();
        return view('user-edit', compact('user', 'roles', 'establishments'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('User Edit');
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'user_role' => 'required|exists:roles,id',
            'establishment_id' => 'required|exists:establishments,e_id',
        ];

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
                'establishment_id' => $request->establishment_id,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage()); // Optional logging
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
            Log::error('User deletion failed: ' . $e->getMessage()); // Optional logging
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
            Log::error('User restore failed: ' . $e->getMessage()); // Optional logging
            return redirect()->back()->with('error', 'Failed to restore user: ' . $e->getMessage());
        }
    }
}