@extends('layouts.app')

@section('title', 'View Vehicle Request')

@section('content')
<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('vehicle-requests.approvals.index') }}" style="text-decoration: none; color: #0077B6;">Back to Requests</a> /
            <span style="font-weight: bold; color:#023E8A;">View Request Details</span>
        </nav>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Request Details - {{ $vehicleRequestApproval->serial_number }}
        </h5>
    </div>

    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            <div>
                <label style="font-weight: bold; color: #023E8A;">Request Type:</label>
                <p>{{ $vehicleRequestApproval->request_type_display ?? $vehicleRequestApproval->request_type }}</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Category:</label>
                <p>{{ $vehicleRequestApproval->category->category ?? 'N/A' }}</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Sub-Category:</label>
                <p>{{ $vehicleRequestApproval->subCategory->sub_category ?? 'N/A' }}</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Quantity:</label>
                <p>{{ $vehicleRequestApproval->quantity }}</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Status:</label>
                <p>{!! $vehicleRequestApproval->status_badge !!}</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Created At:</label>
                <p>{{ $vehicleRequestApproval->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Initiated By:</label>
                <p>{{ $vehicleRequestApproval->initiated_user_name ?? 'N/A' }} ({{ $vehicleRequestApproval->initiate_establishment_name ?? 'N/A' }})</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Current User:</label>
                <p>{{ $vehicleRequestApproval->current_user_name ?? 'N/A' }} ({{ $vehicleRequestApproval->current_establishment_name ?? 'N/A' }})</p>
            </div>
            @if($vehicleRequestApproval->notes)
            <div style="grid-column: 1 / -1;">
                <label style="font-weight: bold; color: #023E8A;">Notes:</label>
                <p style="white-space: pre-wrap;">{{ $vehicleRequestApproval->notes }}</p>
            </div>
            @endif
            @if($vehicleRequestApproval->vehicle_letter)
            <div style="grid-column: 1 / -1;">
                <label style="font-weight: bold; color: #023E8A;">Reference Letter:</label>
                <p>
                    <a href="{{ asset('storage/' . $vehicleRequestApproval->vehicle_letter) }}" target="_blank" style="color: #0077B6; text-decoration: none;">View Document</a>
                </p>
            </div>
            @endif
            @if($vehicleRequestApproval->forward_reason)
            <div style="grid-column: 1 / -1;">
                <label style="font-weight: bold; color: #023E8A;">Forward Reason:</label>
                <p>{{ $vehicleRequestApproval->forward_reason }}</p>
            </div>
            @endif
        </div>
    </div>

    <div style="display: flex; gap: 10px; justify-content: flex-end;">
        @php
            $userRole = $userRole ?? Auth::user()->role->name ?? '';
            $canForward = in_array($userRole, ['Fleet Operator', 'Establishment Head', 'Request Handler', 'Establishment Admin']) && 
                          (($userRole === 'Fleet Operator' && in_array($vehicleRequestApproval->status, ['pending', 'rejected', 'sent'])) || 
                           in_array($userRole, ['Establishment Head', 'Request Handler', 'Establishment Admin']) && in_array($vehicleRequestApproval->status, ['forwarded', 'sent']));
            $canReject = in_array($userRole, ['Establishment Head', 'Request Handler', 'Establishment Admin']) && in_array($vehicleRequestApproval->status, ['forwarded', 'sent']);
        @endphp

        @if($canForward)
            <a href="{{ route('forward', ['req_id' => $vehicleRequestApproval->serial_number]) }}"
               style="background-color: #0077B6; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600;"
               onmouseover="this.style.backgroundColor='#005A87'" onmouseout="this.style.backgroundColor='#0077B6'">
                Forward Request
            </a>
        @endif

        @if($canReject)
            <a href="{{ route('vehicle-requests.approvals.reject-form', $vehicleRequestApproval->id) }}"
               style="background-color: #f12800; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600;"
               onmouseover="this.style.backgroundColor='#c21000'" onmouseout="this.style.backgroundColor='#f12800'">
                Reject Request
            </a>
        @endif

        <a href="{{ route('vehicle-requests.approvals.index') }}"
           style="background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600;"
           onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
            Back to List
        </a>
    </div>
</div>
@endsection