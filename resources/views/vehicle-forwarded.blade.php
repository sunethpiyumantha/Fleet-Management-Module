@extends('layouts.app')

@section('title', 'Vehicle Forwarded')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    #vehicleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
    .highlighted-row {
        background-color: #e3f2fd !important; /* Light blue for forwarded */
    }
    .search-form {
        margin-bottom: 15px;
    }
    .search-form input {
        padding: 8px;
        border: 1px solid #90E0EF;
        border-radius: 4px;
    }
    .search-form button {
        padding: 8px 15px;
        background-color: #0077B6;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .action-btn {
        padding: 4px 8px;
        background-color: #0077B6;
        color: white;
        border: none;
        border-radius: 3px;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        cursor: pointer;
    }
    .action-btn:hover {
        background-color: #023E8A;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Forwarded Vehicles</span>
        </nav>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Forwarded Vehicle Requests
        </h5>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('vehicle-forwarded.index') }}" class="search-form">
        <input type="text" name="search" placeholder="Search by serial, type, category, etc..." value="{{ request('search') }}">
        <button type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('vehicle-forwarded.index') }}" style="margin-left: 10px; color: #0077B6;">Clear</a>
        @endif
    </form>

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
            @forelse($approvals as $approval)
                <tr class="highlighted-row">
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->serial_number }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ ucfirst(str_replace('_', ' ', $approval->request_type)) }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->category->category ?? 'N/A' }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->subCategory->sub_category ?? 'N/A' }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->quantity }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">
                        @if($approval->vehicle_letter)
                            <a href="{{ Storage::url($approval->vehicle_letter) }}" target="_blank">View</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->initiateEstablishment->e_name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->initiator->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->currentUser->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->currentEstablishment->e_name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ ucfirst($approval->status) }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $approval->created_at->format('Y-m-d H:i') }}</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">
                        <a href="{{ route('vehicle-requests.approvals.show', $approval->id) }}" class="action-btn">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" style="border: 1px solid #90E0EF; padding: 20px; text-align: center; color: #666;">No forwarded requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("vehicleTable");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</div>
@endsection