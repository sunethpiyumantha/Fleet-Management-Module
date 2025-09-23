@extends('layouts.app')

@section('title', 'Certificate of Industrial Aptitude')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; max-width: 80rem; padding: 8px; font-family: Arial, sans-serif; background-color: white; margin: 0 auto;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color: #023E8A;">Certificate of Industrial Aptitude</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Certificate of Industrial Aptitude
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

    <!-- Certificate Form -->
    <form method="POST" action="{{ route('vehicle.certificate.store') }}" enctype="multipart/form-data" style="margin-bottom: 20px;">
        @csrf
        <input type="hidden" name="serial_number" value="{{ $serial_number }}">
        <input type="hidden" name="request_type" value="{{ $request_type }}">
        
        <!-- Serial Number -->
        <div style="margin-bottom: 15px; text-align: center;">
            <p style="font-size: 14px; color: #374151; font-weight: bold;">
                Serial Number: {{ $serial_number }}
            </p>
        </div>

        <!-- Pre-filled Fields Section -->
        <div style="border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background-color: #f9fafb; margin-bottom: 20px;">
            <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Pre-filled Vehicle Information</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine Number</label>
                    <input type="text" name="engine_number" value="{{ old('engine_number', $declaration->engine_no ?? '') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('engine_number')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Chassis Number</label>
                    <input type="text" name="chassis_number" value="{{ old('chassis_number', $declaration->chassis_number ?? '') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('chassis_number')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Km Driven per Liter of Fuel</label>
                    <input type="text" name="fuel_efficiency" value="{{ old('fuel_efficiency', $declaration->amount_of_fuel ?? '') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('fuel_efficiency')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Number of Seats Installed</label>
                    <input type="text" name="seats_installed" value="{{ old('seats_installed', $declaration->seats_current ?? '') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('seats_installed')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Number of Seats as per the Motor Vehicle Registration Department</label>
                    <input type="text" name="seats_mvr" value="{{ old('seats_mvr', $declaration->seats_registered ?? '') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('seats_mvr')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Other Matters</label>
                    <textarea name="other_matters" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">{{ old('other_matters', $declaration->other_matters ?? '') }}</textarea>
                    @error('other_matters')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Other Fields Section -->
        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine Performance</label>
                <input type="text" name="engine_performance" value="{{ old('engine_performance') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('engine_performance')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Electrical System</label>
                <input type="text" name="electrical_system" value="{{ old('electrical_system') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('electrical_system')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Transmission System</label>
                <input type="text" name="transmission_system" value="{{ old('transmission_system') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('transmission_system')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Tires</label>
                <input type="text" name="tires" value="{{ old('tires') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('tires')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Brake System</label>
                <input type="text" name="brake_system" value="{{ old('brake_system') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('brake_system')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Suspension System</label>
                <input type="text" name="suspension_system" value="{{ old('suspension_system') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('suspension_system')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Air Conditioning Operation</label>
                <input type="text" name="air_conditioning" value="{{ old('air_conditioning') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('air_conditioning')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Condition of Seats and Upholstery</label>
                <input type="text" name="seats_condition" value="{{ old('seats_condition') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('seats_condition')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Picture</label>
                <input type="file" name="vehicle_picture" accept="image/*" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                @error('vehicle_picture')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Speedometer Operation</label>
                <input type="text" name="speedometer_operation" value="{{ old('speedometer_operation') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('speedometer_operation')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Running Distance Function</label>
                <input type="text" name="running_distance_function" value="{{ old('running_distance_function') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('running_distance_function')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Operation of the Transmission System</label>
                <input type="text" name="transmission_operation" value="{{ old('transmission_operation') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('transmission_operation')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Details Improvements Made the Vehicle</label>
                <textarea name="improvements" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>{{ old('improvements') }}</textarea>
                @error('improvements')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Battery Type</label>
                <input type="text" name="battery_type" value="{{ old('battery_type') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('battery_type')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Battery Capacity</label>
                <input type="text" name="battery_capacity" value="{{ old('battery_capacity') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('battery_capacity')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Battery Number</label>
                <input type="text" name="battery_number" value="{{ old('battery_number') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('battery_number')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Water Capacity (Water Bowsers & Trailer Water Bowsers )</label>
                <input type="text" name="water_capacity" value="{{ old('water_capacity') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                @error('water_capacity')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Cover Outer Size and Number (with Extra Cover Outer)</label>
                <input type="text" name="cover_outer" value="{{ old('cover_outer') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('cover_outer')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Validity Period of the Certificate of Eligibility</label>
                <input type="text" name="certificate_validity" value="{{ old('certificate_validity') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('certificate_validity')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Speedometer Reading During Fitness Testing</label>
                <input type="text" name="speedometer_reading" value="{{ old('speedometer_reading') }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                @error('speedometer_reading')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div style="flex: 1; min-width: 120px; display: flex; justify-content: center; align-items: center; padding:1rem;">
    <button type="submit" 
            style="width: 10%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
            onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
        Submit
    </button>
</div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        console.log('Form submitted to:', form.action);
    });
});
</script>
@endsection