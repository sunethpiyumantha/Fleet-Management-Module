@extends('layouts.app')

@section('title', 'Vehicle Request Management')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    /* Optional: table row hover effect */
    #vehicleTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color:#023E8A;">Vehicle Requests</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Request Management
        </h5>
    </div>

    <!-- Success Message -->
    @if (session('success'))
            <div style="background-color: #adf4c9; color: #006519; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
        </div>
    @endif

    <!-- Error / Delete Messages -->
    @if (session('error'))
        <div style="background-color: #f8d7da; color: #842029; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
            <div style="background-color: #f8d7da; color: #842029; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                {{ $error }}
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add Vehicle Request Form -->
    <form action="{{ route('vehicle.request.store') }}" method="POST" style="margin-bottom: 20px;" enctype="multipart/form-data">
        @csrf
        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <div style="flex: 1; min-width: 220px;">
                <label for="request_type" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Request Type</label>
                <select id="request_type" name="request_type" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Request Type</option>
                    <option value="replacement">Vehicle replacement</option>
                    <option value="new_approval">Taking over a vehicle based on a new approval</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Category</label>
                <select id="cat_id" name="cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="sub_cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Sub Category</label>
                <select id="sub_cat_id" name="sub_cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled selected>Select Sub-Category</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="required_quantity" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Required Quantity</label>
                <input type="number" id="required_quantity" name="qty" min="1" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="vehicle_book" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Book</label>
                <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_01" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Front View</label>
                <input type="file" id="image_01" name="image_01" accept=".jpg,.png" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_02" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Rear View</label>
                <input type="file" id="image_02" name="image_02" accept=".jpg,.png" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_03" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Side View 1</label>
                <input type="file" id="image_03" name="image_03" accept=".jpg,.png" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_04" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Side View 2</label>
                <input type="file" id="image_04" name="image_04" accept=".jpg,.png" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
                <button type="submit"
                        style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    + Submit
                </button>
            </div>
        </div>
    </form>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('vehicle.request.index') }}" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search by Serial Number, Request Type, Category, Sub-Category, or Status..."
               value="{{ request('search') }}"
               style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- Vehicle Requests Table -->
    <div style="overflow-x: auto;">
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px;">#</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(1)">Serial Number ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(2)">Request Type ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(3)">Vehicle Category ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(4)">Sub Category ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(5)">Quantity ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(6)">Status ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Vehicle Letter</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Images</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $vehicle->serial_number ?? 'N/A' }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">
                            {{ $vehicle->request_type === 'replacement' ? 'Vehicle Replacement' : ($vehicle->request_type === 'new_approval' ? 'New Approval' : 'N/A') }}
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ optional($vehicle->category)->category ?? 'N/A' }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ optional($vehicle->subCategory)->sub_category ?? 'N/A' }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $vehicle->qty }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $vehicle->status ?? 'N/A' }}</td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                            @if($vehicle->vehicle_book_path)
                                <button onclick="showFileModal('{{ Storage::url($vehicle->vehicle_book_path) }}')"
                                        style="background-color: #00B4D8; color: white; padding: 5px 10px; border-radius: 5px; border: none; cursor: pointer;">
                                    View
                                </button>
                            @else
                                <span>N/A</span>
                            @endif
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                            <button onclick="openImageModal('{{ $vehicle->serial_number }}', [
                                @if($vehicle->image_01_path) '{{ Storage::url($vehicle->image_01_path) }}', @endif
                                @if($vehicle->image_02_path) '{{ Storage::url($vehicle->image_02_path) }}', @endif
                                @if($vehicle->image_03_path) '{{ Storage::url($vehicle->image_03_path) }}', @endif
                                @if($vehicle->image_04_path) '{{ Storage::url($vehicle->image_04_path) }}' @endif
                            ])" style="background-color: #00B4D8; color: white; padding: 5px 10px; border-radius: 5px; border: none; cursor: pointer;">
                                View
                            </button>
                        </td>
                        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 0.5rem;">
                                <form action="{{ route('vehicle.request.edit', $vehicle->id) }}" method="GET">
                                    <button type="submit"
                                            style="background-color: #00B4D8; color: white; padding: 5px 10px; border-radius: 5px; border: none; cursor: pointer;"
                                            onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                                        Update
                                    </button>
                                </form>
                                <form action="{{ route('vehicle.request.destroy', $vehicle->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this vehicle request?')"
                                            style="background-color: #dc2626; color: white; padding: 5px 10px; border-radius: 5px; border: none; cursor: pointer;"
                                            onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">No vehicle requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 15px;">
        {{ $vehicles->appends(['sort' => $sort, 'order' => $order, 'search' => request('search')])->links('pagination::tailwind') }}
    </div>

    <!-- File Modal -->
    <div id="fileModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
        <div style="background: white; padding: 24px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow: auto;">
            <h3 id="modalTitle" style="font-size: 20px; font-weight: bold; margin-bottom: 16px;">Vehicle File</h3>
            <div id="fileContainer" style="display: flex; flex-wrap: wrap; gap: 16px;"></div>
            <button onclick="closeFileModal()"
                    style="margin-top: 16px; background-color: #00B4D8; color: white; padding: 8px 16px; border-radius: 5px; border: none; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                Close
            </button>
        </div>
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
        const sortColumns = ['', 'serial_number', 'request_type', 'category', 'sub_category', 'qty', 'status'];
        const currentSort = "{{ $sort }}";
        const currentOrder = "{{ $order }}";
        const newSort = sortColumns[columnIndex];
        const newOrder = (currentSort === newSort && currentOrder === 'asc') ? 'desc' : 'asc';

        window.location.href = "{{ route('vehicle.request.index') }}?sort=" + newSort + "&order=" + newOrder + "&search={{ request('search') ?? '' }}&per_page={{ request('per_page', 15) }}";
    }

    // Image Modal
    function openImageModal(serialNumber, images) {
        const modal = document.getElementById('fileModal');
        const title = document.getElementById('modalTitle');
        const container = document.getElementById('fileContainer');

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
                img.style.borderRadius = '4px';
                container.appendChild(img);
            });
        }

        modal.style.display = 'flex';
    }

    // File Modal (for Vehicle Book)
    function showFileModal(fileUrl) {
        const modal = document.getElementById('fileModal');
        const title = document.getElementById('modalTitle');
        const container = document.getElementById('fileContainer');

        title.textContent = `Vehicle Letter`;
        container.innerHTML = '';

        const extension = fileUrl.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png'].includes(extension)) {
            const img = document.createElement('img');
            img.src = fileUrl;
            img.style.maxWidth = '200px';
            img.style.maxHeight = '200px';
            img.style.borderRadius = '4px';
            container.appendChild(img);
        } else if (['pdf', 'doc', 'docx'].includes(extension)) {
            const link = document.createElement('a');
            link.href = fileUrl;
            link.textContent = 'Download Vehicle Letter';
            link.style.fontSize = '14px';
            link.style.color = '#0077B6';
            link.style.textDecoration = 'underline';
            link.setAttribute('download', '');
            container.appendChild(link);
        }

        modal.style.display = 'flex';
    }

    function closeFileModal() {
        document.getElementById('fileModal').style.display = 'none';
    }
</script>
@endsection