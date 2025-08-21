@extends('layouts.app')

@section('title', 'All Drivers')

@section('content')
<!-- Main container -->
<div style="max-width: 80rem; margin: 0 auto; padding: 2.5rem 1.5rem; font-family: Arial, sans-serif;">
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); border: 2px solid #f97316; border-radius: 1.5rem; box-shadow: 0 12px 20px -5px rgba(0,0,0,0.15), 0 6px 8px -4px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 2rem; font-weight: 700; color: #ea580c; text-align: center; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 1px;">
            Drivers
        </h2>

        <!-- Search Form -->
        <form style="margin-bottom: 1rem;">
            <input type="text" placeholder="Search by Reg No or NIC..." style="padding: 0.5rem; width: 300px;">
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none;">Search</button>
        </form>

        <!-- Drivers Table -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; background-color: white;">
                <thead style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white;">
                    <tr>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">Reg No / NIC</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">Name</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">Rank</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">Unit</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">Code No</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">License No</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">License Issued</th>
                        <th style="padding: 1rem; font-weight: 600; font-size: 0.9rem;">License Expired</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; font-size: 0.9rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="transition: background-color 0.3s ease, transform 0.2s ease; animation: slideIn 0.3s ease forwards;">
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">123456</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">John Doe</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">Captain</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">Alpha Unit</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">C123</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">LN789</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">2023-01-01</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">2026-01-01</td>
                        <td style="padding: 1rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                            <p style="font-size: 0.8rem; color: #4b5563; margin-bottom: 0.5rem;">Driver ID: 1</p>
                            <a href="/driver-amendment" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease, transform 0.2s ease; text-decoration: none;"
                               onmouseover="this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'"
                               onmouseout="this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'">
                                Driver Amendment 
                            </a>
                            <!--<a href="#" style="background: linear-gradient(90deg, #16a34a 0%, #15803d 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease, transform 0.2s ease; margin-left: 0.5rem; text-decoration: none;"
                               onmouseover="this.style.background='linear-gradient(90deg, #15803d 0%, #166534 100%)'; this.style.transform='scale(1.05)'"
                               onmouseout="this.style.background='linear-gradient(90deg, #16a34a 0%, #15803d 100%)'; this.style.transform='scale(1)'">
                                Update
                            </a>
                            <button style="background: linear-gradient(90deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-size: 0.85rem; font-weight: 600; margin-left: 0.5rem; transition: all 0.3s ease, transform 0.2s ease;"
                                    onmouseover="this.style.background='linear-gradient(90deg, #b91c1c 0%, #991b1b 100%)'; this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.background='linear-gradient(90deg, #dc2626 0%, #b91c1c 100%)'; this.style.transform='scale(1)'">
                                Delete
                            </button>-->
                        </td>
                    </tr>
                    <!-- Placeholder for empty state -->
                    <tr>
                        <td colspan="9" style="padding: 1rem; text-align: center; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; color: #374151;">
                            No drivers found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div style="margin-top: 1rem;">
            <a href="#" style="color: #3b82f6; margin: 0 0.5rem;">Previous</a>
            <a href="#" style="color: #3b82f6; margin: 0 0.5rem;">Next</a>
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
@endsection