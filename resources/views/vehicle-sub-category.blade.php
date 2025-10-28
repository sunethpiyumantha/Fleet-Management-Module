@extends('layouts.app')

@section('title', 'Vehicle Sub Category Management')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Optional: table row hover effect */
    #vehicleSubCategoryTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Vehicle Sub Category</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Sub Category
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

    <!-- Sub Category Form -->
    <form action="{{ route('vehicle-sub-category.store') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <!-- Category Dropdown -->
            <div style="flex: 1; min-width: 220px;">
                <label for="vehicleCategory" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Category</label>
                <select id="vehicleCategory" name="cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E; font-size: 0.875rem; outline: none; {{ $errors->has('cat_id') ? 'border-color: #b91c1c;' : '' }}">
                    <option value="" disabled {{ old('cat_id') ? '' : 'selected' }}>Select</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
                @error('cat_id')
                    <span style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Sub Category Input -->
            <div style="flex: 2; min-width: 220px;">
                <label for="vehicleSubCategory" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Enter Sub Category</label>
                <input type="text" id="vehicleSubCategory" name="sub_category" value="{{ old('sub_category') }}" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E; {{ $errors->has('sub_category') || $errors->has('error') ? 'border-color: #b91c1c;' : '' }}">
                @error('sub_category')
                    <span style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Add Button -->
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
                <button type="submit" aria-label="Add vehicle subcategory"
                        style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    + Add
                </button>
            </div>
        </div>
    </form>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('vehicle-sub-category.index') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search Vehicle Sub Category..."
               value="{{ request('search') }}"
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'"
                aria-label="Search sub-categories">🔍</button>
    </form>

    <!-- Table -->
    <div style="overflow-x: auto;">
        <table id="vehicleSubCategoryTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px; width: 50px;">#</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(1)">Vehicle Category ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(2)">Sub Category ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($subCategories as $index => $subCategory)
                    <tr style="background-color:white; color:#03045E;">
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $subCategory->category }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $subCategory->sub_category }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                            <!-- Update Form -->
                            <form action="{{ route('vehicle-sub-category.update', $subCategory->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <select id="vehicleCategory_{{ $subCategory->id }}" name="cat_id" required
                                        style="padding: 5px; border-radius: 3px; border: 1px solid #90E0EF; color:#03045E; font-size: 0.875rem; {{ $errors->has('cat_id') ? 'border-color: #b91c1c;' : '' }}">
                                    <option value="" disabled>Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ old('cat_id', $subCategory->cat_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->category }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="sub_category" value="{{ old('sub_category', $subCategory->sub_category) }}"
                                       style="padding: 5px; border-radius: 3px; border: 1px solid #90E0EF; color:#03045E; width: 120px; font-size: 0.875rem; {{ $errors->has('sub_category') ? 'border-color: #b91c1c;' : '' }}">
                                <button type="submit" aria-label="Update vehicle subcategory"
                                        style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; border: none;"
                                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Update</button>
                            </form>
                            <!-- Delete Form -->
                            <form action="{{ route('vehicle-sub-category.destroy', $subCategory->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this Vehicle Sub Category?')"
                                        style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 3px; border: none; margin-left: 5px;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'"
                                        aria-label="Delete vehicle subcategory">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
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
    let tableRows = Array.from(document.querySelectorAll("#vehicleSubCategoryTable tbody tr"));

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            row.cells[1].innerText.toLowerCase().includes(search) ||
            row.cells[2].innerText.toLowerCase().includes(search)
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
        sortAsc = colIndex === sortColumn ? !sortAsc : true;
        sortColumn = colIndex;
        tableRows.sort((a, b) => {
            const textA = a.cells[colIndex].innerText.toLowerCase();
            const textB = b.cells[colIndex].innerText.toLowerCase();
            return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textA);
        });
        renderTable();
    }

    // Initial Render
    renderTable();
</script>
@endsection