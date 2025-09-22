@extends('layouts.app')
@section('title', 'User Creation')
@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">User Creation</h2>

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
        <form action="{{ route('users.store') }}" method="POST" class="mb-8" style="margin-bottom: 2rem;">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <!-- First Line: Name and Username -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Name</label>
                        <input type="text" id="name" name="name" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;"
                               value="{{ old('name') }}">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="username" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Username</label>
                        <input type="text" id="username" name="username" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;"
                               value="{{ old('username') }}">
                    </div>
                </div>

                <!-- Second Line: Password and Password Confirmation -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="password" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Password</label>
                        <input type="password" id="password" name="password" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="password_confirmation" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                </div>

                <!-- Third Line: User Role -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="user_role" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">User Role</label>
                        <select id="user_role" name="user_role" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Fourth Line: Submit Button -->
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Bar -->
        <form action="{{ route('users.index') }}" method="GET" style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
            <input type="text" name="search" id="searchInput" placeholder="Search Users..."
                   style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;"
                   value="{{ request('search') }}">
            <button type="submit" title="Search Users"
                style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.6rem 1rem; cursor: pointer; font-size: 1rem;">
                🔍
            </button>
        </form>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table id="userTable"
                style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <thead style="background-color: #f97316; color: white; cursor: pointer;">
                    <tr>
                        <th style="padding: 0.75rem;" onclick="sortTable(0)">Name ▲▼</th>
                        <th style="padding: 0.75rem;" onclick="sortTable(1)">Username ▲▼</th>
                        <th style="padding: 0.75rem;" onclick="sortTable(2)">User Role ▲▼</th>
                        <th style="padding: 0.75rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @if (isset($users) && $users->isNotEmpty())
                        @foreach ($users as $user)
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                    {{ $user->name }}
                                    @if ($user->deleted_at)
                                        <span style="color: #dc2626; font-size: 0.75rem;"> (Deleted)</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $user->username }}</td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $user->role->name }}</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                                    <!-- Edit -->
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; text-decoration: none; margin-right: 0.5rem;">
                                        Edit
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Soft delete this user?')" style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">Delete</button>
                                    </form>
                                    @if ($user->deleted_at)
                                        <!-- Restore -->
                                        <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="background-color: #22c55e; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">Restore</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="padding: 0.75rem; text-align: center;">No users found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let sortAsc = true;
    let sortColumn = -1;

    function sortTable(colIndex) {
        const tbody = document.querySelector('#userTable tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        sortAsc = (colIndex === sortColumn) ? !sortAsc : true;
        sortColumn = colIndex;

        rows.sort((a, b) => {
            const aText = a.cells[colIndex].innerText.replace(/ \(Deleted\)/, '').toLowerCase();
            const bText = b.cells[colIndex].innerText.replace(/ \(Deleted\)/, '').toLowerCase();
            return sortAsc ? aText.localeCompare(bText) : bText.localeCompare(aText);
        });

        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        // Search is handled server-side via form submission
    });
</script>
@endsection