@extends('layouts.app')

@section('title', 'User Edit')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">User Edit</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Edit User
        </h5>
    </div>

    <!-- Success Message -->
    @if (session('success'))
            <div style="background-color: #adf4c9; color: #006519; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
        </div>
    @endif

    <!-- Error / Delete Messages -->
    @if (session('error'))
        <div style="background-color: #f8d7da; color: #842029; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
            <div style="background-color: #f8d7da; color: #842029; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                {{ $error }}
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit User Form (only visible if user has 'User Edit' permission) -->
    @can('User Edit')
    <form action="{{ route('users.update', $user->id) }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        @method('PUT')
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 1; min-width: 220px;">
                <label for="name" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter Name" required value="{{ old('name', $user->name) }}"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="username" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required value="{{ old('username', $user->username) }}"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="password" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" placeholder="Enter Password"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="password_confirmation" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Confirm Password (leave blank if not changing)</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="user_role" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">User Role</label>
                <select id="user_role" name="user_role" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled>Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('user_role', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="establishment_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Establishment</label>
                <select id="establishment_id" name="establishment_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled>Select Establishment</option>
                    @foreach ($establishments as $establishment)
                        <option value="{{ $establishment->e_id }}" {{ old('establishment_id', $user->establishment_id) == $establishment->e_id ? 'selected' : '' }}>{{ $establishment->e_name }} ({{ $establishment->abb_name }})</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit"
                        style="flex: 1; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer; text-align: center;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    Update
                </button>
                <a href="{{ route('users.index') }}"
                   style="flex: 1; background-color: #0096C7; color: white; font-weight: 600; padding: 10px; border-radius: 5px; text-decoration: none; text-align: center; cursor: pointer; display: block;"
                   onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">
                    Back
                </a>
            </div>
        </div>
    </form>
    @endcan

</div>

<script>
    // Client-side confirmation check for password
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const pass = document.getElementById('password').value;
        const confirm = this.value;
        if (pass !== confirm && confirm) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endsection