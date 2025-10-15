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
    .status-disabled {
        background-color: #f3f4f6 !important;
        color: #6b7280 !important;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

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
    @can('Request Edit (own)', $vehicleRequestApproval)
    <form action="{{ route('vehicle-requests.approvals.update', $vehicleRequestApproval->id) }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
        @csrf
        @method('PUT')
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 1; min-width: 220px;">
                <label for="request_type" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Request Type</label>
                <select id="request_type" name="request_type" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="replacement" {{ old('request_type', $vehicleRequestApproval->request_type) == 'replacement' ? 'selected' : '' }}>Vehicle Replacement</option>
                    <option value="new_approval" {{ old('request_type', $vehicleRequestApproval->request_type) == 'new_approval' ? 'selected' : '' }}>Taking Over a Vehicle Based on a New Approval</option>
                </select>
                @error('request_type')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Category</label>
                <select id="cat_id" name="cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('cat_id', $vehicleRequestApproval->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
                @error('cat_id')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="sub_cat_id" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Vehicle Sub Category</label>
                <select id="sub_cat_id" name="sub_cat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                    <option value="" disabled>Select Sub-Category</option>
                    @foreach($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}" {{ old('sub_cat_id', $vehicleRequestApproval->sub_category_id) == $subCategory->id ? 'selected' : '' }}>
                            {{ $subCategory->sub_category }}
                        </option>
                    @endforeach
                </select>
                @error('sub_cat_id')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="qty" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Required Quantity</label>
                <input type="number" id="qty" name="qty" min="1" value="{{ old('qty', $vehicleRequestApproval->quantity) }}" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                @error('qty')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="status" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Status</label>
                @if(auth()->user()->role && auth()->user()->role->name === 'Fleet Operator')
                    <input type="hidden" name="status" value="{{ $vehicleRequestApproval->status }}">
                    <select id="status" disabled
                            style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E; background-color: #f3f4f6;">
                        <option value="pending" {{ $vehicleRequestApproval->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $vehicleRequestApproval->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $vehicleRequestApproval->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                @else
                    <select id="status" name="status" required
                            style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                        <option value="pending" {{ old('status', $vehicleRequestApproval->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $vehicleRequestApproval->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $vehicleRequestApproval->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                @endif
                @error('status')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <div style="flex: 1; min-width: 220px;">
                <label for="vehicle_book" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Reference Letter (Leave empty to keep current)</label>
                <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.jpg" 
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                @if($vehicleRequestApproval->vehicle_letter)
                    <a href="{{ Storage::url($vehicleRequestApproval->vehicle_letter) }}" target="_blank" style="color: #0077B6; font-size: 12px; margin-top: 4px; display: block;">View Current Letter</a>
                @endif
                @error('vehicle_book')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end; gap: 10px;">
                <a href="{{ route('vehicle-requests.approvals.index') }}"
                   style="flex: 1; background-color: #6b7280; color: white; font-weight: 600; padding: 10px; border-radius: 5px; text-decoration: none; text-align: center; cursor: pointer;"
                   onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                    Cancel
                </a>
                <button type="submit"
                        style="flex: 1; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer; text-align: center;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    Update
                </button>
            </div>
        </div>
    </form>
    @endcan

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

        fetch(`/get-sub-categories/${catId}`)
            .then(response => response.json())
            .then(data => {
                subCatSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
                data.forEach(subCat => {
                    const option = document.createElement('option');
                    option.value = subCat.id;
                    option.textContent = `${subCat.sub_category} (${subCat.serial_number})`;
                    if (option.value == '{{ old("sub_cat_id", $vehicleRequestApproval->sub_category_id) }}') {
                        option.selected = true;
                    }
                    subCatSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                subCatSelect.innerHTML = '<option value="" disabled selected>Error loading sub-categories</option>';
            });
    });

    // Trigger on load
    document.getElementById('cat_id').dispatchEvent(new Event('change'));
</script>
@endsection