@extends('layouts.app')

@section('title', 'Edit Vehicle Request')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Edit Vehicle Request</h2>

        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form style="margin-bottom: 2rem;" method="POST" action="{{ route('vehicle.request.update', $vehicle->id) }}">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row md:flex-wrap md:justify-center">
                <div style="width: 100%; max-width: 25%;">
                    <label for="request_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Request Type</label>
                    <select id="request_type" name="request_type" required
                            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                        <option value="" disabled>Select Request Type</option>
                        <option value="replacement" {{ $vehicle->request_type == 'replacement' ? 'selected' : '' }}>Vehicle replacement</option>
                        <option value="new_approval" {{ $vehicle->request_type == 'new_approval' ? 'selected' : '' }}>Taking over a vehicle based on a new approval</option>
                    </select>
                </div>

                <div style="width: 100%; max-width: 25%;">
                    <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                    <select id="cat_id" name="cat_id" required
                            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                        <option value="" disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $vehicle->cat_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="width: 100%; max-width: 25%;">
                    <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                    <select id="sub_cat_id" name="sub_cat_id" required
                            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                        <option value="" disabled>Select Sub-Category</option>
                    </select>
                </div>

                <div style="width: 100%; max-width: 25%;">
                    <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                    <input type="number" id="required_quantity" name="qty" min="1" value="{{ $vehicle->qty }}" required
                           style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                </div>

                <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
                    <button type="submit"
                            style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-save" style="margin-right: 0.25rem;"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('cat_id').addEventListener('change', function() {
        const catId = this.value;
        const subVehicleSelect = document.getElementById('sub_cat_id');
        subVehicleSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';

        if (!catId) return;

        fetch(`/get-sub-categories/${catId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(subCat => {
                const option = document.createElement('option');
                option.value = subCat.id;
                option.textContent = subCat.sub_category;
                if (subCat.id == {{ $vehicle->sub_cat_id }}) option.selected = true;
                subVehicleSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching sub-categories:', error));
    });

    document.getElementById('cat_id').dispatchEvent(new Event('change'));
</script>
@endsection