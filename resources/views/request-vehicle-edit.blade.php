@extends('layouts.app')

@section('title', 'Edit Vehicle Request')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; max-width: 64rem; padding: 8px; font-family: Arial, sans-serif; background-color: white; margin: 0 auto;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <a href="{{ route('vehicle.request.index') }}" style="text-decoration: none; color: #0077B6;">Vehicle Requests</a> /
            <span style="font-weight: bold; color: #023E8A;">Edit Vehicle Request</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Edit Vehicle Request
        </h5>
    </div>

    <!-- Success or Error Messages -->
    @if (session('success'))
        <div style="background-color: #ADE8F4; color: #023E8A; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #caf0f8; color: #03045E; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Vehicle Request Form -->
    <form action="{{ route('vehicle.request.update', $vehicle->id) }}" method="POST" style="margin-bottom: 20px;" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <div style="flex: 1; min-width: 220px;">
                <label for="request_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Request Type</label>
                <select id="request_type" name="request_type" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('request_type') border-color: #dc2626; @enderror">
                    <option value="" disabled>Select Request Type</option>
                    <option value="replacement" {{ old('request_type', $vehicle->request_type) == 'replacement' ? 'selected' : '' }}>Vehicle Replacement</option>
                    <option value="new_approval" {{ old('request_type', $vehicle->request_type) == 'new_approval' ? 'selected' : '' }}>Taking Over a Vehicle Based on a New Approval</option>
                </select>
                @error('request_type')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Category</label>
                <select id="cat_id" name="cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('cat_id') border-color: #dc2626; @enderror">
                    <option value="" disabled>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('cat_id', $vehicle->cat_id) == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                    @endforeach
                </select>
                @error('cat_id')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="sub_cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Sub Category</label>
                <select id="sub_cat_id" name="sub_cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('sub_cat_id') border-color: #dc2626; @enderror">
                    <option value="" disabled>Select Sub-Category</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}" {{ old('sub_cat_id', $vehicle->sub_cat_id) == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->sub_category }}</option>
                    @endforeach
                </select>
                @error('sub_cat_id')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="required_quantity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Required Quantity</label>
                <input type="number" id="required_quantity" name="qty" min="1" value="{{ old('qty', $vehicle->qty) }}" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('qty') border-color: #dc2626; @enderror">
                @error('qty')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="vehicle_book" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Letter</label>
                <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('vehicle_book') border-color: #dc2626; @enderror">
                @if($vehicle->vehicle_book_path)
                    <a href="{{ Storage::url($vehicle->vehicle_book_path) }}" target="_blank" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Letter</a>
                @endif
                @error('vehicle_book')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_01" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Front View</label>
                <input type="file" id="image_01" name="image_01" accept=".jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('image_01') border-color: #dc2626; @enderror">
                @if($vehicle->image_01_path)
                    <a href="javascript:void(0)" onclick="openImageModal('Front View', '{{ Storage::url($vehicle->image_01_path) }}')" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Image</a>
                @endif
                @error('image_01')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_02" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Rear View</label>
                <input type="file" id="image_02" name="image_02" accept=".jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('image_02') border-color: #dc2626; @enderror">
                @if($vehicle->image_02_path)
                    <a href="javascript:void(0)" onclick="openImageModal('Rear View', '{{ Storage::url($vehicle->image_02_path) }}')" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Image</a>
                @endif
                @error('image_02')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_03" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Side View 1</label>
                <input type="file" id="image_03" name="image_03" accept=".jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('image_03') border-color: #dc2626; @enderror">
                @if($vehicle->image_03_path)
                    <a href="javascript:void(0)" onclick="openImageModal('Side View 1', '{{ Storage::url($vehicle->image_03_path) }}')" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Image</a>
                @endif
                @error('image_03')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="image_04" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Side View 2</label>
                <input type="file" id="image_04" name="image_04" accept=".jpg,.png"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('image_04') border-color: #dc2626; @enderror">
                @if($vehicle->image_04_path)
                    <a href="javascript:void(0)" onclick="openImageModal('Side View 2', '{{ Storage::url($vehicle->image_04_path) }}')" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Image</a>
                @endif
                @error('image_04')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="date_submit" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Date Submitted</label>
                <input type="date" id="date_submit" name="date_submit" value="{{ old('date_submit', $vehicle->date_submit) }}"
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('date_submit') border-color: #dc2626; @enderror">
                @error('date_submit')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Status</label>
                <select id="status" name="status"
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('status') border-color: #dc2626; @enderror">
                    <option value="pending" {{ old('status', $vehicle->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $vehicle->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('status', $vehicle->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end; justify-content:center;">
                <button type="submit"
                        style="width: 20%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    Update
                </button>
            </div>
    </form>

    <!-- Image Preview Modal -->
    <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
        <div style="background: white; padding: 24px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow: auto;">
            <h3 id="modalTitle" style="font-size: 20px; font-weight: bold; margin-bottom: 16px;">Vehicle Image</h3>
            <div id="imageContainer" style="display: flex; flex-wrap: wrap; gap: 16px;">
                <img id="modalImage" style="max-width: 200px; max-height: 200px; border-radius: 4px;" src="" alt="Vehicle Image">
            </div>
            <button onclick="closeImageModal()"
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
        subCatSelect.innerHTML = '<option value="" disabled selected>Loading Sub-Categories...</option>';

        if (!catId) {
            subCatSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
            return;
        }

        fetch(`/get-sub-categories/${catId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            subCatSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
            data.forEach(subCat => {
                const option = document.createElement('option');
                option.value = subCat.id;
                option.textContent = subCat.sub_category;
                if (subCat.id == '{{ old('sub_cat_id', $vehicle->sub_cat_id) }}') {
                    option.selected = true;
                }
                subCatSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching sub-categories:', error);
            subCatSelect.innerHTML = '<option value="" disabled selected>Error loading sub-categories</option>';
        });
    });

    // Trigger change event to load sub-categories on page load
    document.getElementById('cat_id').dispatchEvent(new Event('change'));

    // Image Modal
    function openImageModal(title, src) {
        const modal = document.getElementById('imageModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalImage = document.getElementById('modalImage');

        modalTitle.textContent = title;
        modalImage.src = src;
        modal.style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }
</script>
@endsection