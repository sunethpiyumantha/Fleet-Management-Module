@extends('layouts.app')

@section('title', 'Driver Amendment Form')

@section('content')
<!-- Main container -->
<div style="max-width: 80rem; margin: 0 auto; padding: 2.5rem 1.5rem; font-family: Arial, sans-serif;">
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); border: 2px solid #f97316; border-radius: 1.5rem; box-shadow: 0 12px 20px -5px rgba(0,0,0,0.15), 0 6px 8px -4px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 2rem; font-weight: 700; color: #ea580c; text-align: center; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 1px;">
            Driver Amendment Form
        </h2>

        <!-- Driver Amendment Form -->
        <form style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Driver Type Selection -->
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="font-size: 1rem; font-weight: 600; color: #374151;">Driver Type</label>
                <select id="driverType" onchange="toggleFields()" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; width: 300px;">
                    <option value="army">Army Driver</option>
                    <option value="civil">Civil Driver</option>
                </select>
            </div>

            <!-- Army Driver Fields -->
            <div id="armyFields" style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 1rem; font-weight: 600; color: #374151;">Army Driving License Certified Copy</label>
                    <input type="file" accept=".pdf,.jpg,.png" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 1rem; font-weight: 600; color: #374151;">Civil Driving License Certified Copy</label>
                    <input type="file" accept=".pdf,.jpg,.png" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 1rem; font-weight: 600; color: #374151;">Army ID Certified Copy</label>
                    <input type="file" accept=".pdf,.jpg,.png" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                </div>
            </div>

            <!-- Civil Driver Fields -->
            <div id="civilFields" style="display: none; flex-direction: column; gap: 1rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 1rem; font-weight: 600; color: #374151;">Certified Copy of Civil Driving License</label>
                    <input type="file" accept=".pdf,.jpg,.png" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 1rem; font-weight: 600; color: #374151;">Certified Copy of NIC</label>
                    <input type="file" accept=".pdf,.jpg,.png" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 1rem; font-weight: 600; color: #374151;">Original Copy of Driver Grama Sewa Certificate</label>
                    <input type="file" accept=".pdf,.jpg,.png" style="padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; font-size: 1rem; font-weight: 600; transition: all 0.3s ease, transform 0.2s ease; width: fit-content; align-self: center;"
                    onmouseover="this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'"
                    onmouseout="this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'">
                Submit
            </button>
        </form>
    </div>
</div>

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