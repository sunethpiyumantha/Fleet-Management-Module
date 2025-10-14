@extends('layouts.app')

@section('title', 'Reject Vehicle Request')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <a href="{{ route('vehicle-requests.approvals.index') }}" style="text-decoration: none; color: #0077B6;">Vehicle Requests</a> /
            <span style="font-weight: bold; color:#023E8A;">Reject Request</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Reject Vehicle Request
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

    <!-- Request Details -->
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #90E0EF;">
        <h6 style="color: #023E8A; margin-bottom: 10px;">Request Details</h6>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
            <div>
                <strong>Serial Number:</strong> {{ $vehicleRequestApproval->serial_number }}
            </div>
            <div>
                <strong>Type:</strong> {{ $vehicleRequestApproval->request_type_display }}
            </div>
            <div>
                <strong>Category:</strong> {{ $vehicleRequestApproval->category_name }}
            </div>
            <div>
                <strong>Sub Category:</strong> {{ $vehicleRequestApproval->sub_category_name }}
            </div>
            <div>
                <strong>Quantity:</strong> {{ $vehicleRequestApproval->quantity }}
            </div>
            <div>
                <strong>Initiated By:</strong> {{ $vehicleRequestApproval->initiated_user_name }}
            </div>
        </div>
    </div>

    <!-- Reject Form -->
    <form action="{{ route('vehicle-requests.approvals.reject', $vehicleRequestApproval->id) }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        @method('POST')
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 3; min-width: 400px;">
                <label for="notes" style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Rejection Reason</label>
                <textarea id="notes" name="notes" rows="4" placeholder="Enter rejection reason..." required
                          style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">{{ old('notes') }}</textarea>
                @error('notes')
                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end; gap: 10px;">
                <a href="{{ route('vehicle-requests.approvals.index') }}"
                   style="flex: 1; background-color: #6b7280; color: white; font-weight: 600; padding: 10px; border-radius: 5px; text-decoration: none; text-align: center; cursor: pointer;"
                   onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                    Cancel
                </a>
                <button type="submit" onclick="return confirm('Are you sure you want to reject this request?')"
                        style="flex: 1; background-color: #f12800; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer; text-align: center;"
                        onmouseover="this.style.backgroundColor='#c21000'" onmouseout="this.style.backgroundColor='#f12800'">
                    Reject Request
                </button>
            </div>
        </div>
    </form>

</div>
@endsection