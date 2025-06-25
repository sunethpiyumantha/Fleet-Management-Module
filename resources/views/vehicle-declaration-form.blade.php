@extends('layouts.app')

@section('title', 'Vehicle Declaration')

@section('content')
<div style="max-width: 90rem; margin: 0 auto; padding: 2.5rem 1.5rem; font-family: Arial, sans-serif;">
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); border: 2px solid #f97316; border-radius: 1.5rem; box-shadow: 0 12px 20px -5px rgba(0,0,0,0.15), 0 6px 8px -4px rgba(0,0,0,0.1); padding: 2rem; transition: transform 0.3s ease;">
        <h2 style="font-size: 2rem; font-weight: 700; color: #ea580c; text-align: center; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 1px; animation: fadeIn 0.5s ease-in;">
            Declaration for Vehicle Hire to Army
        </h2>

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" action="{{ isset($declaration) ? route('vehicle.declaration.update', $declaration->id) : route('vehicle.declaration.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($declaration))
                @method('PUT')
                <input type="hidden" name="id" value="{{ $declaration->id }}">
            @endif
            <input type="hidden" name="serial_number" value="{{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? '') }}">
            <div style="display: flex; flex-direction: column; gap: 2rem; align-items: center;">
                <!-- Tab Navigation -->
                <div style="display: flex; gap: 0.75rem; justify-content: center; margin-bottom: 1.5rem; background: #f3f4f6; padding: 0.25rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <button type="button" class="tab-button active" onclick="openTab('owner')" style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Owner
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                    <button type="button" class="tab-button" onclick="openTab('driver')" style="background: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Driver
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                    <button type="button" class="tab-button" onclick="openTab('vehicle')" style="background: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Vehicle
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                    <button type="button" class="tab-button" onclick="openTab('additional')" style="background: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; transition: all 0.3s ease; font-weight: 600; position: relative; overflow: hidden;">
                        Attachments
                        <span style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: rgba(255,255,255,0.2); transform: skew(-20deg); transition: all 0.4s ease;" class="hover-effect"></span>
                    </button>
                </div>

                <!-- Owner Tab -->
                <div id="owner-tab" class="tab-content" style="display: block; width: 100%; max-width: 1280px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Owner Details (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? '') }})</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="registration_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Vehicle Reg. Number</label>
                                <input type="text" id="registration_number" name="registration_number" required
                                    value="{{ old('registration_number', $declaration->registration_number ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('registration_number')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owner_full_name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Full Name</label>
                                <input type="text" id="owner_full_name" name="owner_full_name" required
                                    value="{{ old('owner_full_name', $declaration->owner_full_name ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('owner_full_name')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owner_initials_name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Name with Initials</label>
                                <input type="text" id="owner_initials_name" name="owner_initials_name" required
                                    value="{{ old('owner_initials_name', $declaration->owner_initials_name ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('owner_initials_name')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owner_permanent_address" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Permanent Address</label>
                                <input type="text" id="owner_permanent_address" name="owner_permanent_address" required
                                    value="{{ old('owner_permanent_address', $declaration->owner_permanent_address ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('owner_permanent_address')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owner_temporary_address" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Temporary Address (if any)</label>
                                <input type="text" id="owner_temporary_address" name="owner_temporary_address"
                                    value="{{ old('owner_temporary_address', $declaration->owner_temporary_address ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('owner_temporary_address')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owner_phone_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Phone Number</label>
                                <input type="tel" id="owner_phone_number" name="owner_phone_number" required
                                    value="{{ old('owner_phone_number', $declaration->owner_phone_number ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('owner_phone_number')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owner_bank_details" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Bank Account Details</label>
                                <input type="text" id="owner_bank_details" name="owner_bank_details" required
                                    value="{{ old('owner_bank_details', $declaration->owner_bank_details ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('owner_bank_details')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="vehicle_type" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Vehicle Type</label>
                                <select id="vehicle_type" name="vehicle_type_id" required
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"%23374151\"><path d=\"M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z\"/></svg>') no-repeat right 1rem center;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    <option value="" disabled {{ !old('vehicle_type_id', $declaration->vehicle_type_id ?? '') ? 'selected' : '' }}>Select Vehicle Type</option>
                                    @foreach($vehicleTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('vehicle_type_id', $declaration->vehicle_type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_type_id')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="vehicle_model" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Vehicle Model</label>
                                <select id="vehicle_model" name="vehicle_model_id" required
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"%23374151\"><path d=\"M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z\"/></svg>') no-repeat right 1rem center;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    <option value="" disabled {{ !old('vehicle_model_id', $declaration->vehicle_model_id ?? '') ? 'selected' : '' }}>Select Vehicle Model</option>
                                    @foreach($vehicleModels as $model)
                                        <option value="{{ $model->id }}" {{ old('vehicle_model_id', $declaration->vehicle_model_id ?? '') == $model->id ? 'selected' : '' }}>{{ $model->model }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_model_id')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="seats_registered" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Registered Seats</label>
                                <input type="number" id="seats_registered" name="seats_registered" min="1" required
                                    value="{{ old('seats_registered', $declaration->seats_registered ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('seats_registered')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="seats_current" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Current Seats</label>
                                <input type="number" id="seats_current" name="seats_current" min="1" required
                                    value="{{ old('seats_current', $declaration->seats_current ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('seats_current')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="loan_tax_details" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Loan/Tax Details</label>
                                <input type="text" id="loan_tax_details" name="loan_tax_details"
                                    value="{{ old('loan_tax_details', $declaration->loan_tax_details ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('loan_tax_details')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="daily_rent" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Daily Rent</label>
                                <input type="number" id="daily_rent" name="daily_rent" min="0" step="0.01" required
                                    value="{{ old('daily_rent', $declaration->daily_rent ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('daily_rent')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="induction_date" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Induction Date</label>
                                <input type="date" id="induction_date" name="induction_date" required
                                    value="{{ old('induction_date', $declaration->induction_date ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('induction_date')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Driver Tab -->
                <div id="driver-tab" class="tab-content" style="display: none; width: 100%; max-width: 1280px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Driver Details (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? '') }})</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <!-- Driver Form -->
                        <div id="driver-form">
                            <input type="hidden" id="driver-index" value="0">
                            <input type="hidden" id="edit-driver-id" name="drivers[0][id]">
                            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="reg_nic" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Reg No / NIC</label>
                                    <input type="text" id="reg_nic" name="drivers[0][reg_nic]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.reg_nic')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="rank" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Rank</label>
                                    <input type="text" id="rank" name="drivers[0][rank]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.rank')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="driver_name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Name</label>
                                    <input type="text" id="driver_name" name="drivers[0][driver_name]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.driver_name')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="unit" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Unit</label>
                                    <input type="text" id="unit" name="drivers[0][unit]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.unit')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="code_no_driver" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">If Staff Officer Vehicle, Code No</label>
                                    <input type="text" id="code_no_driver" name="drivers[0][code_no_driver]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.code_no_driver')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="army_license_no" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Army / Driving License No</label>
                                    <input type="text" id="army_license_no" name="drivers[0][army_license_no]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.army_license_no')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="license_issued_date" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">License Issued Date</label>
                                    <input type="date" id="license_issued_date" name="drivers[0][license_issued_date]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.license_issued_date')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="flex: 1; min-width: 0; max-width: 49%;">
                                    <label for="license_expire_date" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">License Expire Date</label>
                                    <input type="date" id="license_expire_date" name="drivers[0][license_expire_date]"
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    @error('drivers.*.license_expire_date')
                                        <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Form Buttons -->
                        <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
                            <button type="button" id="add-driver-btn" onclick="addDriver()" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-weight: 600;"
                                    onmouseover="this.style.background='linear-gradient(90deg, #059669 0%, #047857 100%)'; this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.background='linear-gradient(90deg, #10b981 0%, #059669 100%)'; this.style.transform='scale(1)'">Add Driver</button>
                            <button type="button" id="update-driver-btn" onclick="updateDriver()" style="display: none; background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-weight: 600;"
                                    onmouseover="this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'">Update Driver</button>
                            <button type="button" onclick="resetDriverForm()" style="background: linear-gradient(90deg, #6b7280 0%, #4b5563 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-weight: 600;"
                                    onmouseover="this.style.background='linear-gradient(90deg, #4b5563 0%, #374151 100%)'; this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.background='linear-gradient(90deg, #6b7280 0%, #4b5563 100%)'; this.style.transform='scale(1)'">Clear Form</button>
                        </div>
                        <!-- Driver Table -->
                        <div style="margin-top: 2rem; overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                                <thead>
                                    <tr style="background-color: #f3f4f6;">
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">SN</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Reg No / NIC</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Rank</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Name</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Unit</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Code No</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">License No</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Issued Date</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Expire Date</th>
                                        <th style="border: 1px solid #d1d5db; padding: 8px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="driver-table-body">
                                    @if(isset($declaration) && $declaration->drivers)
                                        @foreach($declaration->drivers as $index => $driver)
                                            <tr data-driver-id="{{ $driver->id }}" data-driver-index="{{ $index }}">
                                                <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->reg_nic }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->rank }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->driver_name }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->unit }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->code_no_driver ?? 'N/A' }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->army_license_no }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->license_issued_date }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $driver->license_expire_date }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">
                                                    <button type="button" onclick="editDriver({{ $index }})" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; margin-right: 0.5rem;">Edit</button>
                                                    <button type="button" onclick="deleteDriver({{ $index }})" style="background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer;">Delete</button>
                                                    <input type="hidden" name="drivers[{{ $index }}][id]" value="{{ $driver->id }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][reg_nic]" value="{{ $driver->reg_nic }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][rank]" value="{{ $driver->rank }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][driver_name]" value="{{ $driver->driver_name }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][unit]" value="{{ $driver->unit }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][code_no_driver]" value="{{ $driver->code_no_driver ?? '' }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][army_license_no]" value="{{ $driver->army_license_no }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][license_issued_date]" value="{{ $driver->license_issued_date }}">
                                                    <input type="hidden" name="drivers[{{ $index }}][license_expire_date]" value="{{ $driver->license_expire_date }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Vehicle Tab -->
                <div id="vehicle-tab" class="tab-content" style="display: none; width: 100%; max-width: 1280px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Vehicle Details (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? '') }})</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="civil_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">{{ $requestType === 'replacement' ? 'Civil Number' : 'Army Number' }}</label>
                                <input type="text" id="civil_number" name="civil_number" required
                                    value="{{ old('civil_number', $declaration->civil_number ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('civil_number')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="product_classification" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Product Classification</label>
                                <input type="text" id="product_classification" name="product_classification" required
                                    value="{{ old('product_classification', $declaration->product_classification ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('product_classification')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="engine_no" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Engine No</label>
                                <input type="text" id="engine_no" name="engine_no" required
                                    value="{{ old('engine_no', $declaration->engine_no ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('engine_no')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="chassis_number" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Chassis Number</label>
                                <input type="text" id="chassis_number" name="chassis_number" required
                                    value="{{ old('chassis_number', $declaration->chassis_number ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('chassis_number')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="year_of_manufacture" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Year of Manufacture</label>
                                <input type="number" id="year_of_manufacture" name="year_of_manufacture" min="1900" required
                                    value="{{ old('year_of_manufacture', $declaration->year_of_manufacture ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('year_of_manufacture')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="date_of_original_registration" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Date of Original Registration</label>
                                <input type="date" id="date_of_original_registration" name="date_of_original_registration" required
                                    value="{{ old('date_of_original_registration', $declaration->date_of_original_registration ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('date_of_original_registration')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="engine_capacity" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Engine Capacity</label>
                                <select id="engine_capacity" name="engine_capacity_id" required
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"%23374151\"><path d=\"M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z\"/></svg>') no-repeat right 1rem center;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    <option value="" disabled {{ !old('engine_capacity_id', $declaration->engine_capacity_id ?? '') ? 'selected' : '' }}>Select Engine Capacity</option>
                                    @foreach($engineCapacities as $capacity)
                                        <option value="{{ $capacity->id }}" {{ old('engine_capacity_id', $declaration->engine_capacity_id ?? '') == $capacity->id ? 'selected' : '' }}>{{ $capacity->engine_capacity }}</option>
                                    @endforeach
                                </select>
                                @error('engine_capacity_id')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="section_4_w_2w" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Section 4 W/2W</label>
                                <input type="text" id="section_4_w_2w" name="section_4_w_2w" required
                                    value="{{ old('section_4_w_2w', $declaration->section_4_w_2w ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('section_4_w_2w')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="speedometer_hours" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Speedometer Hours at Takeover</label>
                                <input type="number" id="speedometer_hours" name="speedometer_hours" min="0" required
                                    value="{{ old('speedometer_hours', $declaration->speedometer_hours ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('speedometer_hours')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="code_no_vehicle" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Code No</label>
                                <input type="text" id="code_no_vehicle" name="code_no_vehicle" required
                                    value="{{ old('code_no_vehicle', $declaration->code_no_vehicle ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('code_no_vehicle')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="color" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Color</label>
                                <select id="color" name="color_id" required
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"%23374151\"><path d=\"M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z\"/></svg>') no-repeat right 1rem center;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    <option value="" disabled {{ !old('color_id', $declaration->color_id ?? '') ? 'selected' : '' }}>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ old('color_id', $declaration->color_id ?? '') == $color->id ? 'selected' : '' }}>{{ $color->color }}</option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="pay_per_day" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Pay per Day</label>
                                <input type="number" id="pay_per_day" name="pay_per_day" min="0" step="0.01" required
                                    value="{{ old('pay_per_day', $declaration->pay_per_day ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: all 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('pay_per_day')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="fuel_type" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Type of Fuel</label>
                                <select id="fuel_type" name="fuel_type_id" required
                                        style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: all 0.3s ease; font-size: 0.9rem; appearance: none; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" fill=\"%23374151\"><path d=\"M7 10l-5-5 1.41-1.41L7 7.17l4.59-4.58L12 5l-5 5z\"/></svg>') no-repeat right 1rem center;"
                                        onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                    <option value="" disabled {{ !old('fuel_type_id', $declaration->fuel_type_id ?? '') ? 'selected' : '' }}>Select Fuel Type</option>
                                    @foreach($fuelTypes as $fuel)
                                        <option value="{{ $fuel->id }}" {{ old('fuel_type_id', $declaration->fuel_type_id ?? '') == $fuel->id ? 'selected' : '' }}>{{ $fuel->fuel_type }}</option>
                                    @endforeach
                                </select>
                                @error('fuel_type_id')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="tar_weight_capacity" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">TAR Weight Capacity</label>
                                <input type="text" id="tar_weight_capacity" name="tar_weight_capacity" required
                                    value="{{ old('tar_weight_capacity', $declaration->tar_weight_capacity ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: all 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('tar_weight_capacity')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="amount_of_fuel" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Amount of Fuel</label>
                                <input type="number" id="amount_of_fuel" name="amount_of_fuel" min="0" step="0.01" required
                                    value="{{ old('amount_of_fuel', $declaration->amount_of_fuel ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: all 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('amount_of_fuel')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="reason_for_taking_over" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Reason for Taking Over</label>
                                <input type="text" id="reason_for_taking_over" name="reason_for_taking_over" required
                                    value="{{ old('reason_for_taking_over', $declaration->reason_for_taking_over ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: all 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('reason_for_taking_over')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="other_matters" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Other Matters</label>
                                <input type="text" id="other_matters" name="other_matters"
                                    value="{{ old('other_matters', $declaration->other_matters ?? '') }}"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: all 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @error('other_matters')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Tab -->
                <div id="additional-tab" class="tab-content" style="display: none; width: 100%; max-width: 1280px; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #f97316; padding-bottom: 0.5rem;">Attachments (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? '') }})</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="registration_certificate" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Registration Certificate</label>
                                <input type="file" id="registration_certificate" name="registration_certificate" accept=".pdf,.jpg,.png"
                                       style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                       onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->registration_certificate))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->registration_certificate) }}</span>
                                @endif
                                @error('registration_certificate')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="insurance_certificate" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Insurance Certificate</label>
                                <input type="file" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->insurance_certificate))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->insurance_certificate) }}</span>
                                @endif
                                @error('insurance_certificate')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="revenue_license_certificate" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Revenue License Certificate</label>
                                <input type="file" id="revenue_license_certificate" name="revenue_license_certificate" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->revenue_license_certificate))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->revenue_license_certificate) }}</span>
                                @endif
                                @error('revenue_license_certificate')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owners_certified_nic" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Owner's Certified NIC</label>
                                <input type="file" id="owners_certified_nic" name="owners_certified_nic" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->owners_certified_nic))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->owners_certified_nic) }}</span>
                                @endif
                                @error('owners_certified_nic')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="owners_certified_bank_passbook" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Owner's Certified Bank Passbook</label>
                                <input type="file" id="owners_certified_bank_passbook" name="owners_certified_bank_passbook" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->owners_certified_bank_passbook))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->owners_certified_bank_passbook) }}</span>
                                @endif
                                @error('owners_certified_bank_passbook')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="suppliers_scanned_sign_document" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Suppliers Scanned Sign Document</label>
                                <input type="file" id="suppliers_scanned_sign_document" name="suppliers_scanned_sign_document" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->suppliers_scanned_sign_document))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->suppliers_scanned_sign_document) }}</span>
                                @endif
                                @error('suppliers_scanned_sign_document')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="affidavit_non_joint_account" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Affidavit Non-Joint Account</label>
                                <input type="file" id="affidavit_non_joint_account" name="affidavit_non_joint_account" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->affidavit_non_joint_account))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->affidavit_non_joint_account) }}</span>
                                @endif
                                @error('affidavit_non_joint_account')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 0; max-width: 49%;">
                                <label for="affidavit_army_driver" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 600; color: #4b5563;">Affidavit Army Driver</label>
                                <input type="file" id="affidavit_army_driver" name="affidavit_army_driver" accept=".pdf,.jpg,.png"
                                    style="width: 100%; height: 48px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.625rem 1rem; outline: none; box-sizing: border-box; transition: border-color 0.3s ease, background-color 0.3s ease; font-size: 0.9rem;"
                                    onfocus="this.style.borderColor='#f97316'; this.style.backgroundColor='#fff7ed'" onblur="this.style.borderColor='#d1d5db'; this.style.backgroundColor='white'">
                                @if(isset($declaration->affidavit_army_driver))
                                    <span style="font-size: 0.8rem; color: #4b5563;">Current file: {{ basename($declaration->affidavit_army_driver) }}</span>
                                @endif
                                @error('affidavit_army_driver')
                                    <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
