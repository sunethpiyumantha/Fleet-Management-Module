@extends('layouts.app')

@section('title', 'Vehicle Technical Description')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; max-width: 64rem; padding: 8px; font-family: Arial, sans-serif; background-color: white; margin: 0 auto;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color: #023E8A;">Vehicle Technical Description</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Technical Description - Serial No: {{ $vehicleRequest->serial_number ?? $vehicleDeclaration->serial_number ?? 'N/A' }}
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

    <!-- Pre-filled Data Section -->
    <div style="border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background-color: #f9fafb; margin-bottom: 20px;">
        <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Pre-filled Data (from Declaration Form)</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle No (Army / Civil)</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->civil_number ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Type of Vehicle</label>
                <select disabled style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
                    <option value="" {{ !isset($vehicleDeclaration->vehicleType->type) ? 'selected' : '' }}>N/A</option>
                    @foreach(\App\Models\VehicleType::all() as $vehicleType)
                        <option value="{{ $vehicleType->type }}" {{ isset($vehicleDeclaration->vehicleType->type) && $vehicleDeclaration->vehicleType->type == $vehicleType->type ? 'selected' : '' }}>
                            {{ $vehicleType->type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Manufacturer</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->vehicleModel->manufacturer ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Model</label>
                <select disabled style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
                    <option value="" {{ !isset($vehicleDeclaration->vehicleModel->model) ? 'selected' : '' }}>N/A</option>
                    @foreach(\App\Models\VehicleModel::all() as $vehicleModel)
                        <option value="{{ $vehicleModel->model }}" {{ isset($vehicleDeclaration->vehicleModel->model) && $vehicleDeclaration->vehicleModel->model == $vehicleModel->model ? 'selected' : '' }}>
                            {{ $vehicleModel->model }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine No</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->engine_no ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Chassis No</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->chassis_number ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Year of Manufacture</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->year_of_manufacture ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Date of Original Registration</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->date_of_original_registration ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Type of Fuel</label>
                <select disabled style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
                    <option value="" {{ !isset($vehicleDeclaration->fuelType->fuel_type) ? 'selected' : '' }}>N/A</option>
                    @foreach(\App\Models\FuelType::all() as $fuelType)
                        <option value="{{ $fuelType->fuel_type }}" {{ isset($vehicleDeclaration->fuelType->fuel_type) && $vehicleDeclaration->fuelType->fuel_type == $fuelType->fuel_type ? 'selected' : '' }}>
                            {{ $fuelType->fuel_type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine Capacity</label>
                <select disabled style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
                    <option value="" {{ !isset($vehicleDeclaration->engineCapacity->engine_capacity) ? 'selected' : '' }}>N/A</option>
                    @foreach(\App\Models\VehicleEngineCapacity::all() as $engineCapacity)
                        <option value="{{ $engineCapacity->engine_capacity }}" {{ isset($vehicleDeclaration->engineCapacity->engine_capacity) && $vehicleDeclaration->engineCapacity->engine_capacity == $engineCapacity->engine_capacity ? 'selected' : '' }}>
                            {{ $engineCapacity->engine_capacity }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Tar Weight of the Vehicle</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->tar_weight_capacity ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Category</label>
                <select disabled style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
                    <option value="" {{ !isset($vehicleRequest->category->category) ? 'selected' : '' }}>N/A</option>
                    @isset($categories)
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ isset($vehicleRequest->category->id) && $vehicleRequest->category->id == $category->id ? 'selected' : '' }}>
                                {{ $category->category }}
                            </option>
                        @endforeach
                    @else
                        <option value="">No categories available</option>
                    @endisset
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Code Number</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->code_no_vehicle ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Driver</label>
                <input type="text" disabled value="{{ $vehicleDeclaration->drivers->first()->driver_name ?? 'N/A' }}" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; background-color: #f3f4f6; color: #03045E;">
            </div>
        </div>
    </div>

    <!-- Data to be Filled Section -->
    <div style="border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background-color: #f9fafb;">
        <form method="POST" action="{{ route('vehicle.technical.store', ['serial_number' => $vehicleRequest->serial_number ?? $vehicleRequest->id]) }}">
            @csrf
            <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Data to be Filled</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                <div style="flex: 1; min-width: 220px; ">
                    <label style="display: block; padding: 11px; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Gross Weight of the Vehicle</label>
                    <input type="text" name="gross_weight" value="{{ old('gross_weight') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('gross_weight')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Number of Seats as per the SLEME Unit/Workshop</label>
                    <input type="text" name="seats_sleme" value="{{ old('seats_sleme') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('seats_sleme')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Is it comparable to a motor vehicle registration document?</label>
                    <div style="display: flex; gap: 1rem;">
                        <label style="padding: 8px;"><input type="radio" name="comparable" value="yes" {{ old('comparable') == 'yes' ? 'checked' : '' }} style="margin-right: 0.25rem; " required> Yes</label>
                        <label style="padding: 8px;" ><input type="radio" name="comparable" value="no" {{ old('comparable') == 'no' ? 'checked' : '' }} style="margin-right: 0.25rem;" required> No</label>
                    </div>
                    @error('comparable')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Number of Seats as per the Motor Vehicle Registration Department</label>
                    <input type="text" name="seats_mvr" value="{{ old('seats_mvr') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;" required>
                    @error('seats_mvr')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end; justify-content: center;">
                    <button type="submit" 
                            style="width: 15%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
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