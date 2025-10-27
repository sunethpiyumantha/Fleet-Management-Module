@extends('layouts.app')

@section('title', 'Vehicle Request Details')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    .history-table tbody tr:hover {
        background-color: #f1f1f1;
    }
    .status-badge {
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 0.75rem;
        font-weight: bold;
    }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-approved { background-color: #d4edda; color: #155724; }
    .status-rejected { background-color: #f8d7da; color: #721c24; }
    .status-forwarded { background-color: #d1ecf1; color: #0c5460; }
    .status-sent { background-color: #d1ecf1; color: #0c5460; }
    .status-reforwarded { background-color: #d1ecf1; color: #0c5460; }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <a href="{{ route('vehicle-requests.approvals.index') }}" style="text-decoration: none; color: #0077B6;">Vehicle Requests</a> /
            <span style="font-weight: bold; color:#023E8A;">Request Details</span>
        </nav>
        <a href="{{ route('vehicle-requests.approvals.index') }}" style="background-color: #00B4D8; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;"
           onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">← Back to Requests</a>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Request Details - {{ $vehicleRequestApproval->serial_number }}
        </h5>
    </div>

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
                <p>{{ $vehicleRequestApproval->initiator->name ?? 'N/A' }} ({{ $vehicleRequestApproval->initiateEstablishment->e_name ?? 'N/A' }})</p>
            </div>
            <div>
                <label style="font-weight: bold; color: #023E8A;">Current User:</label>
                <p>{{ $vehicleRequestApproval->currentUser->name ?? 'N/A' }} ({{ $vehicleRequestApproval->currentEstablishment->e_name ?? 'N/A' }})</p>
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

    <!-- History Section -->
    <div style="margin-bottom: 20px;">
        <h6 style="color: #023E8A; margin-bottom: 10px;">Request History</h6>
        @if($vehicleRequestApproval->requestProcesses->isEmpty())
            <p style="color: #6c757d; font-style: italic;">No history entries yet. This is a new request.</p>
        @else
            <div style="overflow-x: auto;">
                <table class="history-table" style="width: 100%; border-collapse: collapse; border: 1px solid #90E0EF;">
                    <thead style="background-color: #0077B6; color: white;">
                        <tr>
                            <th style="border: 1px solid #90E0EF; padding: 8px;">Date & Time</th>
                            <th style="border: 1px solid #90E0EF; padding: 8px;">Action</th>
                            <th style="border: 1px solid #90E0EF; padding: 8px;">From (User / Est.)</th>
                            <th style="border: 1px solid #90E0EF; padding: 8px;">To (User / Est.)</th>
                            <th style="border: 1px solid #90E0EF; padding: 8px;">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicleRequestApproval->requestProcesses as $process)
                            <tr>
                                <td style="border: 1px solid #90E0EF; padding: 8px;">
                                    {{ $process->processed_at->format('Y-m-d H:i') }}
                                </td>
                                <td style="border: 1px solid #90E0EF; padding: 8px;">
                                    <span class="status-badge status-{{ $process->status }}">
                                        {{ $processStatuses[$process->status] ?? ucfirst($process->status) }}
                                    </span>
                                </td>
                                <td style="border: 1px solid #90E0EF; padding: 8px;">
                                    {{ $process->fromUser->name ?? 'N/A' }}<br>
                                    <small style="color: #6c757d;">{{ $process->fromEstablishment->e_name ?? 'N/A' }}</small>
                                </td>
                                <td style="border: 1px solid #90E0EF; padding: 8px;">
                                    {{ $process->toUser->name ?? 'N/A' }}<br>
                                    <small style="color: #6c757d;">{{ $process->toEstablishment->e_name ?? 'N/A' }}</small>
                                </td>
                                <td style="border: 1px solid #90E0EF; padding: 8px;">
                                    {{ $process->remark ?: 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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

    </div>
</div>
@endsection