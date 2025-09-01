@extends('layouts.app')
@section('title', 'User Role Management')
@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">User Role Management</h2>

        <!-- Display Success or Error Messages -->
        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('roles.store') }}" method="POST" class="mb-8" style="margin-bottom: 2rem;">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
                <div style="width: 100%; max-width: 75%;">
                    <label for="userRole" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter User Role</label>
                    <input type="text" id="userRole" name="role" required
                        style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;"
                        value="{{ old('role') }}">
                </div>
                <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
                    <button type="submit"
                        style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Add
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Bar -->
        <form action="{{ route('roles.index') }}" method="GET" style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
            <input type="text" name="search" id="searchInput" placeholder="Search User Role..."
                style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;"
                value="{{ request('search') }}">
            <button type="submit"
                style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.4rem 0.8rem; cursor: pointer; font-size: 0.875rem;">
                🔍
            </button>
        </form>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table id="roleTable"
                style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <thead style="background-color: #f97316; color: white; cursor: pointer;">
                    <tr>
                        <th style="padding: 0.75rem;" onclick="sortTable(0)">User Role ▲▼</th>
                        <th style="padding: 0.75rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <!-- Inside the table body -->
                <tbody id="tableBody">
                    @if (isset($roles) && $roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                    {{ $role->name }}
                                    @if ($role->deleted_at)
                                        <span style="color: #dc2626; font-size: 0.75rem;"> (Deleted)</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                                    @if ($role->deleted_at)
                                        <form action="{{ route('roles.restore', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="background-color: #22c55e; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">Restore</button>
                                        </form>
                                    @else
                                        <!-- Update -->
                                        <form action="{{ route('roles.update', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $role->name }}" style="padding: 0.25rem; border-radius: 0.25rem; border: 1px solid #ccc; margin-right: 0.5rem;">
                                            <button type="submit" style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">Update</button>
                                        </form>
                                        <!-- Delete -->
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this User Role?')" style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" style="padding: 0.75rem; text-align: center;">No roles found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" style="margin-top: 1rem; text-align: center;">
            @if ($roles->hasPages())
                {{ $roles->appends(['search' => request('search')])->links('pagination::tailwind') }}
            @endif
        </div>
    </div>
</div>

<script>
    function sortTable(colIndex) {
        const tbody = document.querySelector('#roleTable tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isDeletedColumn = colIndex === 0; // Adjust if sorting by another column

        rows.sort((a, b) => {
            const aText = a.cells[colIndex].innerText.replace(/ \(Deleted\)/, '').toLowerCase();
            const bText = b.cells[colIndex].innerText.replace(/ \(Deleted\)/, '').toLowerCase();
            return aText.localeCompare(bText);
        });

        if (!isDeletedColumn) {
            rows.reverse(); // Toggle sort direction for non-deleted column
        }

        rows.forEach(row => tbody.appendChild(row));
    }
</script>
@endsection