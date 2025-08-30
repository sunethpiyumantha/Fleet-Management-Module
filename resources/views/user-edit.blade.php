@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Edit User</h2>

        <!-- Display Success or Error Messages -->
        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: block;">
                {{ session('success') }}
            </div>
        @else
            <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: none;">
                <!-- Placeholder for success message -->
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: block;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: none;">
                <ul style="margin: 0; padding-left: 1rem;">
                    <!-- Placeholder for error messages -->
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="mb-8" style="margin-bottom: 2rem;">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <!-- First Line: Name and Username -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Name</label>
                        <input type="text" id="name" name="name" required value="{{ old('name', $user->name) }}"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="username" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Username</label>
                        <input type="text" id="username" name="username" required value="{{ old('username', $user->username) }}"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                </div>

                <!-- Second Line: Password and User Role -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="password" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Password (leave blank to keep current)</label>
                        <input type="password" id="password" name="password" style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="user_role" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">User Role</label>
                        <select id="user_role" name="user_role" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('user_role', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Third Line: Submit Button -->
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #16a34a; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                        <i class="fa-solid fa-save" style="margin-right: 0.25rem;"></i> Save Changes
                    </button>
                    <a href="{{ route('users.index') }}"
                       style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; text-decoration: none; margin-left: 1rem; cursor: pointer;"
                       onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-arrow-left" style="margin-right: 0.25rem;"></i> Back
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection