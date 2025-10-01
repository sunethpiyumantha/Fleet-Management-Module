@extends('layouts.app')

@section('title', 'Vehicle Request Management 2')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Optional: table row hover effect */
    #vehicleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Vehicle Request Management</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Request Management
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

    @can('Request Create')
    <!-- Add Vehicle Request Form -->
    <form action="{{ route('vehicle-requests.approvals.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
        @csrf
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 1; min-width: 220px;">
                <label for="request_type" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Request Type</label>
                <select id="request_type" name="request_type" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled {{ old('request_type') ? '' : 'selected' }}>Select Request Type</option>
                    <option value="replacement" {{ old('request_type') == 'replacement' ? 'selected' : '' }}>Vehicle replacement</option>
                    <option value="new_approval" {{ old('request_type') == 'new_approval' ? 'selected' : '' }}>Taking over a vehicle based on a new approval</option>
                </select>
                @error('request_type')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Category</label>
                <select id="cat_id" name="cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled {{ old('cat_id') ? '' : 'selected' }}>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category }} ({{ $category->serial_number }})
                        </option>
                    @endforeach
                </select>
                @error('cat_id')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="sub_cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Sub Category</label>
                <select id="sub_cat_id" name="sub_cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled {{ old('sub_cat_id') ? '' : 'selected' }}>Select Sub-Category</option>
                    @foreach($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}" {{ old('sub_cat_id') == $subCategory->id ? 'selected' : '' }}>
                            {{ $subCategory->sub_category }} ({{ $subCategory->serial_number }})
                        </option>
                    @endforeach
                </select>
                @error('sub_cat_id')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="required_quantity" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Required Quantity</label>
                <input type="number" id="required_quantity" name="qty" min="1" value="{{ old('qty', 1) }}" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                @error('qty')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="initiate_establishment_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Initiate Establishment</label>
                <select id="initiate_establishment_id" name="initiate_establishment_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled {{ old('initiate_establishment_id') ? '' : 'selected' }}>Select Initiate Establishment</option>
                    @foreach($establishments as $establishment)
                        <option value="{{ $establishment->e_id }}" {{ old('initiate_establishment_id') == $establishment->e_id ? 'selected' : '' }}>
                            {{ $establishment->e_name }} ({{ $establishment->abb_name }})
                        </option>
                    @endforeach
                </select>
                @error('initiate_establishment_id')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="current_establishment_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Current Establishment</label>
                <select id="current_establishment_id" name="current_establishment_id"
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" {{ old('current_establishment_id') ? '' : 'selected' }}>Select Current Establishment (Optional)</option>
                    @foreach($establishments as $establishment)
                        <option value="{{ $establishment->e_id }}" {{ old('current_establishment_id') == $establishment->e_id ? 'selected' : '' }}>
                            {{ $establishment->e_name }} ({{ $establishment->abb_name }})
                        </option>
                    @endforeach
                </select>
                @error('current_establishment_id')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="vehicle_book" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Reference letter</label>
                <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.jpg" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                @error('vehicle_book')
                    <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
                <button type="submit"
                        style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    Submit Request
                </button>
            </div>
        </div>
    </form>
    @endcan

    <!-- Search Input (assuming it's here based on controller) -->
    <div style="margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Search requests..." style="padding: 8px; border: 1px solid #90E0EF; border-radius: 5px;">
    </div>

    <!-- Table -->
    <div style="overflow-x: auto;">
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; border: 1px solid #90E0EF;">
            <thead style="background-color: #0077B6; color: white;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">#</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Serial Number</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Request Type</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Category</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Sub Category</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Quantity</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Reference Letter</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Initiated By</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Initiate Establishment</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Current Establishment</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Status</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Date</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($approvals as $index => $approval)
                    <tr style="background-color: white;">
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ ($approvals->currentPage() - 1) * $approvals->perPage() + $index + 1 }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->serial_number }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->request_type_display }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->category_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->sub_category_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->quantity }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">
                            @if($approval->vehicle_letter)
                                <a href="{{ Storage::url($approval->vehicle_letter) }}" target="_blank"
                                   style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none;"
                                   onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                            @else
                                <span style="color: #6b7280; font-size: 0.75rem;">No file</span>
                            @endif
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->user->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->initiate_establishment_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->current_establishment_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{!! $approval->status_badge !!}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->created_at->format('Y-m-d') }}</td>
                        
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; justify-items: center; max-width: 400px; margin: 0 auto;">
                                @can('Request Edit (own)', $approval)
                                    @if($approval->user_id == Auth::id() && $approval->status == 'pending')
                                        <a href="{{ route('vehicle-requests.approvals.edit', $approval->id) }}"
                                           style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none; text-align: center;"
                                           onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Update</a>
                                    @endif
                                @endcan

                                @can('Request Delete (own, before approval)', $approval)
                                    @if($approval->user_id == Auth::id() && $approval->status == 'pending')
                                        <form action="{{ route('vehicle-requests.approvals.destroy', $approval->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this request?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 3px; border: none; width: 100%; text-align: center;"
                                                    onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
                                        </form>
                                    @endif
                                @endcan

                                @can('Forward Request', $approval)
                                    @if($approval->user_id == Auth::id() && $approval->status == 'pending')
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#forwardModal{{ $approval->id }}"
                                           style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none; text-align: center;"
                                           onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Forward</a>
                                    @endif
                                @endcan

                                @can('Reject Request')
                                    <a href=""
                                       style="background-color: #f12800; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none; text-align: center;"
                                       onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#f12800'">Reject</a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr style="background-color:white; color:#03045E;">
                        <td colspan="13" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No vehicle requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Forward Modals -->
    @foreach($approvals as $approval)
        @can('Forward Request', $approval)
            @if($approval->user_id == Auth::id() && $approval->status == 'pending')
                <div class="modal fade" id="forwardModal{{ $approval->id }}" tabindex="-1" aria-labelledby="forwardModalLabel{{ $approval->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #0077B6; color: white;">
                                <h5 class="modal-title" id="forwardModalLabel{{ $approval->id }}">Forward Request: {{ $approval->serial_number }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="forwardForm{{ $approval->id }}" action="{{ route('vehicle-requests.approvals.forward', $approval->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="reason{{ $approval->id }}" class="form-label">Forward Reason</label>
                                        <textarea class="form-control" id="reason{{ $approval->id }}" name="reason" rows="4" placeholder="Enter the reason for forwarding this request..." required></textarea>
                                        @error('reason', 'forward.' . $approval->id)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Forward Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
    @endforeach

    <!-- Pagination -->
    <div id="pagination" style="margin-top: 15px; text-align: center;">
        {{ $approvals->links() }}
    </div>

</div>

<script>
    // Client-side search and pagination script (unchanged, but note: server-side pagination is primary)
    const rowsPerPage = 5;
    let currentPage = 1;
    let sortAsc = true;
    let sortColumn = 1;
    let tableRows = Array.from(document.querySelectorAll("#vehicleTable tbody tr:not(:last-child)")); // Exclude empty row

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            row.cells[1].innerText.toLowerCase().includes(search) ||
            row.cells[2].innerText.toLowerCase().includes(search) ||
            row.cells[3].innerText.toLowerCase().includes(search) ||
            row.cells[4].innerText.toLowerCase().includes(search) ||
            row.cells[5].innerText.toLowerCase().includes(search) ||
            row.cells[7].innerText.toLowerCase().includes(search) ||
            row.cells[8].innerText.toLowerCase().includes(search) ||
            row.cells[9].innerText.toLowerCase().includes(search) ||
            row.cells[10].innerText.toLowerCase().includes(search)
        );

        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        const tbody = document.getElementById("tableBody");
        let html = '';
        paginated.forEach((row, index) => {
            let clone = row.cloneNode(true);
            clone.cells[0].innerText = start + index + 1;
            html += clone.outerHTML;
        });
        tbody.innerHTML = html || '<tr><td colspan="13" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No results</td></tr>';

        renderPagination(filtered.length);
    }

    function renderPagination(totalRows) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const container = document.getElementById("pagination");
        let html = '';
        for (let i = 1; i <= totalPages; i++) {
            html += `<button onclick="currentPage=${i}; renderTable();" style="margin: 0 4px; padding: 5px 10px; background: ${i === currentPage ? '#023E8A' : '#00B4D8'}; color: white; border: none; border-radius: 3px; cursor: pointer;" onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='${i === currentPage ? '#023E8A' : '#00B4D8'}'">${i}</button>`;
        }
        container.innerHTML = html;
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

    // Initial render
    renderTable();
</script>

<style>
    .badge {
        padding: 0.25em 0.5em;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .bg-warning {
        background-color: #f59e0b !important;
    }

    .bg-success {
        background-color: #10b981 !important;
    }

    .bg-danger {
        background-color: #ef4444 !important;
    }

    .bg-info {
        background-color: #0dcaf0 !important;
    }

    .bg-secondary {
        background-color: #6b7280 !important;
    }

    .text-dark {
        color: #000000 !important;
    }
</style>
@endsection