@extends('layouts.app')

@section('title', 'Vehicle Registration Form')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Technical description of the Vehicle</h2>

    <div style="display: flex; flex-direction: column; gap: 1rem;">
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Number</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Couple Number</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Race</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Number</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Year of Manufacture</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Type of Fuel Burned</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Type of Vehicle</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Model</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Chassis Number</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Year and Date of Original Registration</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Capacity</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Tare Weight of Vehicle (Unladen Weight)</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Gross Vehicle Weight (Gross Weight)</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Classification of Registered Vehicles</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Motor Vehicle Registration Form and Vehicle Prepared</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per Book of Motor Vehicle Registration Department</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per Sri Lanka Unit/Job Report</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Recommended Code Number</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
        </div>
      </div>
      <div>
        <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">The Driver of the Vehicle (including civil driver/military driver) shall</label>
        <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6;">
      </div>
      <div style="text-align: center; margin-top: 1rem;">
        <button type="submit" style="background-color: #f97316; color: white; font-weight: 600; padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: none; cursor: pointer; width: 150px;">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>
@endsection