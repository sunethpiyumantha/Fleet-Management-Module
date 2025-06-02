@extends('layouts.app')

@section('title', 'Vehicle Type Management')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">

    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Type Management</h2>

    @if(session('success'))
      <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div style="background-color: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
        <ul style="list-style-type: disc; padding-left: 1.25rem;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Form -->
    <form action="{{ route('vehicle-type.store') }}" method="POST" class="mb-8" style="margin-bottom: 2rem;">
      @csrf
      <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
        <div style="width: 100%; max-width: 75%;">
          <label for="vehicle_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter Vehicle Type</label>
          <input 
            type="text" 
            id="vehicle_type" 
            name="vehicle_type" 
            value="{{ old('vehicle_type') }}" 
            required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
        </div>
        <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
          <button 
            type="submit"
            style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
            onmouseover="this.style.backgroundColor='#ea580c'" 
            onmouseout="this.style.backgroundColor='#f97316'">
            <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Add
          </button>
        </div>
      </div>
    </form>

    <!-- Search Bar -->
    <div style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
      <input 
        type="text" 
        id="searchInput" 
        placeholder="Search Vehicle Type..."
        style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;">
      <button 
        type="button"
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
            <th style="padding: 0.75rem;" onclick="sortTable(0)">Vehicle Type &#x25B2;&#x25BC;</th>
            <th style="padding: 0.75rem; text-align: center;">Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($vehicleTypes as $type)
            <tr>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $type->vehicle_type }}</td>
              <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6; white-space: nowrap;">

                <!-- Update Form -->
                <form action="{{ route('vehicle-type.update', $type->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('PUT')
                  <input type="text" name="vehicle_type" value="{{ $type->vehicle_type }}" required 
                    style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.25rem 0.5rem; font-size: 0.875rem; width: 8rem;">
                  <button 
                    type="submit" 
                    style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem; cursor: pointer;">
                    Update
                  </button>
                </form>

                <!-- Delete -->
                <form action="{{ route('vehicle-type.destroy', $type->id) }}" method="POST" style="display: inline; margin-left: 0.5rem;">
                  @csrf
                  @method('DELETE')
                  <button 
                    type="submit" 
                    onclick="return confirm('Delete this type?')"
                    style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; cursor: pointer;">
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
    <div id="pagination" style="margin-top: 1rem; text-align: center;">
      {{ $vehicleTypes->links() }}
    </div>

  </div>
</div>

<script>
  // Client-side sorting and search for enhanced UX, but server-side pagination remains (Laravel pagination)
  const rowsPerPage = 1000; // effectively show all since Laravel paginates
  let currentPage = 1;
  let sortAsc = true;
  let tableRows = Array.from(document.querySelectorAll("#vehicleTable tbody tr"));

  function renderTable() {
    const search = document.getElementById("searchInput").value.toLowerCase();
    const filtered = tableRows.filter(row =>
      row.cells[0].innerText.toLowerCase().includes(search)
    );

    const tbody = document.getElementById("tableBody");
    tbody.innerHTML = "";
    filtered.forEach(row => tbody.appendChild(row.cloneNode(true)));
  }

  document.getElementById("searchInput").addEventListener("input", () => {
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

  renderTable();
</script>
@endsection
