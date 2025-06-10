@extends('layouts.app')

@section('title', 'Vehicle Request')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Request</h2>

    <!-- Form -->
    <form class="mb-8" style="margin-bottom: 2rem;" method="POST" action="{{ route('vehicle.request.store') }}">
      @csrf
      <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row md:flex-wrap md:justify-center">
        <!-- Vehicle Category Dropdown -->
        <div style="width: 100%; max-width: 25%;">
          <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
          <select id="cat_id" name="cat_id" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
            <option value="" disabled selected>Select Category</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->category }}</option>
            @endforeach
          </select>
        </div>

        <!-- Sub-Vehicle Category Dropdown -->
        <div style="width: 100%; max-width: 25%;">
          <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Sub-Vehicle Category</label>
          <select id="sub_cat_id" name="sub_cat_id" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
            <option value="" disabled selected>Select Sub_Category</option>
          </select>
        </div>

        <!-- Required Quantity Input -->
        <div style="width: 100%; max-width: 25%;">
          <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
          <input type="number" id="required_quantity" name="required_quantity" min="1" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
        </div>

        <!-- Date Submit Input -->
        <div style="width: 100%; max-width: 25%;">
          <label for="date_submit" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Date Submit</label>
          <input type="date" id="date_submit" name="date_submit" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
        </div>

        <!-- Submit Button -->
        <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
          <button type="submit"
            style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
            <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
          </button>
        </div>
      </div>
    </form>

    <!-- Search Bar -->
    <div style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
      <input type="text" id="searchInput" placeholder="Search Vehicle Type..."
        style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;">
      <button type="button"
        style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.4rem 0.8rem; cursor: pointer; font-size: 0.875rem;">
        🔍 
      </button>
    </div>

    <!-- Table -->
    <div style="overflow-x: auto;">
      <table id="vehicleTable"
        style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
        <thead style="background-color: #f97316; color: white; cursor: pointer;">
          <tr>
            <th style="padding: 0.75rem;" onclick="sortTable(0)">Vehicle Type ▲▼</th>
            <th style="padding: 0.75rem; text-align: center;">Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($vehicles as $vehicle)
            <tr>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $vehicle->sub_cat_id }}</td> <!-- Adjust to the field you want to display, e.g., sub_cat_id or a related name -->
              <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                <form action="{{ route('vehicle.edit', $vehicle->id) }}" method="GET" style="display: inline;">
                  @csrf
                  <button type="submit" style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">
                    Update
                  </button>
                </form>
                <form action="{{ route('vehicle.destroy', $vehicle->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">
                    Delete
                  </button>
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
  let tableRows = Array.from(document.querySelectorAll("#vehicleTable tbody tr"));

  // Update sub-vehicle category dropdown based on vehicle category selection
  document.getElementById('cat_id').addEventListener('change', function() {
    const catId = this.value;
    fetch(`/get-sub-categories/${catId}`)
      .then(response => response.json())
      .then(data => {
        const subVehicleSelect = document.getElementById('sub_cat_id');
        subVehicleSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
        data.forEach(subCat => {
          const option = document.createElement('option');
          option.value = subCat.id;
          option.textContent = subCat.name;
          subVehicleSelect.appendChild(option);
        });
      });
  });

  function renderTable() {
    const search = document.getElementById("searchInput").value.toLowerCase();
    const filtered = tableRows.filter(row =>
      row.cells[0].innerText.toLowerCase().includes(search)
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
    sortAsc = !sortAsc;
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