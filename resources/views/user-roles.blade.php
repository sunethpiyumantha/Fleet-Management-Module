@extends('layouts.app')

@section('title', 'User Role Management')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Optional: table row hover effect */
    #roleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">User Role</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            User Role
        </h5>
    </div>

    <!-- Success or Error Messages -->
    @if (session('success'))
        <div style="background-color: #ADE8F4; color: #023E8A; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="background-color: #caf0f8; color: #03045E; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
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

    <!-- Add User Role Form -->
    <form action="{{ route('roles.store') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 3; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Enter User Role</label>
                <input type="text" id="userRole" name="role" value="{{ old('role') }}" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
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

    <!-- Permissions Section -->
    <div style="margin-bottom: 20px;">
        <h5 style="color: #023E8A; font-weight: bold; margin-bottom: 10px;">Permissions</h5>
        <div style="display: flex; gap: 20px;">
            <div>
                <h6 style="color: #023E8A; font-weight: bold;">User Management</h6>
                <label><input type="checkbox" name="permissions[]" value="Role Create"> Role Create</label><br>
                <label><input type="checkbox" name="permissions[]" value="Role List"> Role List</label><br>
                <label><input type="checkbox" name="permissions[]" value="User Edit"> User Edit</label><br>
                <label><input type="checkbox" name="permissions[]" value="Logindetail List"> Logindetail List</label><br>
                <label><input type="checkbox" name="permissions[]" value="Role Delete"> Role Delete</label><br>
                <label><input type="checkbox" name="permissions[]" value="User Create"> User Create</label><br>
                <label><input type="checkbox" name="permissions[]" value="User List"> User List</label><br>
            </div>
            <div>
                <h6 style="color: #023E8A; font-weight: bold;">Requests</h6>
                <label><input type="checkbox" name="permissions[]" value="Request Create"> Request Create</label><br>
                <label><input type="checkbox" name="permissions[]" value="Request Edit (own)"> Request Edit </label><br>
                <label><input type="checkbox" name="permissions[]" value="Request List (all / own)"> Request List </label><br>
                <label><input type="checkbox" name="permissions[]" value="Request Delete (own, before approval)"> Request Delete </label><br>
                <label><input type="checkbox" name="permissions[]" value="Approve Request"> Approve Request</label><br>
                <label><input type="checkbox" name="permissions[]" value="Reject Request"> Reject Request</label><br>
                <label><input type="checkbox" name="permissions[]" value="Forward Request"> Forward Request</label><br>
                <label><input type="checkbox" name="permissions[]" value="Add Forward Reason"> Add Forward Reason</label><br>
            </div>
            <div>
                <h6 style="color: #023E8A; font-weight: bold;">Establishment Management</h6>
                <label><input type="checkbox" name="permissions[]" value="Establishment Create"> Establishment Create</label><br>
                <label><input type="checkbox" name="permissions[]" value="Establishment Edit"> Establishment Edit</label><br>
                <label><input type="checkbox" name="permissions[]" value="Establishment Delete"> Establishment Delete</label><br>
                <label><input type="checkbox" name="permissions[]" value="Establishment List"> Establishment List</label><br>
            </div>
            <div>
                <h6 style="color: #023E8A; font-weight: bold;">System</h6>
                <label><input type="checkbox" name="permissions[]" value="Manage Notifications"> Manage Notifications</label><br>
            </div>
        </div>
        <button type="submit" style="background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer; margin-top: 10px;"
                onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">Save Permissions</button>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('roles.index') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search User Role..."
               value="{{ request('search') }}"
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- User Roles Table -->
    <div style="overflow-x: auto;">
        <table id="roleTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px; width: 50px;">#</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(1)">User Role ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @if (isset($roles) && $roles->isNotEmpty())
                    @foreach ($roles as $index => $role)
                        <tr style="background-color:white; color:#03045E;">
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #90E0EF; padding: 8px;">
                                {{ $role->name }}
                                @if ($role->deleted_at)
                                    <span style="color: #dc2626; font-size: 0.75rem;"> (Deleted)</span>
                                @endif
                            </td>
                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                                @if ($role->deleted_at)
                                    <form action="{{ route('roles.restore', $role->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; border: none;"
                                                onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Restore</button>
                                    </form>
                                @else
                                    <!-- Update -->
                                    <form action="{{ route('roles.update', $role->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $role->name }}" style="padding: 5px; border-radius: 3px; border: 1px solid #90E0EF; color:#03045E;">
                                        <button type="submit" style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; border: none;"
                                                onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Update</button>
                                    </form>
                                    <!-- Delete -->
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this User Role?')" style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 3px; border: none; margin-left: 5px;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="background-color:white; color:#03045E;">
                        <td colspan="3" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No roles found.</td>
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
    let tableRows = Array.from(document.querySelectorAll("#roleTable tbody tr"));

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            row.cells[1].innerText.replace(/ \(Deleted\)/, '').toLowerCase().includes(search)
        );

        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        const tbody = document.getElementById("tableBody");
        tbody.innerHTML = "";
        paginated.forEach((row, index) => {
            let clone = row.cloneNode(true);
            clone.cells[0].innerText = start + index + 1; // Update numbering
            tbody.appendChild(clone);
        });

        renderPagination(filtered.length);
    }

    function renderPagination(totalRows) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const container = document.getElementById("pagination");
        container.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
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
    }

    document.getElementById("searchInput").addEventListener("input", () => {
        currentPage = 1;
        renderTable();
    });

    function sortTable(colIndex) {
        sortAsc = !sortAsc;
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