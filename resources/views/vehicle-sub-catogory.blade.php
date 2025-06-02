@extends('layouts.app')

@section('title', 'Vehicle Sub Category Management')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
  <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Sub Category Management</h2>

    <!-- Sub Category Form -->
    <form class="mb-8" style="margin-bottom: 2rem;">
      <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
        
        <!-- Category Dropdown -->
        <div style="width: 100%; max-width: 30%;">
          <label for="vehicleCategory" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
          <select id="vehicleCategory" name="vehicle_category"
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; color: #374151;">
            @foreach (['Army Vehicle', 'Hired Vehicle', 'Medical Van', 'Police Jeep'] as $category)
              <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
          </select>
        </div>

        <!-- Sub Category Input -->
        <div style="width: 100%; max-width: 45%;">
          <label for="vehicleSubCategory" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter Sub Category</label>
          <input type="text" id="vehicleSubCategory" name="vehicle_sub_category" required
            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem;">
        </div>

        <!-- Add Button -->
        <div style="width: 100%; max-width: 25%; margin-top: 1.8rem;" class="md:mt-0">
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
      <table id="subCategoryTable"
        style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
        <thead style="background-color: #f97316; color: white; cursor: pointer;">
          <tr>
            <th style="padding: 0.75rem;">Vehicle Category</th>
            <th style="padding: 0.75rem;">Sub Category</th>
            <th style="padding: 0.75rem; text-align: center;">Actions</th>
          </tr>
        </thead>
        <tbody id="subCategoryTableBody">
          @foreach ([['category' => 'Army Vehicle', 'sub' => 'Double Cab'], ['category' => 'Police Jeep', 'sub' => '4x4 SUV']] as $row)
            <tr>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $row['category'] }}</td>
              <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $row['sub'] }}</td>
              <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                <button style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">Update</button>
                <button style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">Delete</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
