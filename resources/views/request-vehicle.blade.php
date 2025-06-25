@extends('layouts.app')

@section('title', 'Vehicle Request')

@section('content')
<!-- Main container -->
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Request</h2>

        <!-- Display Success or Error Messages -->
        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form for vehicle request submission -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" action="{{ route('vehicle.request.store') }}">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <!-- First Line: Vehicle Request Type and Vehicle Category -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="request_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Request Type</label>
                        <select id="request_type" name="request_type" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Request Type</option>
                            <option value="replacement">Vehicle replacement</option>
                            <option value="new_approval">Taking over a vehicle based on a new approval</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                        <select id="cat_id" name="cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Line: Vehicle Sub Category and Required Quantity -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 500px;">
                    <div style="flex: 1 1 250px;">
                        <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                        <select id="sub_cat_id" name="sub_cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Sub-Category</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                </div>

                <!-- Third Line: Submit Button -->
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('vehicle.request.index') }}" style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
            <input type="text" name="search" id="searchInput" placeholder="Search Vehicle Request..." value="{{ request('search') }}"
                   style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;">
            <button type="submit"
                    style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.4rem 0.8rem; cursor: pointer; font-size: 0.875rem;"
                    aria-label="Search vehicle requests">
                <span class="sr-only">Search</span> 🔍
            </button>
        </form>

        <!-- Vehicle Requests Table -->
        <div style="overflow-x: auto;">
            <table id="vehicleTable" style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <thead style="background-color: #f97316; color: white;">
                    <tr>
                        <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(0)">
                            Request Type ▲▼
                        </th>
                        <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(1)">
                            Vehicle Category ▲▼
                        </th>
                        <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(2)">
                            Sub Category ▲▼
                        </th>
                        <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(3)">
                            Quantity ▲▼
                        </th>
                        <th style="padding: 0.75rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                {{ $vehicle->request_type === 'replacement' ? 'Vehicle Replacement' : ($vehicle->request_type === 'new_approval' ? 'New Approval' : 'N/A') }}
                            </td>
                            <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                {{ optional($vehicle->category)->category ?? 'N/A' }}
                            </td>
                            <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                {{ optional($vehicle->subCategory)->sub_category ?? 'N/A' }}
                            </td>
                            <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                {{ $vehicle->qty }}
                            </td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                                @if($vehicle->id)
                                    <p>Vehicle ID: {{ $vehicle->id }}</p>
                                    <form action="{{ route('vehicle.request.edit', ['id' => $vehicle->id, 'request_type' => $vehicle->request_type]) }}" method="GET" style="display: inline;">
                                        <button type="submit" style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">
                                            Update
                                        </button>
                                    </form>
                                    <form action="{{ route('vehicle.request.destroy', $vehicle->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this Vehicle Request?')"
                                                style="background-color: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; margin-left: 0.5rem;">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">No vehicle requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" style="margin-top: 1rem; text-align: center;">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>

<script>
    // Sub-category fetch logic
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
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            data.forEach(subCat => {
                const option = document.createElement('option');
                option.value = subCat.id;
                option.textContent = subCat.sub_category;
                subVehicleSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching sub-categories:', error);
            subVehicleSelect.innerHTML = '<option value="" disabled selected>Error loading sub-categories</option>';
            alert('Failed to load sub-categories. Please refresh the page or contact support.');
        });
    });

    // Trigger change event on page load to populate sub-categories if cat_id has a value
    document.getElementById('cat_id').dispatchEvent(new Event('change'));

    // Disable submit button to prevent multiple submissions
    document.querySelector('form[method="POST"]').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.style.opacity = '0.6';
    });
</script>
@endsection