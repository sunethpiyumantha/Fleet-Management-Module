@extends('layouts.app')

@section('title', 'Edit Vehicle Request')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Edit Vehicle Request</h2>

        <!-- Success Message -->
        @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: block;">
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: block;">
            <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('vehicle-requests.approvals.update', $vehicleRequestApproval->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="request_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Request Type</label>
                        <select id="request_type" name="request_type" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="replacement" {{ $vehicleRequestApproval->request_type == 'replacement' ? 'selected' : '' }}>Vehicle replacement</option>
                            <option value="new_approval" {{ $vehicleRequestApproval->request_type == 'new_approval' ? 'selected' : '' }}>Taking over a vehicle based on a new approval</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                        <select id="cat_id" name="cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $vehicleRequestApproval->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category }} ({{ $category->serial_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                        <select id="sub_cat_id" name="sub_cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled>Select Sub-Category</option>
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ $vehicleRequestApproval->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->sub_category }} ({{ $subCategory->serial_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" value="{{ $vehicleRequestApproval->quantity }}" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="status" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Status</label>
                        <select id="status" name="status" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="pending" {{ $vehicleRequestApproval->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $vehicleRequestApproval->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $vehicleRequestApproval->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="vehicle_book" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Letter (Leave empty to keep current)</label>
                        <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png"
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        @if($vehicleRequestApproval->vehicle_letter)
                            <small style="color: #6b7280; display: block; margin-top: 0.25rem;">Current file: {{ basename($vehicleRequestApproval->vehicle_letter) }}</small>
                        @endif
                    </div>
                </div>
                <div style="width: 100%; max-width: 900px;">
                    <label for="notes" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Notes</label>
                    <textarea id="notes" name="notes" rows="3" 
                              style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">{{ $vehicleRequestApproval->notes }}</textarea>
                </div>
                <div style="width: 100%; display: flex; justify-content: center; gap: 1rem;">
                    <a href="{{ route('vehicle-requests.approvals.index') }}"
                       style="background-color: #6b7280; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; text-decoration: none; text-align: center;"
                       onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fa-solid fa-arrow-left" style="margin-right: 0.25rem;"></i> Cancel
                    </a>
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-save" style="margin-right: 0.25rem;"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.badge {
    padding: 0.25em 0.5em;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.bg-warning {
    background-color: #f59e0b !important;
}

.bg-success {
    background-color: #10b981 !important;
}

.bg-danger {
    background-color: #ef4444 !important;
}

.bg-secondary {
    background-color: #6b7280 !important;
}

.text-dark {
    color: #000000 !important;
}
</style>
@endsection