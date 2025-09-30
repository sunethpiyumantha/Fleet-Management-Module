@extends('layouts.app')

@section('title', 'Edit Vehicle Request')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    .badge {
        padding: 0.25em 0.5em;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .bg-warning {
        background-color: #ADE8F4 !important;
        color: #023E8A !important;
    }
    .bg-success {
        background-color: #00B4D8 !important;
        color: white !important;
    }
    .bg-danger {
        background-color: #dc2626 !important;
        color: white !important;
    }
    .bg-secondary {
        background-color: #6b7280 !important;
        color: white !important;
    }
    .text-dark {
        color: #03045E !important;
    }
</style>

<div style="width: 100%; max-width: 64rem; padding: 8px; font-family: Arial, sans-serif; background-color: white; margin: 0 auto;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <a href="{{ route('vehicle-requests.approvals.index') }}" style="text-decoration: none; color: #0077B6;">Vehicle Requests</a> /
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
            <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Vehicle Request Form -->
    <div style="border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background-color: #f9fafb;">
        <form method="POST" action="{{ route('vehicle-requests.approvals.update', $vehicleRequestApproval->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="request_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Request Type</label>
                        <select id="request_type" name="request_type" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('request_type') border-color: #dc2626; @enderror">
                            <option value="replacement" {{ $vehicleRequestApproval->request_type == 'replacement' ? 'selected' : '' }}>Vehicle Replacement</option>
                            <option value="new_approval" {{ $vehicleRequestApproval->request_type == 'new_approval' ? 'selected' : '' }}>Taking Over a Vehicle Based on a New Approval</option>
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
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $vehicleRequestApproval->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category }} ({{ $category->serial_number }})
                                </option>
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
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ $vehicleRequestApproval->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->sub_category }} ({{ $subCategory->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('sub_cat_id')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="required_quantity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" value="{{ $vehicleRequestApproval->quantity }}" required
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('qty') border-color: #dc2626; @enderror">
                        @error('qty')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Status</label>
                        <select id="status" name="status" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('status') border-color: #dc2626; @enderror">
                            <option value="pending" {{ $vehicleRequestApproval->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $vehicleRequestApproval->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $vehicleRequestApproval->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_book" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Refference Letter (Leave empty to keep current)</label>
                        <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('vehicle_book') border-color: #dc2626; @enderror">
                        @if($vehicleRequestApproval->vehicle_letter)
                            <a href="{{ Storage::url($vehicleRequestApproval->vehicle_letter) }}" target="_blank" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Letter</a>
                        @endif
                        @error('vehicle_book')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div style="width: 100%; max-width: 900px;">
                    <label for="notes" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Notes</label>
                    <textarea id="notes" name="notes" rows="3" 
                              style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; @error('notes') border-color: #dc2626; @enderror">{{ $vehicleRequestApproval->notes }}</textarea>
                    @error('notes')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="width: 100%; display: flex; justify-content: center; gap: 1rem;">
                    <a href="{{ route('vehicle-requests.approvals.index') }}"
                       style="background-color: #6b7280; color: white; font-weight: 600; padding: 8px 16px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; text-align: center;"
                       onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fa-solid fa-arrow-left" style="margin-right: 0.25rem;"></i> Cancel
                    </a>
                    <button type="submit"
                            style="background-color: #00B4D8; color: white; font-weight: 600; padding: 8px 16px; border-radius: 5px; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                        <i class="fa-solid fa-save" style="margin-right: 0.25rem;"></i> Update
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
                option.textContent = `${subCat.sub_category} (${subCat.serial_number})`;
                if (subCat.id == '{{ $vehicleRequestApproval->sub_category_id }}') {
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
</script>
@endsection