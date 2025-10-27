@extends('layouts.app')

@section('title', 'Vehicle Request Summary')

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
    .status-reforwarded { background-color: #d1ecf1; color: #0c5460; }
</style>

<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background-color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <a href="{{ route('vehicle-requests.approvals.index') }}" style="text-decoration: none; color: #0077B6;">Vehicle Requests</a> /
            <span style="font-weight: bold; color:#023E8A;">Request Summary</span>
        </nav>
        <a href="{{ route('vehicle-requests.approvals.index') }}" style="background-color: #00B4D8; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;"
           onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">← Back to Requests</a>
    </div>

    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Vehicle Request Summary - {{ $vehicleRequestApproval->serial_number }}
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

    <!-- Request Summary Section -->
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h6 style="color: #023E8A; margin-bottom: 15px;">Request Details</h6>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; font-size: 14px;">
            <div>
                <strong>Serial Number:</strong> {{ $vehicleRequestApproval->serial_number }}
            </div>
            <div>
                <strong>Request Type:</strong> {{ $vehicleRequestApproval->request_type_display ?? ucfirst(str_replace('_', ' ', $vehicleRequestApproval->request_type)) }}
            </div>
            <div>
                <strong>Category:</strong> {{ $vehicleRequestApproval->category->category ?? 'N/A' }}
            </div>
            <div>
                <strong>Sub-Category:</strong> {{ $vehicleRequestApproval->subCategory->sub_category ?? 'N/A' }}
            </div>
            <div>
                <strong>Quantity:</strong> {{ $vehicleRequestApproval->quantity }}
            </div>
            <div>
                <strong>Status:</strong> {!! $vehicleRequestApproval->status_badge !!}
            </div>
            <div>
                <strong>Initiated By:</strong> {{ $vehicleRequestApproval->initiator->name ?? 'N/A' }} ({{ $vehicleRequestApproval->initiateEstablishment->e_name ?? 'N/A' }})
            </div>
            <div>
                <strong>Current Assignee:</strong> {{ $vehicleRequestApproval->currentUser->name ?? 'N/A' }} ({{ $vehicleRequestApproval->currentEstablishment->e_name ?? 'N/A' }})
            </div>
            <div>
                <strong>Created At:</strong> {{ $vehicleRequestApproval->created_at->format('Y-m-d H:i') }}
            </div>
            @if($vehicleRequestApproval->vehicle_letter)
            <div>
                <strong>Reference Letter:</strong> 
                <a href="{{ asset('storage/' . $vehicleRequestApproval->vehicle_letter) }}" target="_blank" style="color: #0077B6;">View PDF/JPG</a>
            </div>
            @endif
            @if($vehicleRequestApproval->forward_reason)
            <div>
                <strong>Last Action Remark:</strong> {{ $vehicleRequestApproval->forward_reason }}
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
</div>
@endsection