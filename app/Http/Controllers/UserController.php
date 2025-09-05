<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware to protect all methods
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        Log::debug('UserController::index called', ['search' => $request->query('search')]);

        $search = $request->query('search');

        $users = User::with('role')
            ->whereNull('deleted_at')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::whereNull('deleted_at')->orderBy('name')->get();

        return view('user-creation', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed', // Enforce stronger password and confirmation
            'user_role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'name' => trim($request->name), // Trim input
                'username' => trim($request->username),
                'password' => bcrypt($request->password),
                'role_id' => $request->user_role,
            ]);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create user', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create user. Please try again.')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $roles = Role::whereNull('deleted_at')->orderBy('name')->get();
            return view('user-edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch user for edit', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8|confirmed', // Allow optional password with confirmation
            'user_role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->name = trim($request->name);
            $user->username = trim($request->username);
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->role_id = $request->user_role;
            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update user', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update user. Please try again.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete user', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete user. Please try again.');
        }
    }
}