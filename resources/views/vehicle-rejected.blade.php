@extends('layouts.app')

@section('title', 'Vehicle Rejected')

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
            <span style="font-weight: bold; color:#023E8A;">Rejected Vehicle </span>
        </nav>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Rejected Vehicle 
        </h5>
    </div>
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
        </tr>
    </thead>
    <tbody id="tableBody">
        <!-- Rows would be populated here via Blade or JavaScript -->
    </tbody>
</table>
@endsection