<div style="display: flex; gap: 1.5rem; justify-content: center; width: 100%; margin-top: 1rem;">
    <button type="button" id="prevButton" onclick="previousTab()" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-weight: 600;"
            onmouseover="if(!this.disabled){this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'}" 
            onmouseout="if(!this.disabled){this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'}"
            disabled>Previous</button>
    <button type="button" id="nextButton" onclick="nextTab()" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-weight: 600;"
            onmouseover="if(!this.disabled){this.style.background='linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='scale(1.05)'}" 
            onmouseout="if(!this.disabled){this.style.background='linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='scale(1)'}" >Next</button>
</div>

<!-- Submit Button -->
<div style="width: 100%; display: flex; justify-content: center; margin-top: 1.5rem;">
    <button type="submit"
            style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white; font-weight: 600; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: all 0.3s ease, transform 0.2s ease; font-size: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
            onmouseover="this.style.background='linear-gradient(90deg, #ea580c 0%, #c2410c 100%)'; this.style.transform='scale(1.05)'" 
            onmouseout="this.style.background='linear-gradient(90deg, #f97316 0%, #ea580c 100%)'; this.style.transform='scale(1)'">
        <i class="fa-solid fa-save" style="margin-right: 0.5rem;"></i> {{ isset($declaration) ? 'Update Declaration' : 'Save Declaration' }}
    </button>
