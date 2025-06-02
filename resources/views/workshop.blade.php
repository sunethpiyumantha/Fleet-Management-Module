@extends('layouts.app')

@section('title', 'Workshop Management')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Workshp Management</h2>

    <!-- Form -->
    <form class="mb-8" style="margin-bottom: 2rem;">
      <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
        <div style="width: 100%; max-width: 75%;">
          <label for="vehicleType" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter Workshop Type</label>
          <input type="text" id="vehicleType" name="vehicle_type" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
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
    <div style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
      <input type="text" id="searchInput" placeholder="Search Workshop..."
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
            <th  style="padding: 0.75rem;" onclick="sortTable(0)">Workshop &#x25B2;&#x25BC;</th>
            <th style="padding: 0.75rem; text-align: center;">Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach (['Base work shop', 'Field work shop'] as $vehicle)
            <tr>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $vehicle }}</td>
              <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                <button style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">
                  Update
                </button>
                <button style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">
                  Delete
                </button>
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
