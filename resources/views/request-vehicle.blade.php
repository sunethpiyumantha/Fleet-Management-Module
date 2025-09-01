@extends('layouts.app')

@section('title', 'Vehicle Request Management')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Request Management</h2>

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

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" action="{{ route('vehicle.request.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
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
                    <div style="flex: 1 1 250px;">
                        <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                        <select id="sub_cat_id" name="sub_cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled selected>Select Sub-Category</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="vehicle_book" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Book</label>
                        <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="image_01" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 01</label>
                        <input type="file" id="image_01" name="image_01" accept=".jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="image_02" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 02</label>
                        <input type="file" id="image_02" name="image_02" accept=".jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="image_03" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 03</label>
                        <input type="file" id="image_03" name="image_03" accept=".jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="image_04" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 04</label>
                        <input type="file" id="image_04" name="image_04" accept=".jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                </div>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Form -->
        <form method="GET" action="{{ route('vehicle.request.index') }}" style="margin-bottom: 1.5rem;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Serial Number, Request Type, Category, Sub-Category, or Status"
                       style="flex: 1; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; font-size: 0.875rem;">
                <button type="submit" style="background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                    Search
                </button>
            </div>
        </form>

        <!-- Table -->
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
            <thead style="background-color: #f97316; color: white;">
                <tr>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(0)">Serial Number ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(1)">Request Type ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(2)">Vehicle Category ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(3)">Sub Category ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(4)">Quantity ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(5)">Date Submitted ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;" onclick="sortTable(6)">Status ▲▼</th>
                    <th style="padding: 0.75rem;">Images</th>
                    <th style="padding: 0.75rem; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $vehicle->serial_number ?? 'N/A' }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                            {{ $vehicle->request_type === 'replacement' ? 'Vehicle Replacement' : ($vehicle->request_type === 'new_approval' ? 'New Approval' : 'N/A') }}
                        </td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ optional($vehicle->category)->category ?? 'N/A' }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ optional($vehicle->subCategory)->sub_category ?? 'N/A' }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $vehicle->qty }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $vehicle->date_submit ?? 'N/A' }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $vehicle->status ?? 'N/A' }}</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6; text-align: center;">
                            <button onclick="openImageModal('{{ $vehicle->serial_number }}', [
                                @if($vehicle->image_01_path) '{{ Storage::url($vehicle->image_01_path) }}', @endif
                                @if($vehicle->image_02_path) '{{ Storage::url($vehicle->image_02_path) }}', @endif
                                @if($vehicle->image_03_path) '{{ Storage::url($vehicle->image_03_path) }}', @endif
                                @if($vehicle->image_04_path) '{{ Storage::url($vehicle->image_04_path) }}' @endif
                            ])" style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none;">
                                <i class="fa-solid fa-image"></i> View
                            </button>
                        </td>
                        <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                            <form action="{{ route('vehicle.request.edit', $vehicle->id) }}" method="GET" style="display: inline;">
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">No vehicle requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top: 1rem;">
            {{ $vehicles->appends(['sort' => $sort, 'order' => $order, 'search' => request('search')])->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; max-width: 90%; max-height: 90%; overflow: auto;">
        <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Vehicle Images</h3>
        <div id="imageContainer" style="display: flex; flex-wrap: wrap; gap: 1rem;"></div>
        <button onclick="closeImageModal()" style="margin-top: 1rem; background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
            Close
        </button>
    </div>
</div>

<script>
    // Sub-category fetching
    document.getElementById('cat_id').addEventListener('change', function() {
        const catId = this.value;
        const subCatSelect = document.getElementById('sub_cat_id');
        subCatSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';

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
                subCatSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching sub-categories:', error);
            subCatSelect.innerHTML = '<option value="" disabled selected>Error loading sub-categories</option>';
        });
    });

    // Sorting
    function sortTable(columnIndex) {
        const sortColumns = ['serial_number', 'request_type', 'category', 'sub_category', 'qty', 'date_submit', 'status'];
        const currentSort = "{{ $sort }}";
        const currentOrder = "{{ $order }}";
        const newSort = sortColumns[columnIndex];
        const newOrder = (currentSort === newSort && currentOrder === 'asc') ? 'desc' : 'asc';

        window.location.href = "{{ route('vehicle.request.index') }}?sort=" + newSort + "&order=" + newOrder + "&search={{ request('search') ?? '' }}&per_page={{ request('per_page', 15) }}";
    }

    // Image Modal
    function openImageModal(serialNumber, images) {
        const modal = document.getElementById('imageModal');
        const title = document.getElementById('modalTitle');
        const container = document.getElementById('imageContainer');

        title.textContent = `Vehicle Images for ${serialNumber}`;
        container.innerHTML = '';

        if (images.length === 0) {
            container.innerHTML = '<p>No images available.</p>';
        } else {
            images.forEach(src => {
                const img = document.createElement('img');
                img.src = src;
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                img.style.borderRadius = '0.25rem';
                container.appendChild(img);
            });
        }

        modal.style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }
</script>

<style>
    /* Ensure modal images are responsive */
    #imageContainer img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }
</style>
@endsection