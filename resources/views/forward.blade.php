@extends('layouts.app')

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
            <span style="font-weight: bold; color:#023E8A;">Forward</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Forward
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

    @if (session('error'))
        <div style="background-color: #caf0f8; color: #03045E; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add Vehicle Request Form -->
    <form action="{{ route('forward.generic') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <input type="hidden" name="req_id" value="{{ $req_id }}">
        
        @php
            $user = Auth::user();
            $isEstablishmentHead = $user->role && $user->role->name === 'Establishment Head';
            $isDSTHead = $isEstablishmentHead && $user->establishment_id == 1094;
        @endphp
        
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            @if($isEstablishmentHead)
                @if($isDSTHead)
                    <!-- Custom fields for DST Head -->
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">
                            Select Action
                        </label>
                        <select name="action" id="actionSelect" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                            <option value="">Select Action</option>
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                        </select>
                    </div>

                    <div id="vehicleTypeSection" style="flex: 1; min-width: 220px; display: none;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">
                            Select Vehicle Type
                        </label>
                        <select name="vehicle_type" id="vehicleTypeSelect"
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                            <option value="army">Army Vehicle</option>
                            <option value="hired">Authority to Hire Vehicle</option>
                        </select>
                    </div>

                    <!-- UPDATED: Army Vehicle Army No Dropdown (hidden initially) -->
                    <div id="armyVehicleSection" style="flex: 1; min-width: 220px; display: none;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">
                            Select Vehicle Army No
                        </label>
                        <select name="army_vehicle_id" id="armyVehicleSelect" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                            <option value="">First select Army Vehicle type</option>
                        </select>
                        <div id="armyVehicleLoading" style="display: none; font-size: 12px; color: #0077B6; margin-top: 4px;">
                            Loading army numbers...
                        </div>
                        <div id="noArmyVehiclesMessage" style="display: none; font-size: 12px; color: #dc2626; margin-top: 4px;">
                            No army numbers found. Please check the database.
                        </div>
                    </div>
                @else
                    <!-- Existing fields for other Establishment Heads -->
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">
                            Select Target Establishment
                        </label>
                        <select name="forward_to_establishment" id="establishmentSelect" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                            <option value="">Select Establishment</option>
                            @foreach($establishments as $establishment)
                                @if($establishment->e_id != Auth::user()->establishment_id)
                                    <option value="{{ $establishment->e_id }}">
                                        {{ $establishment->e_name }} ({{ $establishment->abb_name }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- User Selection (Dynamic) -->
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">
                            Select User in Establishment
                        </label>
                        <select name="forward_to_user" id="userSelect" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;"
                                disabled>
                            <option value="">First select an establishment</option>
                        </select>
                        <div id="userLoading" style="display: none; font-size: 12px; color: #0077B6; margin-top: 4px;">
                            Loading users...
                        </div>
                        <div id="noUsersMessage" style="display: none; font-size: 12px; color: #dc2626; margin-top: 4px;">
                            No users found in this establishment. Please select another establishment.
                        </div>
                    </div>
                @endif
            @else
                <!-- For other roles - Original single dropdown -->
                <div style="flex: 1; min-width: 220px;">
                    <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">
                        Forward To User
                    </label>
                    <select name="forward_to" required
                            style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->role->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div style="flex: 3; min-width: 220px;">
                <label style="display: block; font-size: 14px; margin-bottom: 4px; color:#023E8A;">Enter Remark</label>
                <input type="text" name="remark" required
                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color:#03045E;">
            </div>
            
            <div style="flex: 1; min-width: 120px; display: flex; align-items: flex-end;">
                <button type="submit" id="submitButton"
                        style="width: 100%; background-color: #00B4D8; color: white; font-weight: 600; padding: 10px; border-radius: 5px; border: none; cursor: pointer;"
                        @if($isEstablishmentHead && !$isDSTHead) disabled @endif>
                    Forward
                </button>
            </div>
        </div>
    </form>

</div>

@if($isEstablishmentHead)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const establishmentSelect = document.getElementById('establishmentSelect');
        const userSelect = document.getElementById('userSelect');
        const userLoading = document.getElementById('userLoading');
        const noUsersMessage = document.getElementById('noUsersMessage');
        const submitButton = document.getElementById('submitButton');

        if (establishmentSelect) {  // Only run if elements exist (non-DST)
            establishmentSelect.addEventListener('change', function() {
                const establishmentId = this.value;
                
                // Reset user dropdown
                userSelect.innerHTML = '<option value="">Loading users...</option>';
                userSelect.disabled = true;
                submitButton.disabled = true;
                noUsersMessage.style.display = 'none';
                
                if (!establishmentId) {
                    userSelect.innerHTML = '<option value="">First select an establishment</option>';
                    return;
                }

                // Show loading
                userLoading.style.display = 'block';
                
                // Fetch users from the selected establishment
                fetch(`/api/establishment-users/${establishmentId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(users => {
                        userLoading.style.display = 'none';
                        
                        if (users.length === 0) {
                            userSelect.innerHTML = '<option value="">No users found</option>';
                            noUsersMessage.style.display = 'block';
                            submitButton.disabled = true;
                        } else {
                            userSelect.innerHTML = '<option value="">Select a user</option>';
                            users.forEach(user => {
                                const option = document.createElement('option');
                                option.value = user.id;
                                option.textContent = `${user.name} - ${user.role_name}`;
                                userSelect.appendChild(option);
                            });
                            userSelect.disabled = false;
                            submitButton.disabled = false;
                            noUsersMessage.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        userLoading.style.display = 'none';
                        userSelect.innerHTML = '<option value="">Error loading users</option>';
                        console.error('Error fetching users:', error);
                        submitButton.disabled = true;
                    });
            });

            // Enable submit button when user is selected
            userSelect.addEventListener('change', function() {
                if (this.value && establishmentSelect.value) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            });
        }

        // Script for toggling vehicle type section (only for DST Head)
        const actionSelect = document.getElementById('actionSelect');
        const vehicleTypeSection = document.getElementById('vehicleTypeSection');
        const vehicleTypeSelect = document.getElementById('vehicleTypeSelect');
        const armyVehicleSection = document.getElementById('armyVehicleSection');
        const armyVehicleSelect = document.getElementById('armyVehicleSelect');
        const armyVehicleLoading = document.getElementById('armyVehicleLoading');
        const noArmyVehiclesMessage = document.getElementById('noArmyVehiclesMessage');

        if (actionSelect && vehicleTypeSection) {
            actionSelect.addEventListener('change', function() {
                const action = this.value;
                vehicleTypeSection.style.display = (action === 'approve') ? 'block' : 'none';
                if (action !== 'approve') {
                    armyVehicleSection.style.display = 'none';  // Hide army section if not approve
                }
            });
        }

        // UPDATED: Script for toggling army vehicle dropdown (now fetches army nos)
        if (vehicleTypeSelect && armyVehicleSection) {
            vehicleTypeSelect.addEventListener('change', function() {
                const vehicleType = this.value;
                if (vehicleType === 'army') {
                    // Show army vehicle section and load data
                    armyVehicleSection.style.display = 'block';
                    armyVehicleSelect.innerHTML = '<option value="">Loading army numbers...</option>';
                    armyVehicleSelect.disabled = true;
                    armyVehicleLoading.style.display = 'block';
                    noArmyVehiclesMessage.style.display = 'none';

                    // Fetch army nos (endpoint /api/vehicle-army-nos)
                    fetch('/api/vehicle-army-nos')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            armyVehicleLoading.style.display = 'none';
                            
                            if (data.error) {
                                armyVehicleSelect.innerHTML = '<option value="">Error loading army numbers</option>';
                                noArmyVehiclesMessage.textContent = data.error;
                                noArmyVehiclesMessage.style.display = 'block';
                                armyVehicleSelect.disabled = true;
                            } else if (data.length === 0) {
                                armyVehicleSelect.innerHTML = '<option value="">No army numbers found</option>';
                                noArmyVehiclesMessage.style.display = 'block';
                                armyVehicleSelect.disabled = true;
                            } else {
                                armyVehicleSelect.innerHTML = '<option value="">Select an Army Number</option>';
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;  // Use vehicle ID as value
                                    option.textContent = item.text;  // vehicle_army_no as display
                                    armyVehicleSelect.appendChild(option);
                                });
                                armyVehicleSelect.disabled = false;
                            }
                        })
                        .catch(error => {
                            armyVehicleLoading.style.display = 'none';
                            armyVehicleSelect.innerHTML = '<option value="">Error loading army numbers</option>';
                            console.error('Error fetching army numbers:', error);
                            armyVehicleSelect.disabled = true;
                        });
                } else {
                    // Hide army section for 'hired'
                    armyVehicleSection.style.display = 'none';
                    armyVehicleSelect.value = '';  // Reset selection
                }
            });
        }

        // UPDATED: Update submit button enablement to require army vehicle if applicable
        const updateSubmitButton = () => {
            const action = actionSelect ? actionSelect.value : '';
            const vehicleType = vehicleTypeSelect ? vehicleTypeSelect.value : '';
            const armyVehicle = armyVehicleSelect ? armyVehicleSelect.value : '';
            
            if (action === 'approve' && vehicleType === 'army' && !armyVehicle) {
                submitButton.disabled = true;
            } else if (action && (vehicleType || action === 'reject')) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        };

        if (armyVehicleSelect) {
            armyVehicleSelect.addEventListener('change', updateSubmitButton);
        }
        if (vehicleTypeSelect) {
            vehicleTypeSelect.addEventListener('change', updateSubmitButton);
        }
        if (actionSelect) {
            actionSelect.addEventListener('change', updateSubmitButton);
        }
    });
</script>
@endif

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