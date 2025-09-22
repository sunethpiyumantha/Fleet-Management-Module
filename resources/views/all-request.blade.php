@extends('layouts.app')

@section('title', 'All Requests')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Table row hover effect */
    #vehicleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<!-- Main container -->
<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">All Requests</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            All Requests
        </h5>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('vehicle.request.all') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by serial or category..."
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- Vehicle Requests Table -->
    <div style="overflow-x: auto;">
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px; font-weight: 600;">#</th> <!-- Number column -->
                    <th style="border: 1px solid #90E0EF; padding: 8px; font-weight: 600;">Serial Number</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; font-weight: 600;">Request Type</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; font-weight: 600;">Vehicle Category</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; font-weight: 600;">Sub Category</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; font-weight: 600;">Quantity</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center; font-weight: 600;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($vehicles as $vehicle)
                    <tr style="transition: background-color 0.3s ease;">
                        <td style="border: 1px solid #90E0EF; padding: 8px; color: #03045E;">
                            {{ $loop->iteration }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; color: #03045E;">
                            {{ $vehicle->serial_number ?? $vehicle->id }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; color: #03045E;">
                            {{ $vehicle->request_type === 'replacement' ? 'Vehicle Replacement' : 'New Approval' }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; color: #03045E;">
                            {{ $vehicle->category->category ?? 'N/A' }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; color: #03045E;">
                            {{ $vehicle->subCategory->sub_category ?? 'N/A' }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; color: #03045E;">
                            {{ $vehicle->qty }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                            <p style="font-size: 0.8rem; color: #4b5563; margin-bottom: 0.5rem;">Vehicle ID: {{ $vehicle->id }}</p>
                            <div style="display: flex; justify-content: center; gap: 0.5rem;">
                                <a href="{{ route('vehicle.declaration.create', ['serial_number' => $vehicle->serial_number ?? $vehicle->id, 'request_type' => $vehicle->request_type]) }}"
                                   style="background-color: #00B4D8; color: white; padding: 5px 10px; border-radius: 5px; border: none; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer;"
                                   onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                                    Add
                                </a>
                                <a href="{{ route('vehicle.declaration.edit', ['serial_number' => $vehicle->serial_number ?? $vehicle->id, 'request_type' => $vehicle->request_type]) }}"
                                   style="background-color: #00B4D8; color: white; padding: 5px 10px; border-radius: 5px; border: none; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer;"
                                   onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                                    Update
                                </a>
                                <form action="{{ route('vehicle.request.destroy', $vehicle->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this Vehicle Request, its declarations, and all associated drivers?')"
                                            style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 5px; border: none; font-size: 0.85rem; font-weight: 600; cursor: pointer;"
                                            onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="border: 1px solid #90E0EF; padding: 8px; text-align: center; color: #03045E;">
                            No vehicle requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div style="margin-top: 15px; text-align: center;">
        {{ $vehicles->links('pagination::tailwind') }}
    </div>
</div>
@endsection
