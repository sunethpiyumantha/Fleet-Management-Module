```blade
@extends('layouts.app')

@section('title', 'Driver Amendment Form')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Driver Amendment Form</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Driver Amendment Form
        </h5>
    </div>

    <!-- Driver Amendment Form -->
    <form style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <!-- Driver Type Selection -->
        <div style="flex: 1; min-width: 220px;">
            <label for="driverType" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Driver Type</label>
            <select id="driverType" onchange="toggleFields()"
                    style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                <option value="army">Army Driver</option>
                <option value="civil">Civil Driver</option>
            </select>
        </div>

        <!-- Army Driver Fields -->
        <div id="armyFields" style="display: flex; flex-wrap: wrap; gap: 15px; width: 100%;">
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Army Driving License Certified Copy</label>
                <input type="file" accept=".pdf,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Civil Driving License Certified Copy</label>
                <input type="file" accept=".pdf,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Army ID Certified Copy</label>
                <input type="file" accept=".pdf,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
        </div>

        <!-- Civil Driver Fields -->
        <div id="civilFields" style="display: none; flex-wrap: wrap; gap: 15px; width: 100%;">
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Certified Copy of Civil Driving License</label>
                <input type="file" accept=".pdf,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Certified Copy of NIC</label>
                <input type="file" accept=".pdf,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Original Copy of Driver Grama Sewa Certificate</label>
                <input type="file" accept=".pdf,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
        </div>

        <!-- Submit Button -->
        <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
            <button type="submit"
                    style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                + Submit
            </button>
        </div>
    </div>
</form>

<script>
function toggleFields() {
    const driverType = document.getElementById('driverType').value;
    const armyFields = document.getElementById('armyFields');
    const civilFields = document.getElementById('civilFields');
    
    if (driverType === 'army') {
        armyFields.style.display = 'flex';
        civilFields.style.display = 'none';
    } else {
        armyFields.style.display = 'none';
        civilFields.style.display = 'flex';
    }
}
</script>
@endsection
```