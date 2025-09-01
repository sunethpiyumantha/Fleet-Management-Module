<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        Log::info('UserController::index called at ' . date('Y-m-d H:i:s'), ['search' => $request->query('search')]);

        // Get the search term from the query string
        $search = $request->query('search');

        // Query users, excluding soft-deleted ones, and apply search if provided
        $users = User::with('role')
            ->whereNull('deleted_at') // Only include non-deleted users
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::whereNull('deleted_at')->orderBy('name')->get();

        return view('user-creation', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'user_role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->user_role;
        $user->save();

        return redirect()->back()->with('success', 'User created successfully at ' . date('Y-m-d H:i:s'));
    }

    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $roles = Role::whereNull('deleted_at')->orderBy('name')->get();
        return view('user-edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6',
            'user_role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::withTrashed()->findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role_id = $request->user_role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully at ' . date('Y-m-d H:i:s'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User soft deleted successfully at ' . date('Y-m-d H:i:s'));
    }
}