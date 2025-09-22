@extends('layouts.app')

@section('title', 'Vehicle Request Management')

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
            <span style="font-weight: bold; color:#023E8A;">Vehicle Requests</span>
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

    <!-- Add Vehicle Request Form -->
    <form action="" method="POST" style="margin-bottom: 20px;" enctype="multipart/form-data">
        @csrf
        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <div style="flex: 1; min-width: 220px;">
                <label for="request_type" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Request Type</label>
                <select id="request_type" name="request_type" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Request Type</option>
                    <option value="replacement">Vehicle replacement</option>
                    <option value="new_approval">Taking over a vehicle based on a new approval</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Category</label>
                <select id="cat_id" name="cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Category</option>
                    
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="sub_cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Sub Category</label>
                <select id="sub_cat_id" name="sub_cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Sub-Category</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="required_quantity" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Required Quantity</label>
                <input type="number" id="required_quantity" name="qty" min="1" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="vehicle_book" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Letter</label>
                <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
                <button type="submit"
                        style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    + Submit
                </button>
            </div>
        </div>
    </form>

    <!-- Search Bar -->
    <form method="GET" action="" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search by Serial Number, Request Type, Category, Sub-Category, or Status..."
               value="{{ request('search') }}"
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- Vehicle Requests Table -->
    <div style="overflow-x: auto;">
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">#</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(1)">Serial Number ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(2)">Request Type ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(3)">Vehicle Category ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(4)">Sub Category ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(5)">Quantity ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(6)">Status ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Vehicle Letter</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr>
                    <td colspan="9" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No vehicle requests found.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" style="margin-top: 15px; text-align: center;"></div>
</div>

<!-- File Modal -->
<div id="fileModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
    <div style="background: white; padding: 24px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow: auto;">
        <h3 id="modalTitle" style="font-size: 20px; font-weight: bold; margin-bottom: 16px;">Vehicle File</h3>
        <div id="fileContainer" style="display: flex; flex-wrap: wrap; gap: 16px;"></div>
        <button onclick="closeFileModal()"
                style="margin-top: 16px; background-color: #00B4D8; color: white; padding: 8px 16px; border-radius: 5px; border: none; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
            Close
        </button>
    </div>
</div>

<!-- JS -->
<script>
    const rowsPerPage = 5;
    let currentPage = 1;
    let sortAsc = true;
    let sortColumn = 1; // default: Serial Number
    let tableRows = Array.from(document.querySelectorAll("#vehicleTable tbody tr"));

    function renderTable() {
        const search = document.getElementById("searchInput").value.toLowerCase();
        const filtered = tableRows.filter(row =>
            Array.from(row.cells).some(cell => cell.innerText.toLowerCase().includes(search))
        );

        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filtered.slice(start, start + rowsPerPage);

        const tbody = document.getElementById("tableBody");
        tbody.innerHTML = "";
        paginated.forEach((row, index) => {
            let clone = row.cloneNode(true);
            clone.cells[0].innerText = start + index + 1; // Number column
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

    function showFileModal(fileUrl) {
        const modal = document.getElementById("fileModal");
        const fileContainer = document.getElementById("fileContainer");
        fileContainer.innerHTML = "";
        
        const extension = fileUrl.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png'].includes(extension)) {
            const img = document.createElement("img");
            img.src = fileUrl;
            img.style = "max-width: 200px; max-height: 200px; border-radius: 4px;";
            fileContainer.appendChild(img);
        } else if (['pdf', 'doc', 'docx'].includes(extension)) {
            const link = document.createElement("a");
            link.href = fileUrl;
            link.textContent = "Download Vehicle Letter";
            link.style = "font-size: 14px; color: #0077B6; text-decoration: underline;";
            link.setAttribute("download", "");
            fileContainer.appendChild(link);
        }
        
        modal.style.display = "flex";
    }

    function closeFileModal() {
        document.getElementById("fileModal").style.display = "none";
    }

    // Initial Render
    renderTable();
</script>
@endsection
