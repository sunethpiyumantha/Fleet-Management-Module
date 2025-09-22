@extends('layouts.app')

@section('title', 'Vehicle Request Management 2')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Request Management 2</h2>

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

        <!-- Form -->
        <form class="mb-8" method="POST" action="{{ route('vehicle-requests.approvals.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="request_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Request Type</label>
                        <select id="request_type" name="request_type" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled {{ old('request_type') ? '' : 'selected' }}>Select Request Type</option>
                            <option value="replacement" {{ old('request_type') == 'replacement' ? 'selected' : '' }}>Vehicle replacement</option>
                            <option value="new_approval" {{ old('request_type') == 'new_approval' ? 'selected' : '' }}>Taking over a vehicle based on a new approval</option>
                        </select>
                        @error('request_type')
                            <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                        <select id="cat_id" name="cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled {{ old('cat_id') ? '' : 'selected' }}>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category }} ({{ $category->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('cat_id')
                            <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="sub_cat_id" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                        <select id="sub_cat_id" name="sub_cat_id" required
                                style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                            <option value="" disabled {{ old('sub_cat_id') ? '' : 'selected' }}>Select Sub-Category</option>
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ old('sub_cat_id') == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->sub_category }} ({{ $subCategory->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('sub_cat_id')
                            <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1 1 250px;">
                        <label for="required_quantity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Required Quantity</label>
                        <input type="number" id="required_quantity" name="qty" min="1" value="{{ old('qty', 1) }}" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        @error('qty')
                            <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1 1 250px;">
                        <label for="vehicle_book" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Letter</label>
                        <input type="file" id="vehicle_book" name="vehicle_book" accept=".pdf,.doc,.docx,.jpg,.png" required
                               style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        @error('vehicle_book')
                            <span style="color: #dc2626; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
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
        <form method="GET" action="{{ route('vehicle-requests.approvals.index') }}" style="margin-bottom: 1.5rem;">
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
                    <th style="padding: 0.75rem; cursor: pointer;">Serial Number ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Request Type ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Vehicle Category ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Sub Category ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Quantity ▲▼</th>
                    <th style="padding: 0.75rem; cursor: pointer;">Status ▲▼</th>
                    <th style="padding: 0.75rem;">Vehicle Letter</th>
                    <th style="padding: 0.75rem; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($approvals as $approval)
                <tr>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $approval->serial_number }}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $approval->request_type_display }}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                        {{ $approval->category ? $approval->category->category . ' (' . $approval->category->serial_number . ')' : 'N/A' }}
                    </td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                        {{ $approval->subCategory ? $approval->subCategory->sub_category . ' (' . $approval->subCategory->serial_number . ')' : 'N/A' }}
                    </td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{{ $approval->quantity }}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6;">{!! $approval->status_badge !!}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #f3f4f6; text-align: center;">
                        @if($approval->vehicle_letter)
                            <button onclick="viewFile('{{ $approval->vehicle_letter }}', '{{ $approval->serial_number }}')" 
                                    style="background-color: #16a34a; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                                <i class="fa-solid fa-image"></i> View
                            </button>
                        @else
                            <span style="color: #9ca3af; font-size: 0.75rem;">No file</span>
                        @endif
                    </td>
                    <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6;">
                        <div style="display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap;">
                            <a href="{{ route('vehicle-requests.approvals.edit', $approval->id) }}" 
                               style="background-color: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: background-color 0.2s ease, transform 0.1s ease; cursor: pointer;"
                               onmouseover="this.style.backgroundColor='#13893b'; this.style.transform='scale(1.05)'"
                               onmouseout="this.style.backgroundColor='#16a34a'; this.style.transform='scale(1)'">
                                Update
                            </a>
                            <form action="{{ route('vehicle-requests.approvals.destroy', $approval->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background-color: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; font-size: 0.875rem; font-weight: 500; transition: background-color 0.2s ease, transform 0.1s ease; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'; this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.backgroundColor='#dc2626'; this.style.transform='scale(1)'">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #f3f4f6; color: #6b7280;">No vehicle requests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($approvals->hasPages())
        <div style="margin-top: 1rem;">
            <nav style="display: flex; justify-content: center; gap: 0.5rem;">
                {{ $approvals->appends(request()->query())->links() }}
            </nav>
        </div>
        @endif
    </div>
</div>

<!-- File Modal -->
<div id="fileModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
    <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; max-width: 90%; max-height: 90%; overflow: auto;">
        <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Vehicle File</h3>
        <div id="fileContainer" style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
            <!-- File content will be loaded here -->
        </div>
        <div style="text-align: center; margin-top: 1rem;">
            <button onclick="closeModal()" style="background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function viewFile(filePath, serialNumber) {
    const modal = document.getElementById('fileModal');
    const title = document.getElementById('modalTitle');
    const container = document.getElementById('fileContainer');
    
    title.textContent = `Vehicle Letter - ${serialNumber}`;
    
    // Check file extension to determine how to display
    const extension = filePath.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension);
    const isPdf = extension === 'pdf';
    
    if (isImage) {
        container.innerHTML = `<img src="{{ asset('storage') }}/${filePath}" style="max-width: 100%; max-height: 70vh; border-radius: 0.25rem;" />`;
    } else if (isPdf) {
        container.innerHTML = `
            <iframe src="{{ asset('storage') }}/${filePath}" 
                    style="width: 100%; height: 70vh; border: none; border-radius: 0.25rem;" 
                    frameborder="0"></iframe>
        `;
    } else {
        container.innerHTML = `
            <div style="text-align: center; padding: 2rem;">
                <i class="fa-solid fa-file" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                <p style="color: #6b7280;">${filePath}</p>
                <a href="{{ asset('storage') }}/${filePath}" target="_blank" 
                   style="background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; display: inline-block; margin-top: 1rem;"
                   onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                    Download File
                </a>
            </div>
        `;
    }
    
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('fileModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('fileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

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