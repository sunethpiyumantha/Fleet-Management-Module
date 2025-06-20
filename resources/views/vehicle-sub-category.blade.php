@extends('layouts.app')

@section('title', 'Vehicle Sub Category Management')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Sub Category Management</h2>

        <!-- Display Success or Error Messages -->
        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Sub Category Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" action="{{ route('vehicle-sub-category.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
                <!-- Category Dropdown -->
                <div style="width: 100%; max-width: 25%;">
                    <label for="vehicleCategory" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                    <select id="vehicleCategory" name="cat_id" required
                            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: #374151; font-size: 0.875rem; outline: none; box-sizing: border-box; {{ $errors->has('cat_id') ? 'border-color: #b91c1c;' : '' }}">
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
                <div style="width: 100%; max-width: 50%;">
                    <label for="vehicleSubCategory" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter Sub Category</label>
                    <input type="text" id="vehicleSubCategory" name="sub_category" required value="{{ old('sub_category') }}"
                           style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box; {{ $errors->has('sub_category') || $errors->has('error') ? 'border-color: #b91c1c;' : '' }}">
                    @error('sub_category')
                        <span style="color: #b91c1c; font-size: 0.75rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Add Button -->
                <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
                    <button type="submit" aria-label="Add vehicle subcategory"
                            style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Add
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('vehicle-sub-category.index') }}" style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
            <input type="text" name="search" id="searchInput" placeholder="Search Vehicle Sub Category..." value="{{ request('search') }}"
                   style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;">
            <button type="submit"
                    style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.4rem 0.8rem; cursor: pointer; font-size: 0.875rem;"
                    aria-label="Search sub-categories">
                🔍
            </button>
        </form>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table id="vehicleSubCategoryTable" style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <thead style="background-color: #f97316; color: white; cursor: pointer;">
                    <tr>
                        <th style="padding: 0.75rem;" onclick="sortTable(0)">Vehicle Category ▲▼</th>
                        <th style="padding: 0.75rem;" onclick="sortTable(1)">Sub Category ▲▼</th>
                        <th style="padding: 0.75rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($subCategories as $subCategory)
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $subCategory->category }}</td>
                            <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $subCategory->sub_category }}</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                                <!-- Update Form -->
                                <form action="{{ route('vehicle-sub-category.update', $subCategory->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="sub_category" value="{{ old('sub_category', $subCategory->sub_category) }}"
                                           style="padding: 0.25rem; border-radius: 0.25rem; border: 1px solid #d1d5db; width: 120px; font-size: 0.875rem; {{ $errors->has('sub_category') ? 'border-color: #b91c1c;' : '' }}">
                                    <select id="vehicleCategory_{{ $subCategory->id }}" name="cat_id" required
                                            style="border-radius: 0.25rem; border: 1px solid #d1d5db; padding: 0.25rem 0.5rem; color: #374151; width: 100px; font-size: 0.875rem; {{ $errors->has('cat_id') ? 'border-color: #b91c1c;' : '' }}">
                                        <option value="" disabled>Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ old('cat_id', $subCategory->cat_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" aria-label="Update vehicle subcategory"
                                            style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">Update</button>
                                </form>
                                <!-- Delete Form -->
                                <form action="{{ route('vehicle-sub-category.destroy', $subCategory->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this Vehicle Sub Category?')"
                                            style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;"
                                            aria-label="Delete vehicle subcategory">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" style="margin-top: 1rem; text-align: center;"></div>
    </div>
</div>

<script>
    const rowsPerPage = 5;
    let currentPage = 1;
    let sortAsc = true;
    let sortColumn = 0;
    let tableRows = Array.from(document.querySelectorAll("#vehicleSubCategoryTable tbody tr"));

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            row.cells[0].innerText.toLowerCase().includes(search) ||
            row.cells[1].innerText.toLowerCase().includes(search)
        );

        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        const tbody = document.getElementById("tableBody");
        tbody.innerHTML = "";
        paginated.forEach(row => tbody.appendChild(row.cloneNode(true)));

        renderPagination(filtered.length);
    }

    function renderPagination(totalRows) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const container = document.getElementById("pagination");
        container.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.style = "margin: 0 0.25rem; padding: 0.25rem 0.75rem; background: #f97316; color: white; border: none; border-radius: 0.375rem; cursor: pointer;";
            if (i === currentPage) {
                btn.style.backgroundColor = "#ea580c";
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
            return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textB);
        });
        renderTable();
    }

    // Initial Render
    renderTable();
</script>
@endsection