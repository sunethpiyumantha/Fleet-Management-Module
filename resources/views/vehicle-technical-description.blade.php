@extends('layouts.app')

@section('title', 'Vehicle Inspection Form')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Inspection Form</h2>

    <h3 style="font-size: 1.25rem; font-weight: 600; color: #ea580c; margin-bottom: 1rem;">Pre-filled Data (from Declaration Form)</h3>
    <div style="display: flex; flex-direction: column; gap: 1rem;">
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle No (Army / Civil)</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Type of Vehicle</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Manufacturer</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Model</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine No</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Chassis No</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Year of Manufacture</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Year and Date of Original Registration</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Type of Fuel</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Capacity</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Tar Weight of the Vehicle</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Code Number</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Driver</label>
          <input type="text" disabled style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; background-color: #f3f4f6; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        
        <div style="flex: 1;"></div> <!-- Empty div to balance the layout -->
      </div>
    </div>
  </div>

  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <h3 style="font-size: 1.25rem; font-weight: 600; color: #ea580c; margin-bottom: 1rem;">Data to be Filled</h3>
    <div style="display: flex; flex-direction: column; gap: 1rem;">
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Gross Weight of the Vehicle</label>
          <input type="text" name="gross_weight" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;">
        </div>
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per the SLEME Unit/Workshop</label>
          <input type="text" name="seats_sleme" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;">
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Is it comparable to a motor vehicle registration document?</label>
          <div style="display: flex; gap: 1rem;">
            <label><input type="radio" name="comparable" value="yes" style="margin-right: 0.25rem; color: green;"> Yes</label>
            <label><input type="radio" name="comparable" value="no" style="margin-right: 0.25rem; color: green;"> No</label>
          </div>
        </div>
        <div style="flex: 1;"></div> <!-- Empty div to balance the layout -->
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Number of Seats as per the Motor Vehicle Registration Department</label>
          <input type="text" name="seats_mvr" style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: green;">
        </div>
        <div style="flex: 1;"></div> <!-- Empty div to balance the layout -->
      </div>
      <div style="display: flex; justify-content: space-between; gap: 1rem;">
        <div style="flex: 1;">
          <div style="text-align: center; margin-top: 1rem;">
            <button type="submit" style="background-color: #f97316; color: white; font-weight: 600; padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: none; cursor: pointer; width: 150px;">
              Submit
            </button>
          </div>
        </div>
        <div style="flex: 1;"></div> <!-- Empty div to balance the layout -->
      </div>
    </div>
  </div>
</div>
@endsection