</div>
</div>
</form>
</div>
</div>

<!-- JavaScript for tab switching and dynamic vehicle model dropdown -->
<script>

let driverIndex = {{ isset($declaration) && $declaration->drivers ? count($declaration->drivers) : 0 }};

    function addDriver() {
        const form = document.getElementById('driver-form');
        const tableBody = document.getElementById('driver-table-body');
        const regNic = document.getElementById('reg_nic').value;
        const rank = document.getElementById('rank').value;
        const driverName = document.getElementById('driver_name').value;
        const unit = document.getElementById('unit').value;
        const codeNoDriver = document.getElementById('code_no_driver').value;
        const armyLicenseNo = document.getElementById('army_license_no').value;
        const licenseIssuedDate = document.getElementById('license_issued_date').value;
        const licenseExpireDate = document.getElementById('license_expire_date').value;

        if (!regNic || !rank || !driverName || !unit || !armyLicenseNo || !licenseIssuedDate || !licenseExpireDate) {
            alert('Please fill all required driver fields.');
            return;
        }

        const row = document.createElement('tr');
        row.setAttribute('data-driver-index', driverIndex);
        row.innerHTML = `
            <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">${tableBody.children.length + 1}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${regNic}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${rank}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${driverName}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${unit}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${codeNoDriver || 'N/A'}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${armyLicenseNo}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${licenseIssuedDate}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px;">${licenseExpireDate}</td>
            <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">
                <button type="button" onclick="editDriver(${driverIndex})" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; margin-right: 0.5rem;">Edit</button>
                <button type="button" onclick="deleteDriver(${driverIndex})" style="background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer;">Delete</button>
                <input type="hidden" name="drivers[${driverIndex}][reg_nic]" value="${regNic}">
                <input type="hidden" name="drivers[${driverIndex}][rank]" value="${rank}">
                <input type="hidden" name="drivers[${driverIndex}][driver_name]" value="${driverName}">
                <input type="hidden" name="drivers[${driverIndex}][unit]" value="${unit}">
                <input type="hidden" name="drivers[${driverIndex}][code_no_driver]" value="${codeNoDriver}">
                <input type="hidden" name="drivers[${driverIndex}][army_license_no]" value="${armyLicenseNo}">
                <input type="hidden" name="drivers[${driverIndex}][license_issued_date]" value="${licenseIssuedDate}">
                <input type="hidden" name="drivers[${driverIndex}][license_expire_date]" value="${licenseExpireDate}">
            </td>
        `;
        tableBody.appendChild(row);
        resetDriverForm();
        driverIndex++;
        updateDriverFormIndex();
    }

    function editDriver(index) {
        const row = document.querySelector(`tr[data-driver-index="${index}"]`);
        if (!row) return;

        const regNic = row.querySelector(`input[name="drivers[${index}][reg_nic]"]`).value;
        const rank = row.querySelector(`input[name="drivers[${index}][rank]"]`).value;
        const driverName = row.querySelector(`input[name="drivers[${index}][driver_name]"]`).value;
        const unit = row.querySelector(`input[name="drivers[${index}][unit]"]`).value;
        const codeNoDriver = row.querySelector(`input[name="drivers[${index}][code_no_driver]"]`).value;
        const armyLicenseNo = row.querySelector(`input[name="drivers[${index}][army_license_no]"]`).value;
        const licenseIssuedDate = row.querySelector(`input[name="drivers[${index}][license_issued_date]"]`).value;
        const licenseExpireDate = row.querySelector(`input[name="drivers[${index}][license_expire_date]"]`).value;
        const driverId = row.getAttribute('data-driver-id') || '';

        document.getElementById('reg_nic').value = regNic;
        document.getElementById('rank').value = rank;
        document.getElementById('driver_name').value = driverName;
        document.getElementById('unit').value = unit;
        document.getElementById('code_no_driver').value = codeNoDriver;
        document.getElementById('army_license_no').value = armyLicenseNo;
        document.getElementById('license_issued_date').value = licenseIssuedDate;
        document.getElementById('license_expire_date').value = licenseExpireDate;
        document.getElementById('edit-driver-id').value = driverId;
        document.getElementById('driver-index').value = index;

        document.getElementById('add-driver-btn').style.display = 'none';
        document.getElementById('update-driver-btn').style.display = 'inline-block';
    }

    function updateDriver() {
        const index = document.getElementById('driver-index').value;
        const driverId = document.getElementById('edit-driver-id').value;
        const regNic = document.getElementById('reg_nic').value;
        const rank = document.getElementById('rank').value;
        const driverName = document.getElementById('driver_name').value;
        const unit = document.getElementById('unit').value;
        const codeNoDriver = document.getElementById('code_no_driver').value;
        const armyLicenseNo = document.getElementById('army_license_no').value;
        const licenseIssuedDate = document.getElementById('license_issued_date').value;
        const licenseExpireDate = document.getElementById('license_expire_date').value;

        if (!regNic || !rank || !driverName || !unit || !armyLicenseNo || !licenseIssuedDate || !licenseExpireDate) {
            alert('Please fill all required driver fields.');
            return;
        }

        const row = document.querySelector(`tr[data-driver-index="${index}"]`);
        if (row) {
            row.innerHTML = `
                <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">${Array.from(row.parentNode.children).indexOf(row) + 1}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${regNic}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${rank}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${driverName}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${unit}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${codeNoDriver || 'N/A'}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${armyLicenseNo}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${licenseIssuedDate}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">${licenseExpireDate}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">
                    <button type="button" onclick="editDriver(${index})" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; margin-right: 0.5rem;">Edit</button>
                    <button type="button" onclick="deleteDriver(${index})" style="background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer;">Delete</button>
                    <input type="hidden" name="drivers[${index}][id]" value="${driverId}">
                    <input type="hidden" name="drivers[${index}][reg_nic]" value="${regNic}">
                    <input type="hidden" name="drivers[${index}][rank]" value="${rank}">
                    <input type="hidden" name="drivers[${index}][driver_name]" value="${driverName}">
                    <input type="hidden" name="drivers[${index}][unit]" value="${unit}">
                    <input type="hidden" name="drivers[${index}][code_no_driver]" value="${codeNoDriver}">
                    <input type="hidden" name="drivers[${index}][army_license_no]" value="${armyLicenseNo}">
                    <input type="hidden" name="drivers[${index}][license_issued_date]" value="${licenseIssuedDate}">
                    <input type="hidden" name="drivers[${index}][license_expire_date]" value="${licenseExpireDate}">
                </td>
            `;
            resetDriverForm();
        }
    }

    function deleteDriver(index) {
        if (confirm('Are you sure you want to delete this driver?')) {
            const row = document.querySelector(`tr[data-driver-index="${index}"]`);
            if (row) {
                row.remove();
                updateSerialNumbers();
            }
        }
    }

    function resetDriverForm() {
        const form = document.getElementById('driver-form');
        form.querySelectorAll('input[type="text"], input[type="date"]').forEach(input => input.value = '');
        document.getElementById('edit-driver-id').value = '';
        document.getElementById('driver-index').value = driverIndex;
        document.getElementById('add-driver-btn').style.display = 'inline-block';
        document.getElementById('update-driver-btn').style.display = 'none';
        updateDriverFormIndex();
    }

    function updateDriverFormIndex() {
        const form = document.getElementById('driver-form');
        const index = document.getElementById('driver-index').value;
        form.querySelectorAll('input[name^="drivers"]').forEach(input => {
            const name = input.name.replace(/drivers\[\d+\]/, `drivers[${index}]`);
            input.name = name;
        });
    }

    function updateSerialNumbers() {
        const rows = document.querySelectorAll('#driver-table-body tr');
        rows.forEach((row, i) => {
            row.cells[0].textContent = i + 1;
        });
    }
