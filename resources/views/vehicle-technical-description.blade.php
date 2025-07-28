@extends('layouts.app')

@section('title', 'Vehicle Technical Description')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <!-- Success Message Display -->
  @if (session('success'))
    <div style="background-color: #d1fae5; border: 1px solid #10b981; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; color: #065f46; font-size: 0.875rem; font-weight: 500; text-align: center;">
      {{ session('success') }}
    </div>
  @endif

  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">
      Vehicle Technical Description - Serial No: {{ $vehicleRequest->serial_number ?? $vehicleDeclaration->serial_number ?? 'N/A' }}
    </h2>

    <h3 style="font-size: 1.25rem; font-weight: 600; color: #ea580c; margin-bottom: 1rem;">Pre-filled Data (from Declaration Form)</h3>
    <div style="display: flex; flex-direction: column; gap: 1rem;">
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle No (Army / Civil)</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->civil_number ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Type of Vehicle</label>
          <select disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
            <option value="" {{ !isset($vehicleDeclaration->vehicleType->type) ? 'selected' : '' }}>N/A</option>
            @foreach(\App\Models\VehicleType::all() as $vehicleType)
              <option value="{{ $vehicleType->type }}" {{ isset($vehicleDeclaration->vehicleType->type) && $vehicleDeclaration->vehicleType->type == $vehicleType->type ? 'selected' : '' }}>
                {{ $vehicleType->type }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Manufacturer</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->vehicleModel->manufacturer ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Model</label>
          <select disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
            <option value="" {{ !isset($vehicleDeclaration->vehicleModel->model) ? 'selected' : '' }}>N/A</option>
            @foreach(\App\Models\VehicleModel::all() as $vehicleModel)
              <option value="{{ $vehicleModel->model }}" {{ isset($vehicleDeclaration->vehicleModel->model) && $vehicleDeclaration->vehicleModel->model == $vehicleModel->model ? 'selected' : '' }}>
                {{ $vehicleModel->model }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine No</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->engine_no ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Chassis No</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->chassis_number ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Year of Manufacture</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->year_of_manufacture ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Year and Date of Original Registration</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->date_of_original_registration ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Type of Fuel</label>
          <select disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
            <option value="" {{ !isset($vehicleDeclaration->fuelType->fuel_type) ? 'selected' : '' }}>N/A</option>
            @foreach(\App\Models\FuelType::all() as $fuelType)
              <option value="{{ $fuelType->fuel_type }}" {{ isset($vehicleDeclaration->fuelType->fuel_type) && $vehicleDeclaration->fuelType->fuel_type == $fuelType->fuel_type ? 'selected' : '' }}>
                {{ $fuelType->fuel_type }}
              </option>
            @endforeach
          </select>
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Capacity</label>
          <select disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
            <option value="" {{ !isset($vehicleDeclaration->engineCapacity->engine_capacity) ? 'selected' : '' }}>N/A</option>
            @foreach(\App\Models\VehicleEngineCapacity::all() as $engineCapacity)
              <option value="{{ $engineCapacity->engine_capacity }}" {{ isset($vehicleDeclaration->engineCapacity->engine_capacity) && $vehicleDeclaration->engineCapacity->engine_capacity == $engineCapacity->engine_capacity ? 'selected' : '' }}>
                {{ $engineCapacity->engine_capacity }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Tar Weight of the Vehicle</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->tar_weight_capacity ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
          <select disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
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
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Code Number</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->code_no_vehicle ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Driver</label>
          <input type="text" disabled value="{{ $vehicleDeclaration->drivers->first()->driver_name ?? 'N/A' }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
    </div>
  </div>

  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <form method="POST" action="{{ route('vehicle.technical.store', ['serial_number' => $vehicleRequest->serial_number ?? $vehicleRequest->id]) }}">
      @csrf
      <h3 style="font-size: 1.25rem; font-weight: 600; color: #ea580c; margin-bottom: 1rem;">Data to be Filled</h3>
      <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Gross Weight of the Vehicle</label>
            <input type="text" name="gross_weight" value="{{ old('gross_weight') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('gross_weight')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per the SLEME Unit/Workshop</label>
            <input type="text" name="seats_sleme" value="{{ old('seats_sleme') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('seats_sleme')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Is it comparable to a motor vehicle registration document?</label>
            <div style="display: flex; gap: 1rem;">
              <label><input type="radio" name="comparable" value="yes" {{ old('comparable') == 'yes' ? 'checked' : '' }} style="margin-right: 0.25rem; color: green;" required> Yes</label>
              <label><input type="radio" name="comparable" value="no" {{ old('comparable') == 'no' ? 'checked' : '' }} style="margin-right: 0.25rem; color: green;" required> No</label>
            </div>
            @error('comparable')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per the Motor Vehicle Registration Department</label>
            <input type="text" name="seats_mvr" value="{{ old('seats_mvr') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('seats_mvr')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <div style="text-align: center; margin-top: 1rem;">
              <button type="submit" style="background-color: #f97316; color: white; font-weight: 600; padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: none; cursor: pointer; width: 150px; transition: background-color 0.3s ease, transform: 0.2s ease;"
                      onmouseover="this.style.backgroundColor='#ea580c'; this.style.transform='scale(1.05)'"
                      onmouseout="this.style.backgroundColor='#f97316'; this.style.transform='scale(1)'">
                Submit
              </button>
            </div>
          </div>
          <div style="flex: 1;"></div>
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