```blade
@extends('layouts.app')

@section('title', 'All Drivers')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Optional: table row hover effect */
    #driverTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">All Drivers</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Drivers
        </h5>
    </div>

    <!-- Search Form -->
    <form style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" placeholder="Search by Reg No or NIC..."
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- Drivers Table -->
    <div style="overflow-x: auto;">
        <table id="driverTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px; width: 50px;">#</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Reg No / NIC</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Name</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Rank</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Unit</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">Code No</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">License No</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">License Issued</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">License Expired</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color:white; color:#03045E;">
                    <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">1</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">123456</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">John Doe</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">Captain</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">Alpha Unit</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">C123</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">LN789</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">2023-01-01</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px;">2026-01-01</td>
                    <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                        <p style="font-size: 0.8rem; color: #6b7280; margin-bottom: 0.5rem;">Driver ID: 1</p>
                        <a href="/driver-amendment" style="background-color: #48CAE4; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none;"
                           onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#48CAE4'">
                            Driver Amendment 
                        </a>
                        <!--<a href="#" style="background-color: #16a34a; color: white; padding: 5px 10px; border-radius: 3px; text-decoration: none; margin-right: 5px;"
                           onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">Update</a>
                        <button style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 3px; border: none;"
                                onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>-->
                    </td>
                </tr>
                <!-- Placeholder for empty state -->
                <tr style="background-color:white; color:#03045E;">
                    <td colspan="10" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No drivers found.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 15px; text-align: center;">
        <a href="#" style="color: #0077B6; margin: 0 4px; padding: 5px 10px; text-decoration: none;"
           onmouseover="this.style.color='#0096C7'" onmouseout="this.style.color='#0077B6'">Previous</a>
        <a href="#" style="color: #0077B6; margin: 0 4px; padding: 5px 10px; text-decoration: none;"
           onmouseover="this.style.color='#0096C7'" onmouseout="this.style.color='#0077B6'">Next</a>
    </div>
</div>
@endsection
```