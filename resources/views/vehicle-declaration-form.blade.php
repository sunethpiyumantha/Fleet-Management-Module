@extends('layouts.app')

@section('title', 'Vehicle Registration')

@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">
            Declaration made by the owner of the vehicle in respect of the vehicles acquired on hire payment basis to the Army
        </h2>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" enctype="multipart/form-data" 
              action="{{ isset($vehicleDeclaration) ? route('vehicle-declaration.update', $vehicleDeclaration->id) : route('vehicle-declaration.store') }}">
            @csrf
            @if(isset($vehicleDeclaration))
                @method('PUT')
            @endif
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">
                <!-- Owner Section -->
                <div style="width: 100%; max-width: 640px; border: 1px solid #d1d5db; border-radius: 0.75rem; padding: 1rem; background-color: #f9fafb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Owner Section</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Row 1: Vehicle Registration Number + Full Name of Owner -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="registration_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Registration Number</label>
                                <input type="text" id="registration_number" name="registration_number" required
                                       value="{{ old('registration_number', $vehicleDeclaration->registration_number ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="owner_full_name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Full Name of Owner</label>
                                <input type="text" id="owner_full_name" name="owner_full_name" required
                                       value="{{ old('owner_full_name', $vehicleDeclaration->owner_full_name ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 2: Owner's Name with Initials + Permanent Address -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="owner_initials_name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Owner's Name with Initials</label>
                                <input type="text" id="owner_initials_name" name="owner_initials_name" required
                                       value="{{ old('owner_initials_name', $vehicleDeclaration->owner_initials_name ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="owner_permanent_address" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Permanent Address</label>
                                <input type="text" id="owner_permanent_address" name="owner_permanent_address" required
                                       value="{{ old('owner_permanent_address', $vehicleDeclaration->owner_permanent_address ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 3: Temporary Address + Phone Number -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="owner_temporary_address" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Temporary Address (if any)</label>
                                <input type="text" id="owner_temporary_address" name="owner_temporary_address"
                                       value="{{ old('owner_temporary_address', $vehicleDeclaration->owner_temporary_address ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="owner_phone_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Phone Number</label>
                                <input type="tel" id="owner_phone_number" name="owner_phone_number" required
                                       value="{{ old('owner_phone_number', $vehicleDeclaration->owner_phone_number ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 4: Bank Account Details + Vehicle Type -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="owner_bank_details" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Bank Account Details</label>
                                <input type="text" id="owner_bank_details" name="owner_bank_details" required
                                       value="{{ old('owner_bank_details', $vehicleDeclaration->owner_bank_details ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="vehicle_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Type</label>
                                <select id="vehicle_type" name="vehicle_type" required
                                        style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                                    <option value="" disabled selected>Select Vehicle Type</option>
                                    @foreach($vehicleTypes as $type)
                                        <option value="{{ $type->id }}" 
                                                {{ old('vehicle_type', $vehicleDeclaration->vehicle_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 4.1: Vehicle Model -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="vehicle_model" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Model</label>
                                <select id="vehicle_model" name="vehicle_model" required
                                        style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                                    <option value="" disabled {{ old('vehicle_model') === null ? 'selected' : '' }}>Select Vehicle Model</option>
                                    @foreach($vehicleModels as $model)
                                        <option value="{{ $model->id }}"
                                                {{ old('vehicle_model', $vehicleDeclaration->vehicle_model_id ?? '') == $model->id ? 'selected' : '' }}>
                                            {{ $model->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="flex: 1 1 300px;"></div> <!-- Empty div to maintain layout -->
                        </div>

                        <!-- Row 5: Number of Seats (Registered + Current) -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="seats_registered" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Registered Seats</label>
                                <input type="number" id="seats_registered" name="seats_registered" min="1" required
                                       value="{{ old('seats_registered', $vehicleDeclaration->seats_registered ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="seats_current" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Current Seats</label>
                                <input type="number" id="seats_current" name="seats_current" min="1" required
                                       value="{{ old('seats_current', $vehicleDeclaration->seats_current ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 6: Registration Certificate + Insurance Certificate -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="registration_certificate" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Registration Certificate</label>
                                <input type="file" id="registration_certificate" name="registration_certificate" {{ isset($vehicleDeclaration) ? '' : 'required' }}
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                                @if(isset($vehicleDeclaration) && $vehicleDeclaration->registration_certificate)
                                    <small style="color: #6b7280;">Current: <a href="{{ $vehicleDeclaration->registration_certificate_url }}" target="_blank" style="color: #3b82f6;">View File</a></small>
                                @endif
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="insurance_certificate" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Insurance Certificate</label>
                                <input type="file" id="insurance_certificate" name="insurance_certificate" {{ isset($vehicleDeclaration) ? '' : 'required' }}
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                                @if(isset($vehicleDeclaration) && $vehicleDeclaration->insurance_certificate)
                                    <small style="color: #6b7280;">Current: <a href="{{ $vehicleDeclaration->insurance_certificate_url }}" target="_blank" style="color: #3b82f6;">View File</a></small>
                                @endif
                            </div>
                        </div>

                        <!-- Row 7: Loan/Tax Details + Daily Rent -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="loan_tax_details" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Loan/Tax Details</label>
                                <input type="text" id="loan_tax_details" name="loan_tax_details"
                                       value="{{ old('loan_tax_details', $vehicleDeclaration->loan_tax_details ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="daily_rent" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Daily Rent</label>
                                <input type="number" id="daily_rent" name="daily_rent" min="0" step="0.01" required
                                       value="{{ old('daily_rent', $vehicleDeclaration->daily_rent ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 8: Induction Date -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="induction_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Induction Date</label>
                                <input type="date" id="induction_date" name="induction_date" required
                                       value="{{ old('induction_date', isset($vehicleDeclaration) ? $vehicleDeclaration->induction_date->format('Y-m-d') : '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;"></div> <!-- Empty div to maintain layout -->
                        </div>
                    </div>
                </div>

                <!-- Driver Section -->
                <div style="width: 100%; max-width: 640px; border: 1px solid #d1d5db; border-radius: 0.75rem; padding: 1rem; background-color: #f9fafb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Driver Section</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Row 9: Owner's Next of Kin + Driver Full Name -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="owner_next_of_kin" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Owner's Next of Kin</label>
                                <input type="text" id="owner_next_of_kin" name="owner_next_of_kin" required
                                       value="{{ old('owner_next_of_kin', $vehicleDeclaration->owner_next_of_kin ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="driver_full_name" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver Full Name</label>
                                <input type="text" id="driver_full_name" name="driver_full_name" required
                                       value="{{ old('driver_full_name', $vehicleDeclaration->driver_full_name ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 10: Driver Address + Driver's License Number -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="driver_address" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver Address</label>
                                <input type="text" id="driver_address" name="driver_address" required
                                       value="{{ old('driver_address', $vehicleDeclaration->driver_address ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="driver_license_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver's License Number</label>
                                <input type="text" id="driver_license_number" name="driver_license_number" required
                                       value="{{ old('driver_license_number', $vehicleDeclaration->driver_license_number ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Row 11: Driver's NIC Number + Driver's Next of Kin -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="driver_nic_number" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver's NIC Number</label>
                                <input type="text" id="driver_nic_number" name="driver_nic_number" required
                                       value="{{ old('driver_nic_number', $vehicleDeclaration->driver_nic_number ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="driver_next_of_kin" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver's Next of Kin</label>
                                <input type="text" id="driver_next_of_kin" name="driver_next_of_kin" required
                                       value="{{ old('driver_next_of_kin', $vehicleDeclaration->driver_next_of_kin ?? '') }}"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Documents Section -->
                <div style="width: 100%; max-width: 640px; border: 1px solid #d1d5db; border-radius: 0.75rem; padding: 1rem; background-color: #f9fafb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Additional Documents Section</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Row 12: Additional Document 1 + Additional Document 2 -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="document_1" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 1</label>
                                <input type="file" id="document_1" name="document_1"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                                @if(isset($vehicleDeclaration) && $vehicleDeclaration->document_1)
                                    <small style="color: #6b7280;">Current: <a href="{{ $vehicleDeclaration->document_1_url }}" target="_blank" style="color: #3b82f6;">View File</a></small>
                                @endif
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="document_2" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 2</label>
                                <input type="file" id="document_2" name="document_2"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                                @if(isset($vehicleDeclaration) && $vehicleDeclaration->document_2)
                                    <small style="color: #6b7280;">Current: <a href="{{ $vehicleDeclaration->document_2_url }}" target="_blank" style="color: #3b82f6;">View File</a></small>
                                @endif
                            </div>
                        </div>

                        <!-- Row 13: Additional Document 3 + Additional Document 4 -->
                        <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 600px;">
                            <div style="flex: 1 1 300px;">
                                <label for="document_3" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 3</label>
                                <input type="file" id="document_3" name="document_3"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                                @if(isset($vehicleDeclaration) && $vehicleDeclaration->document_3)
                                    <small style="color: #6b7280;">Current: <a href="{{ $vehicleDeclaration->document_3_url }}" target="_blank" style="color: #3b82f6;">View File</a></small>
                                @endif
                            </div>
                            <div style="flex: 1 1 300px;">
                                <label for="document_4" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Additional Document 4</label>
                                <input type="file" id="document_4" name="document_4"
                                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.4rem 0.75rem; outline: none; box-sizing: border-box;">
                                @if(isset($vehicleDeclaration) && $vehicleDeclaration->document_4)
                                    <small style="color: #6b7280;">Current: <a href="{{ $vehicleDeclaration->document_4_url }}" target="_blank" style="color: #3b82f6;">View File</a></small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="width: 100%; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <button type="submit"
                            style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-{{ isset($vehicleDeclaration) ? 'edit' : 'plus-circle' }}" style="margin-right: 0.25rem;"></i> 
                        {{ isset($vehicleDeclaration) ? 'Update' : 'Submit' }}
                    </button>
                    
                    @if(isset($vehicleDeclaration))
                        <form method="POST" action="{{ route('vehicle-declaration.destroy', $vehicleDeclaration->id) }}" style="display: inline;" 
                              onsubmit="return confirm('Are you sure you want to delete this vehicle declaration?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background-color: #dc2626; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                                <i class="fa-solid fa-trash" style="margin-right: 0.25rem;"></i> Delete
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('vehicle-declaration.index') }}"
                       style="background-color: #6b7280; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: background-color 0.2s; display: inline-block;"
                       onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fa-solid fa-arrow-left" style="margin-right: 0.25rem;"></i> Back to List
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for vehicle model dropdown -->
<script>
    const vehicleTypeSelect = document.getElementById('vehicle_type');
    const vehicleModelSelect = document.getElementById('vehicle_model');

    // Parse the vehicleModels data passed from the server
    const vehicleModels = JSON.parse('{{ $vehicleModelsJson ?? '[]' }}' || '[]');

    // Populate vehicle model dropdown initially
    function populateVehicleModels() {
        if (!vehicleModelSelect) {
            console.error('vehicleModelSelect element not found');
            return;
        }
        vehicleModelSelect.innerHTML = '<option value="" disabled selected>Select Vehicle Model</option>';
        if (vehicleModels.length > 0) {
            vehicleModels.forEach(model => {
                const option = document.createElement('option');
                option.value = model.id;
                option.textContent = model.name; // Use 'name' as per controller mapping
                vehicleModelSelect.appendChild(option);
            });
            vehicleModelSelect.disabled = false;
        } else {
            vehicleModelSelect.innerHTML = '<option value="" disabled selected>No models available</option>';
        }

        // Set the selected value if editing
        const selectedModelId = '{{ old('vehicle_model', $vehicleDeclaration->vehicle_model_id ?? '') }}';
        if (selectedModelId) {
            vehicleModelSelect.value = selectedModelId;
        }
    }

    // Call populate function on page load
    document.addEventListener('DOMContentLoaded', populateVehicleModels);

    // Optional: Clear model selection if vehicle type is changed (no filtering)
    vehicleTypeSelect.addEventListener('change', function() {
        if (!this.value) {
            vehicleModelSelect.value = '';
        }
    });
</script>
@endsection