@extends('layouts.app')

@section('title', 'All Requests')

@section('content')
<!-- Main container -->
<div style="max-width: 80rem; margin: 0 auto; padding: 2rem 1rem; font-family: Arial, sans-serif;">
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); border: 2px solid #f97316; border-radius: 1.5rem; box-shadow: 0 12px 20px -5px rgba(0,0,0,0.15), 0 6px 8px -4px rgba(0,0,0,0.1); padding: 1.5rem;">
        <h2 style="font-size: 2rem; font-weight: 700; color: #ea580c; text-align: center; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 1px;">
            All Vehicle Inspection
        </h2>

        <!-- Search Form -->
        <form id="searchForm" style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: flex-start;">
            <input type="text" id="searchInput" placeholder="Search by serial or category..." style="padding: 0.5rem; width: 100%; max-width: 300px; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.9rem;">
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-size: 0.9rem; font-weight: 600; transition: background 0.3s ease, transform 0.2s ease;"
                    onmouseover="this.style.background='#2563eb'; this.style.transform='scale(1.05)'"
                    onmouseout="this.style.background='#3b82f6'; this.style.transform='scale(1)'">
                Search
            </button>
        </form>

        <!-- Vehicle Requests Table -->
        <div style="overflow-x: auto;">
            <table id="vehicleTable" style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; background-color: white;">
                <thead style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white;">
                    <tr>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem; text-align: left;">Serial Number</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem; text-align: left;">Request Type</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem; text-align: left;">Vehicle Category</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem; text-align: left;">Sub Category</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem; text-align: left;">Quantity</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Sample Data -->
                    <tr style="transition: background-color 0.3s ease, transform 0.2s ease; animation: slideIn 0.3s ease forwards;">
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">SN12345</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">Vehicle Replacement</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">Truck</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">Heavy Duty</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">2</td>
                        <td style="padding: 1rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                            <p style="font-size: 0.8rem; color: #4b5563; margin-bottom: 0.5rem;">Vehicle ID: 1</p>
                            <a href="#" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease, transform 0.2s ease; text-decoration: none;"
                               onmouseover="this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'"
                               onmouseout="this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'">
                                Vehicle Inspection
                            </a>
                        </td>
                    </tr>
                    <!-- Empty State -->
                    <!-- <tr>
                        <td colspan="6" style="padding: 1rem; text-align: center; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">
                            No vehicle requests found.
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
            <a href="#" style="background: #e5e7eb; color: #374151; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.9rem; transition: background 0.3s ease, transform 0.2s ease;"
               onmouseover="this.style.background='#d1d5db'; this.style.transform='scale(1.05)'"
               onmouseout="this.style.background='#e5e7eb'; this.style.transform='scale(1)'">
                Previous
            </a>
            <a href="#" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.9rem; transition: background 0.3s ease, transform 0.2s ease;"
               onmouseover="this.style.background='#2563eb'; this.style.transform='scale(1.05)'"
               onmouseout="this.style.background='#3b82f6'; this.style.transform='scale(1)'">
                1
            </a>
            <a href="#" style="background: #e5e7eb; color: #374151; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.9rem; transition: background 0.3s ease, transform 0.2s ease;"
               onmouseover="this.style.background='#d1d5db'; this.style.transform='scale(1.05)'"
               onmouseout="this.style.background='#e5e7eb'; this.style.transform='scale(1)'">
                2
            </a>
            <a href="#" style="background: #e5e7eb; color: #374151; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.9rem; transition: background 0.3s ease, transform 0.2s ease;"
               onmouseover="this.style.background='#d1d5db'; this.style.transform='scale(1.05)'"
               onmouseout="this.style.background='#e5e7eb'; this.style.transform='scale(1)'">
                Next
            </a>
        </div>
    </div>
</div>

<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Staggered animation for table rows
    const tableRows = document.querySelectorAll('#vehicleTable tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
    });

    // Client-side search filter
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.getElementsByTagName('tr');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        Array.from(rows).forEach(row => {
            const serial = row.cells[0].textContent.toLowerCase();
            const category = row.cells[2].textContent.toLowerCase();
            if (serial.includes(searchTerm) || category.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection