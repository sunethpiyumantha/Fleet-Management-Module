@extends('layouts.app')

@section('title', 'Vehicle Type Management')

@section('content')
  <div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
      <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Type Management</h2>

      <!-- Form -->
      <form class="mb-8" style="margin-bottom: 2rem;">
        <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
          <div style="width: 100%; max-width: 75%;">
            <label for="vehicleType" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Select Vehicle Type</label>
            <select id="vehicleType" name="vehicle_type" required
              style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
              <option value="" disabled selected>-- Choose Vehicle Type --</option>
              <option value="Army Vehicle">Army Vehicle</option>
              <option value="Hired Vehicle">Hired Vehicle</option>
            </select>
          </div>
          <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
            <button type="submit"
              style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
              onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
              <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Add
            </button>
          </div>
        </div>
      </form>

      <!-- Table -->
      <div style="overflow-x: auto;">
        <table style="width: 100%; font-size: 0.875rem; text-align: left; background-color: white; border: 1px solid #fdba74; border-radius: 0.5rem; overflow: hidden;">
          <thead style="background-color: #f97316; color: white; text-transform: uppercase;">
            <tr>
              <th style="padding: 0.75rem 1.5rem;">Vehicle Type</th>
              <th style="padding: 0.75rem 1.5rem; text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach (['Army Vehicle', 'Hired Vehicle', ] as $vehicle)
              <tr style="border-bottom: 1px solid #e5e7eb;" onmouseover="this.style.backgroundColor='#fff7ed'" onmouseout="this.style.backgroundColor='white'">
                <td style="padding: 0.75rem 1.5rem;">
                  <input type="text" value="{{ $vehicle }}" style="width: 100%; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.25rem 0.5rem;">
                </td>
                <td style="padding: 0.75rem 1.5rem; text-align: center;">
                  <button style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; border: none; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                    <i class="fa-solid fa-pen-to-square" style="margin-right: 0.25rem;"></i> Update
                  </button>
                  <button style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; border: none; cursor: pointer; margin-left: 0.5rem;"
                    onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                    <i class="fa-solid fa-trash" style="margin-right: 0.25rem;"></i> Delete
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