// Tab Navigation
function openTab(tabName) {
    // Hide all tab contents
    const tabContentElements = document.getElementsByClassName('tab-content');
    for (let i = 0; i < tabContentElements.length; i++) {
        tabContentElements[i].style.display = 'none';
        tabContentElements[i].style.opacity = '0';
    }

    // Reset all tab buttons
    const tabButtons = document.getElementsByClassName('tab-button');
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].className = tabButtons[i].className.replace(' active', '');
        tabButtons[i].style.background = '#e5e7eb';
        tabButtons[i].style.color = '#374151';
        const hoverEffect = tabButtons[i].querySelector('.hover-effect');
        if (hoverEffect) {
            hoverEffect.style.left = '-100%';
        }
    }

    // Show the selected tab content
    const tabContent = document.getElementById(tabName + '-tab');
    if (tabContent) {
        tabContent.style.display = 'block';
        setTimeout(() => {
            tabContent.style.opacity = '1';
        }, 10);
    } else {
        console.error(`Tab content not found: ${tabName}-tab`);
        alert(`Tab "${tabName}" not found. Please check the configuration.`);
        return;
    }

    // Set the active button style
    const activeButton = Array.from(tabButtons).find(button => button.getAttribute('onclick').includes(`'${tabName}'`));
    if (activeButton) {
        activeButton.className += ' active';
        activeButton.style.background = 'linear-gradient(90deg, #f97316 0%, #ea580c 100%)';
        activeButton.style.color = 'white';
        const hoverEffect = activeButton.querySelector('.hover-effect');
        if (hoverEffect) {
            hoverEffect.style.left = '0';
            setTimeout(() => {
                hoverEffect.style.left = '-100%';
            }, 400);
        }
    }

    // Update navigation button states
    updateNavButtons();
}

