@extends('layouts.app')

@section('title', 'Certificate of Industrial Aptitude')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 0.5rem;">
      Certificate of Industrial Aptitude
    </h2>
    <p style="font-size: 1rem; color: #374151; text-align: center; margin-bottom: 1.5rem;">
      Serial Number: {{ $serial_number }}
    </p>

    <form method="POST" action="{{ route('vehicle.certificate.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="serial_number" value="{{ $serial_number }}">
      <input type="hidden" name="request_type" value="{{ $request_type }}">
      <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Number</label>
            <input type="text" name="engine_number" value="{{ old('engine_number') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('engine_number')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Chassis Number</label>
            <input type="text" name="chassis_number" value="{{ old('chassis_number') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('chassis_number')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Performance</label>
            <input type="text" name="engine_performance" value="{{ old('engine_performance') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('engine_performance')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Electrical System</label>
            <input type="text" name="electrical_system" value="{{ old('electrical_system') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('electrical_system')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Transmission System</label>
            <input type="text" name="transmission_system" value="{{ old('transmission_system') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('transmission_system')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Tires</label>
            <input type="text" name="tires" value="{{ old('tires') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('tires')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Brake System</label>
            <input type="text" name="brake_system" value="{{ old('brake_system') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('brake_system')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Suspension System</label>
            <input type="text" name="suspension_system" value="{{ old('suspension_system') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('suspension_system')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Air Conditioning Operation</label>
            <input type="text" name="air_conditioning" value="{{ old('air_conditioning') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('air_conditioning')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Condition of Seats and Upholstery</label>
            <input type="text" name="seats_condition" value="{{ old('seats_condition') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('seats_condition')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Km Driven per Liter of Fuel</label>
            <input type="text" name="fuel_efficiency" value="{{ old('fuel_efficiency') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('fuel_efficiency')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Speedometer Reading During Fitness Testing</label>
            <input type="text" name="speedometer_reading" value="{{ old('speedometer_reading') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('speedometer_reading')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Speedometer Operation</label>
            <input type="text" name="speedometer_operation" value="{{ old('speedometer_operation') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('speedometer_operation')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Running Distance Function</label>
            <input type="text" name="running_distance_function" value="{{ old('running_distance_function') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('running_distance_function')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Details of Improvements Made to the Vehicle</label>
            <textarea name="improvements" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>{{ old('improvements') }}</textarea>
            @error('improvements')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Operation of the Transmission System</label>
            <input type="text" name="transmission_operation" value="{{ old('transmission_operation') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('transmission_operation')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Battery Type</label>
            <input type="text" name="battery_type" value="{{ old('battery_type') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('battery_type')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Battery Capacity</label>
            <input type="text" name="battery_capacity" value="{{ old('battery_capacity') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('battery_capacity')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Battery Number</label>
            <input type="text" name="battery_number" value="{{ old('battery_number') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('battery_number')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Water Capacity (For Water Bowsers and Trailer Water Bowsers Only)</label>
            <input type="text" name="water_capacity" value="{{ old('water_capacity') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;">
            @error('water_capacity')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Cover Outer Size and Number (with Extra Cover Outer)</label>
            <input type="text" name="cover_outer" value="{{ old('cover_outer') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('cover_outer')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Validity Period of the Certificate of Eligibility</label>
            <input type="text" name="certificate_validity" value="{{ old('certificate_validity') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('certificate_validity')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per the Motor Vehicle Registration Department</label>
            <input type="text" name="seats_mvr" value="{{ old('seats_mvr') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('seats_mvr')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats Installed</label>
            <input type="text" name="seats_installed" value="{{ old('seats_installed') }}" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;" required>
            @error('seats_installed')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 1rem;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Other Matters</label>
            <textarea name="other_matters" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;">{{ old('other_matters') }}</textarea>
            @error('other_matters')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Picture</label>
            <input type="file" name="vehicle_picture" accept="image/*" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;">
            @error('vehicle_picture')
              <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div style="text-align: center; margin-top: 1rem;">
          <button type="submit" style="background-color: #f97316; color: white; font-weight: 600; padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: none; cursor: pointer; width: 150px; transition: background-color: 0.3s ease, transform: 0.2s ease;"
                  onmouseover="this.style.backgroundColor='#ea580c'; this.style.transform='scale(1.05)'"
                  onmouseout="this.style.backgroundColor='#f97316'; this.style.transform='scale(1)'">
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
