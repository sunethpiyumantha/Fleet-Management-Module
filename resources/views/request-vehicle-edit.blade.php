@extends('layouts.app')

@section('title', 'Edit Vehicle Request')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Edit Vehicle Request</h2>

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

        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" action="{{ route('vehicle.request.update', $vehicle->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <!-- First Line: Request Type, Category, Sub-Category -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="request_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Request Type</label>
                        <select id="request_type" name="request_type" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('request_type') border-color: #b91c1c; @enderror">
                            <option value="" disabled>Select Request Type</option>
                            <option value="replacement" {{ old('request_type', $vehicle->request_type) == 'replacement' ? 'selected' : '' }}>Vehicle replacement</option>
                            <option value="new_approval" {{ old('request_type', $vehicle->request_type) == 'new_approval' ? 'selected' : '' }}>Taking over a vehicle based on a new approval</option>
                        </select>
                        @error('request_type')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                        <select id="cat_id" name="cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('cat_id') border-color: #b91c1c; @enderror">
                            <option value="" disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('cat_id', $vehicle->cat_id) == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                        @error('cat_id')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                        <select id="sub_cat_id" name="sub_cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('sub_cat_id') border-color: #b91c1c; @enderror">
                            <option value="" disabled>Select Sub-Category</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ old('sub_cat_id', $vehicle->sub_cat_id) == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->sub_category }}</option>
                            @endforeach
                        </select>
                        @error('sub_cat_id')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Second Line: Quantity, Vehicle Book, Image 01 -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" value="{{ old('qty', $vehicle->qty) }}" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('qty') border-color: #b91c1c; @enderror">
                        @error('qty')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="vehicle_book" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Book (Current: {{ $vehicle->vehicle_book_path ? basename($vehicle->vehicle_book_path) : 'None' }})</label>
                        <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('vehicle_book') border-color: #b91c1c; @enderror">
                        @if($vehicle->vehicle_book_path)
                            <a href="{{ Storage::url($vehicle->vehicle_book_path) }}" target="_blank" style="color: #f97316; font-size: 0.75rem; margin-top: 0.25rem; display: block;">View Current</a>
                        @endif
                        @error('vehicle_book')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="image_01" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 01 (Current: {{ $vehicle->image_01_path ? basename($vehicle->image_01_path) : 'None' }})</label>
                        <input type="file" id="image_01" name="image_01" accept=".jpg,.png"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('image_01') border-color: #b91c1c; @enderror">
                        @if($vehicle->image_01_path)
                            <a href="javascript:void(0)" onclick="openImageModal('Image 01', '{{ Storage::url($vehicle->image_01_path) }}')" style="color: #f97316; font-size: 0.75rem; margin-top: 0.25rem; display: block;">View Current</a>
                        @endif
                        @error('image_01')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Third Line: Images 02, 03, 04 -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="image_02" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 02 (Current: {{ $vehicle->image_02_path ? basename($vehicle->image_02_path) : 'None' }})</label>
                        <input type="file" id="image_02" name="image_02" accept=".jpg,.png"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('image_02') border-color: #b91c1c; @enderror">
                        @if($vehicle->image_02_path)
                            <a href="javascript:void(0)" onclick="openImageModal('Image 02', '{{ Storage::url($vehicle->image_02_path) }}')" style="color: #f97316; font-size: 0.75rem; margin-top: 0.25rem; display: block;">View Current</a>
                        @endif
                        @error('image_02')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="image_03" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 03 (Current: {{ $vehicle->image_03_path ? basename($vehicle->image_03_path) : 'None' }})</label>
                        <input type="file" id="image_03" name="image_03" accept=".jpg,.png"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('image_03') border-color: #b91c1c; @enderror">
                        @if($vehicle->image_03_path)
                            <a href="javascript:void(0)" onclick="openImageModal('Image 03', '{{ Storage::url($vehicle->image_03_path) }}')" style="color: #f97316; font-size: 0.75rem; margin-top: 0.25rem; display: block;">View Current</a>
                        @endif
                        @error('image_03')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="image_04" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image 04 (Current: {{ $vehicle->image_04_path ? basename($vehicle->image_04_path) : 'None' }})</label>
                        <input type="file" id="image_04" name="image_04" accept=".jpg,.png"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('image_04') border-color: #b91c1c; @enderror">
                        @if($vehicle->image_04_path)
                            <a href="javascript:void(0)" onclick="openImageModal('Image 04', '{{ Storage::url($vehicle->image_04_path) }}')" style="color: #f97316; font-size: 0.75rem; margin-top: 0.25rem; display: block;">View Current</a>
                        @endif
                        @error('image_04')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Fourth Line: Date Submit and Status -->
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="date_submit" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Date Submitted</label>
                        <input type="date" id="date_submit" name="date_submit" value="{{ old('date_submit', $vehicle->date_submit) }}"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('date_submit') border-color: #b91c1c; @enderror">
                        @error('date_submit')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="status" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Status</label>
                        <select id="status" name="status"
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; @error('status') border-color: #b91c1c; @enderror">
                            <option value="pending" {{ old('status', $vehicle->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $vehicle->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $vehicle->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <span style="color: #b91c1c; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Image Preview Modal -->
                <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
                    <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; max-width: 90%; max-height: 90%; overflow: auto;">
                        <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Vehicle Image</h3>
                        <div id="imageContainer" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                            <img id="modalImage" style="max-width: 400px; max-height: 400px; border-radius: 0.25rem;" src="" alt="Vehicle Image">
                        </div>
                        <button onclick="closeImageModal()" style="margin-top: 1rem; background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                                onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                            Close
                        </button>
                    </div>
                </div>

                <div style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Update
                    </button>
                </div>
            </div>
        </form>
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

<style>
    /* Ensure modal images are responsive */
    #imageContainer img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }
</style>
@endsection