// Validate current tab's required fields
function validateTab(tabContent) {
    const requiredInputs = tabContent.querySelectorAll('input[required], select[required]');
    for (let input of requiredInputs) {
        if (!input.value) {
            input.focus();
            alert(`Please fill in the required field: ${input.previousElementSibling.textContent}`);
            return false;
        }
    }
    return true;
}

// Next Tab Navigation
function nextTab() {
    const currentTab = document.getElementsByClassName('tab-button active')[0];
    if (!currentTab) {
        console.error('No active tab found');
        alert('Please select a tab to proceed.');
        return;
    }

    const currentTabContent = document.querySelector('.tab-content[style*="display: block"]');
    if (!validateTab(currentTabContent)) {
        return;
    }

    const tabs = document.getElementsByClassName('tab-button');
    const nextIndex = Array.from(tabs).indexOf(currentTab) + 1;
    if (nextIndex < tabs.length) {
        const tabName = tabs[nextIndex].getAttribute('onclick').match(/'([^']+)'/)[1];
        openTab(tabName);
    }
}

// Previous Tab Navigation
function previousTab() {
    const currentTab = document.getElementsByClassName('tab-button active')[0];
    if (!currentTab) {
        console.error('No active tab found');
        alert('Please select a tab to go back.');
        return;
    }

    const tabs = document.getElementsByClassName('tab-button');
    const prevIndex = Array.from(tabs).indexOf(currentTab) - 1;
    if (prevIndex >= 0) {
        const tabName = tabs[prevIndex].getAttribute('onclick').match(/'([^']+)'/)[1];
        openTab(tabName);
    }
}

