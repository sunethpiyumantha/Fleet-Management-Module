@extends('layouts.app')

@section('title', 'Vehicle Request Management 2')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    #vehicleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
    .highlighted-row {
        background-color: #e3f2fd !important;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Vehicle Request Management</span>
        </nav>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Request Management
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

    @can('Request Create')
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
                            {{ $category->category }}
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
                            {{ $subCategory->sub_category }}
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

    <form method="GET" action="{{ route('vehicle-requests.approvals.index') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search requests by serial, type, category, sub-category, status, or establishment..."
               value="{{ request('search') }}"
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <div style="overflow-x: auto;">
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; border: 1px solid #90E0EF;">
            <thead style="background-color: #0077B6; color: white;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Req ID (Auto gen.)</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(1)">Type ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(2)">Cat ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(3)">Sub-Cat ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(4)">Qty ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(5)">Reference Letter ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(6)">Initiate Est. ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(7)">Initiate User ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(8)">Current User ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(9)">Current Est. ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(10)">Status ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(11)">Date ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($approvals as $approval)
                    @php
                        $userRole = Auth::user()->role->name ?? '';
                        $isHighlighted = ($userRole === 'Establishment Head' && $approval->forwarded_by == Auth::id());
                    @endphp
                    <tr @if($isHighlighted) class="highlighted-row" @endif>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->serial_number }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->request_type_display }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->category_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->sub_category_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->quantity }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">
                            @if($approval->vehicle_letter)
                                <a href="{{ asset('storage/' . $approval->vehicle_letter) }}" target="_blank" style="color: #0077B6; text-decoration: none;">View</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->initiate_establishment_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->initiated_user_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->current_user_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->current_establishment_name }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{!! $approval->status_badge !!}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->created_at->format('Y-m-d H:i') }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">
                            <div style="display: flex; flex-direction: column; gap: 3px;">
                                @if(Auth::user()->role->name === 'Fleet Operator' && in_array($approval->status, ['pending', 'rejected']))
                                    @can('Request Edit (own)')
                                        <a href="{{ route('vehicle-requests.approvals.edit', $approval->id) }}"
                                           style="background-color: #48CAE4; color: white; padding: 3px 6px; border-radius: 3px; text-decoration: none; text-align: center; font-size: 0.75rem;"
                                           onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">Update</a>
                                    @endcan
                                    
                                    @can('Request Delete (own, before approval)')
                                        @if($approval->status == 'pending')
                                            <form action="{{ route('vehicle-requests.approvals.destroy', $approval->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this request?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        style="background-color: #dc2626; color: white; padding: 3px 6px; border-radius: 3px; border: none; width: 100%; text-align: center; cursor: pointer; font-size: 0.75rem;"
                                                        onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
                                            </form>
                                        @endif
                                    @endcan
                                @endif

                                @if(($userRole === 'Fleet Operator' && in_array($approval->status, ['pending', 'rejected', 'sent'])) || 
                                    ($userRole === 'Establishment Head' && in_array($approval->status, ['forwarded', 'sent'])) || 
                                    ($userRole === 'Request Handler' && in_array($approval->status, ['forwarded', 'sent'])) || 
                                    ($userRole === 'Establishment Admin' && in_array($approval->status, ['forwarded', 'sent'])))
                                    @can('Forward Request')
                                        <a href="{{ route('forward', ['req_id' => $approval->serial_number]) }}"
                                           style="background-color: #0077B6; color: white; padding: 3px 6px; border-radius: 3px; text-decoration: none; text-align: center; font-size: 0.75rem;"
                                           onmouseover="this.style.backgroundColor='#005A87'" onmouseout="this.style.backgroundColor='#0077B6'">
                                            Forward
                                        </a>
                                    @endcan
                                @endif

                                @if(($userRole === 'Establishment Head' && in_array($approval->status, ['forwarded', 'sent'])) || 
                                    ($userRole === 'Request Handler' && in_array($approval->status, ['forwarded', 'sent'])) || 
                                    ($userRole === 'Establishment Admin' && in_array($approval->status, ['forwarded', 'sent'])))
                                    @can('Reject Request')
                                        <a href="{{ route('vehicle-requests.approvals.reject-form', $approval->id) }}"
                                           style="background-color: #f12800; color: white; padding: 3px 6px; border-radius: 3px; text-decoration: none; text-align: center; font-size: 0.75rem;"
                                           onmouseover="this.style.backgroundColor='#c21000'" onmouseout="this.style.backgroundColor='#f12800'">Reject</a>
                                    @endcan
                                @endif

                                <a href="{{ route('vehicle-requests.approvals.show', $approval->id) }}"
                                   style="background-color: #0077B6; color: white; padding: 3px 6px; border-radius: 3px; text-decoration: none; text-align: center; font-size: 0.75rem;"
                                   onmouseover="this.style.backgroundColor='#005A87'" onmouseout="this.style.backgroundColor='#0077B6'">
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="pagination" style="margin-top: 15px; text-align: center;"></div>

