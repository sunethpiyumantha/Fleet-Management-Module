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
        <ul style="margin: 0; padding-left: 1rem;">
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
        <div style="width: 100%; max-width: 30%;">
          <label for="vehicleCategory" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
          <select id="vehicleCategory" name="category" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: #374151;">
            @foreach (['Army Vehicle', 'Hired Vehicle', 'Medical Van', 'Police Jeep'] as $category)
              <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
          </select>
        </div>

        <!-- Sub Category Input -->
        <div style="width: 100%; max-width: 45%;">
          <label for="vehicleSubCategory" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter Sub Category</label>
          <input type="text" id="vehicleSubCategory" name="sub_category" required value="{{ old('sub_category') }}"
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem;">
        </div>

        <!-- Add Button -->
        <div style="width: 100%; max-width: 25%; margin-top: 1.8rem;" class="md:mt-0">
          <button type="submit"
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
        style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.4rem 0.8rem; cursor: pointer; font-size: 0.875rem;">
        🔍
      </button>
    </form>

    <!-- Table -->
    <div style="overflow-x: auto;">
      <table id="subCategoryTable"
        style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
        <thead style="background-color: #f97316; color: white; cursor: pointer;">
          <tr>
            <th style="padding: 0.75rem;">Vehicle Category</th>
            <th style="padding: 0.75rem;">Sub Category</th>
            <th style="padding: 0.75rem; text-align: center;">Actions</th>
          </tr>
        </thead>
        <tbody id="subCategoryTableBody">
          @forelse ($subCategories as $subCategory)
            <tr>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $subCategory->category }}</td>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $subCategory->sub_category }}</td>
              <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                <!-- Update -->
                <form action="{{ route('vehicle-sub-category.update', $subCategory->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('POST')
                  <input type="text" name="sub_category" value="{{ $subCategory->sub_category }}" style="padding: 0.25rem; border-radius: 0.25rem; border: 1px solid #ccc;">
                  <select name="category" style="padding: 0.25rem; border-radius: 0.25rem; border: 1px solid #ccc;">
                    @foreach (['Army Vehicle', 'Hired Vehicle', 'Medical Van', 'Police Jeep'] as $category)
                      <option value="{{ $category }}" {{ $subCategory->category == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                  </select>
                  <button type="submit" style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">Update</button>
                </form>
                <!-- Delete -->
                <form action="{{ route('vehicle-sub-category.destroy', $subCategory->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Delete this Vehicle Sub Category?')" style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">No sub-categories found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" style="margin-top: 1rem; text-align: center;">
      {{ $subCategories->appends(['search' => request('search')])->links() }}
    </div>
  </div>
</div>

<script>
  // Optional: Add client-side sorting if needed
  let sortAsc = true;

  function sortTable(colIndex) {
    const table = document.getElementById("subCategoryTable");
    const tableBody = document.getElementById("subCategoryTableBody");
    const tableRows = Array.from(tableBody.getElementsByTagName("tr"));
    sortAsc = !sortAsc;

    tableRows.sort((a, b) => {
      const textA = a.cells[colIndex].innerText.toLowerCase();
      const textB = b.cells[colIndex].innerText.toLowerCase();
      return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textA);
    });

    tableBody.innerHTML = "";
    tableRows.forEach(row => tableBody.appendChild(row));
  }
</script>
@endsection