// Update Navigation Button States
function updateNavButtons() {
    const currentTab = document.getElementsByClassName('tab-button active')[0];
    const tabs = document.getElementsByClassName('tab-button');
    const currentIndex = Array.from(tabs).indexOf(currentTab);
    
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    prevButton.disabled = currentIndex === 0;
    nextButton.disabled = currentIndex === tabs.length - 1;

    if (prevButton.disabled) {
        prevButton.style.background = '#d1d5db';
        prevButton.style.cursor = 'not-allowed';
    } else {
        prevButton.style.background = 'linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)';
        prevButton.style.cursor = 'pointer';
    }

    if (nextButton.disabled) {
        nextButton.style.background = '#d1d5db';
        nextButton.style.cursor = 'not-allowed';
    } else {
        nextButton.style.background = 'linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)';
        nextButton.style.cursor = 'pointer';
    }
}

// Initialize the first tab on page load
document.addEventListener('DOMContentLoaded', () => {
    openTab('owner');
});
</script>

<!-- CSS Animations -->
<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes slideIn {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.tab-button:hover .hover-effect {
    left: 100%;
}
button:disabled {
    background: #d1d5db !important;
    cursor: not-allowed !important;
    transform: none !important;
}
@media (max-width: 48rem) {
    .tab-content, .tab-button {
        width: 100% !important;
        max-width: 100% !important;
    }
    .tab-button {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    div[style*="flex-wrap: nowrap"] {
        flex-wrap: wrap;
    }
    div[style*="max-width: 49%"] {
        max-width: 100%;
        margin-bottom: 1rem;
    }
}
</style>
@endsection