</div>

<script>
    const rowsPerPage = 5;
    let currentPage = 1;
    let sortAsc = true;
    let sortColumn = 1;
    let tableRows = Array.from(document.querySelectorAll("#vehicleTable tbody tr"));

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            row.cells[1].innerText.toLowerCase().includes(search) ||
            row.cells[2].innerText.toLowerCase().includes(search) ||
            row.cells[3].innerText.toLowerCase().includes(search) ||
            row.cells[4].innerText.toLowerCase().includes(search) ||
            row.cells[5].innerText.toLowerCase().includes(search) ||
            row.cells[6].innerText.toLowerCase().includes(search) ||
            row.cells[7].innerText.toLowerCase().includes(search) ||
            row.cells[8].innerText.toLowerCase().includes(search) ||
            row.cells[9].innerText.toLowerCase().includes(search) ||
            row.cells[10].innerText.toLowerCase().includes(search) ||
            row.cells[11].innerText.toLowerCase().includes(search)
        );

        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        const tbody = document.getElementById("tableBody");
        tbody.innerHTML = '';
        if (paginated.length === 0) {
            const emptyRow = document.createElement('tr');
            emptyRow.style.backgroundColor = 'white';
            emptyRow.innerHTML = '<td colspan="13" style="border: 1px solid #90E0EF; padding: 8px; text-align: center; color: #03045E;">No results</td>';
            tbody.appendChild(emptyRow);
        } else {
            paginated.forEach((row, index) => {
                let clone = row.cloneNode(true);
                clone.cells[0].innerText = start + index + 1;
                tbody.appendChild(clone);
            });
        }

        renderPagination(filtered.length);
    }

    function renderPagination(totalRows) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const container = document.getElementById("pagination");
        container.innerHTML = '';

        const visiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(visiblePages / 2));
        let endPage = Math.min(totalPages, startPage + visiblePages - 1);

        if (endPage - startPage + 1 < visiblePages) {
            startPage = Math.max(1, endPage - visiblePages + 1);
        }

        if (currentPage > 1) {
            const prevBtn = document.createElement("button");
            prevBtn.textContent = "Previous";
            prevBtn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
            prevBtn.onmouseover = () => prevBtn.style.backgroundColor = '#0096C7';
            prevBtn.onmouseout = () => prevBtn.style.backgroundColor = '#00B4D8';
            prevBtn.addEventListener("click", () => {
                currentPage--;
                renderTable();
            });
            container.appendChild(prevBtn);
        }

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
            if (i === currentPage) {
                btn.style.backgroundColor = "#023E8A";
            }
            btn.onmouseover = () => btn.style.backgroundColor = '#0096C7';
            btn.onmouseout = () => btn.style.backgroundColor = (i === currentPage ? '#023E8A' : '#00B4D8');
            btn.addEventListener("click", () => {
                currentPage = i;
                renderTable();
            });
            container.appendChild(btn);
        }

        if (currentPage < totalPages) {
            const nextBtn = document.createElement("button");
            nextBtn.textContent = "Next";
            nextBtn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
            nextBtn.onmouseover = () => nextBtn.style.backgroundColor = '#0096C7';
            nextBtn.onmouseout = () => nextBtn.style.backgroundColor = '#00B4D8';
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
            const textA = a.cells[colIndex].innerText.toLowerCase();
            const textB = b.cells[colIndex].innerText.toLowerCase();
            return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textA);
        });
        renderTable();
    }

    renderTable();
</script>
@endsection