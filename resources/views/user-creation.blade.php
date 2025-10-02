@extends('layouts.app')

@section('title', 'User Creation')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Optional: table row hover effect */
    #userTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">User Creation</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            User Creation
        </h5>
    </div>

    <!-- Success or Error Messages -->
    @if (session('success'))
        <div style="background-color: #ADE8F4; color: #023E8A; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #caf0f8; color: #03045E; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add User Form (only visible if user has 'User Create' permission) -->
    @can('User Create')
    <form action="{{ route('users.store') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 1; min-width: 220px;">
                <label for="name" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter Name" required value="{{ old('name') }}"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="username" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required value="{{ old('username') }}"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="password" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="password_confirmation" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="user_role" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">User Role</label>
                <select id="user_role" name="user_role" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('user_role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="establishment_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Establishment</label>
                <select id="establishment_id" name="establishment_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Establishment</option>
                    @foreach ($establishments as $establishment)
                        <option value="{{ $establishment->e_id }}" {{ old('establishment_id') == $establishment->e_id ? 'selected' : '' }}>{{ $establishment->e_name }} ({{ $establishment->abb_name }})</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
                <button type="submit"
                        style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    + Add
                </button>
            </div>
        </div>
    </form>
    @endcan

    <!-- Search Bar (for client-side filtering) -->
    <form method="GET" action="{{ route('users.index') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search by Name, Username, Role, or Establishment..."
               value="{{ request('search') }}"
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- User Table -->
    <div style="overflow-x: auto; margin-top: 20px;">
        <table id="userTable" style="width: 100%; border-collapse: collapse; font-size: 14px; background-color: white;">
            <thead>
                <tr style="background-color: #48CAE4; color: white; font-weight: bold;">
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">Sl No</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: left; cursor: pointer;" onclick="sortTable(1)">Name ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: left; cursor: pointer;" onclick="sortTable(2)">Username ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: left; cursor: pointer;" onclick="sortTable(3)">User Role ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: left; cursor: pointer;" onclick="sortTable(4)">Establishment ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @if ($users->count() > 0)
                    @foreach ($users as $index => $user)
                        <tr style="background-color:white; color:#03045E;">
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">
                                {{ $user->name }}
                                @if($user->deleted_at) <span style="color: #dc2626;">(Deleted)</span> @endif
                            </td>
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">
                                {{ $user->username }}
                                @if($user->deleted_at) <span style="color: #dc2626;">(Deleted)</span> @endif
                            </td>
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">
                                {{ $user->role ? $user->role->name : 'N/A' }}
                                @if($user->deleted_at) <span style="color: #dc2626;">(Deleted)</span> @endif
                            </td>
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">
                                {{ $user->establishment ? $user->establishment->e_name . ' (' . $user->establishment->abb_name . ')' : 'N/A' }}
                                @if($user->deleted_at) <span style="color: #dc2626;">(Deleted)</span> @endif
                            </td>
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: left;">
                                <!-- Edit (only if 'User Edit' permission) -->
                                @can('User Edit')
                                <a href="{{ route('users.edit', $user->id) }}" style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none; margin-right: 5px;"
                                   onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Edit</a>
                                @endcan
                                <!-- Delete (only if 'User Delete' permission) -->
                                @can('User Delete')
                                @if (!$user->deleted_at)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Soft delete this user?')"
                                            style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 3px; border: none; margin-left: 5px;"
                                            onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
                                </form>
                                @endif
                                @endcan
                                <!-- Restore (only if 'User Delete' permission and user is deleted) -->
                                @can('User Delete')
                                @if ($user->deleted_at)
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                style="background-color: #00B4D8; color: white; padding: 5px 10px; border-radius: 3px; border: none; margin-left: 5px;"
                                                onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">Restore</button>
                                    </form>
                                @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="background-color:white; color:#03045E;">
                        <td colspan="6" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No users found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" style="margin-top: 15px; text-align: center;"></div>
</div>

<!-- Table Sorting + Pagination -->
<script>
    const rowsPerPage = 5;
    let currentPage = 1;
    let sortAsc = true;
    let sortColumn = 1;
    let tableRows = Array.from(document.querySelectorAll("#userTable tbody tr"));

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            row.cells[1].innerText.toLowerCase().includes(search) ||
            row.cells[2].innerText.toLowerCase().includes(search) ||
            row.cells[3].innerText.toLowerCase().includes(search) ||
            row.cells[4].innerText.toLowerCase().includes(search)
        );

        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        const tbody = document.getElementById("tableBody");
        tbody.innerHTML = "";
        paginated.forEach((row, index) => {
            let clone = row.cloneNode(true);
            clone.cells[0].innerText = start + index + 1;
            tbody.appendChild(clone);
        });

        renderPagination(filtered.length);
    }

    function renderPagination(totalRows) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const container = document.getElementById("pagination");
        container.innerHTML = "";

        // Define the number of visible pages (e.g., 5)
        const visiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(visiblePages / 2));
        let endPage = Math.min(totalPages, startPage + visiblePages - 1);

        // Adjust startPage if endPage is near the total
        if (endPage - startPage + 1 < visiblePages) {
            startPage = Math.max(1, endPage - visiblePages + 1);
        }

        // Previous Button
        if (currentPage > 1) {
            const prevBtn = document.createElement("button");
            prevBtn.textContent = "Previous";
            prevBtn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
            prevBtn.addEventListener("click", () => {
                currentPage--;
                renderTable();
            });
            container.appendChild(prevBtn);
        }

        // Page Numbers
        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
            if (i === currentPage) {
                btn.style.backgroundColor = "#023E8A";
            }
            btn.addEventListener("click", () => {
                currentPage = i;
                renderTable();
            });
            container.appendChild(btn);
        }

        // Next Button
        if (currentPage < totalPages) {
            const nextBtn = document.createElement("button");
            nextBtn.textContent = "Next";
            nextBtn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
            nextBtn.addEventListener("click", () => {
                currentPage++;
                renderTable();
            });
            container.appendChild(nextBtn);
        }
    }

    document.getElementById("searchInput").addEventListener("input", () => {
        currentPage = 1;
        renderTable();
    });

    function sortTable(colIndex) {
        sortAsc = colIndex === sortColumn ? !sortAsc : true;
        sortColumn = colIndex;
        tableRows.sort((a, b) => {
            const textA = a.cells[colIndex].innerText.replace(/ \(Deleted\)/, '').toLowerCase();
            const textB = b.cells[colIndex].innerText.replace(/ \(Deleted\)/, '').toLowerCase();
            return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textA);
        });
        renderTable();
    }

    // Initial Render
    renderTable();
</script>
@endsection