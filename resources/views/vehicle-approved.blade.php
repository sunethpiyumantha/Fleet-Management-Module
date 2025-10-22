@extends('layouts.app')

@section('title', 'Vehicle Approved')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    #vehicleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Approved Vehicle </span>
        </nav>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Approved Vehicle 
        </h5>
    </div>

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

    <form method="GET" action="{{ route('vehicle-approved.index') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search approved requests by serial, type, category, sub-category, or establishment..."
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
                    <tr>
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