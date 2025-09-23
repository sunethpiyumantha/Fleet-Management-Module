@extends('layouts.app')

@section('title', 'Vehicle Declaration')

@section('content')
<style>
    body {
        background-color: white !important;
    }
</style>

<div style="width: 100%; max-width: 64rem; padding: 8px; font-family: Arial, sans-serif; background-color: white; margin: 0 auto;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <nav style="font-size: 14px;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #0077B6;">Home</a> /
            <span style="font-weight: bold; color: #023E8A;">Vehicle Declaration</span>
        </nav>
    </div>

    <!-- Blue Header -->
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <h5 style="font-weight: bold; margin: 0; color: #ffffff;">
            Declaration for Vehicle Hire to Army - Serial No: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? 'N/A') }}
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

    <!-- Form -->
    <div style="border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background-color: #f9fafb;">
        <form method="POST" action="{{ isset($declaration) ? route('vehicle.declaration.update', $declaration->id) : route('vehicle.declaration.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($declaration))
                @method('PUT')
                <input type="hidden" name="id" value="{{ $declaration->id }}">
            @endif
            <input type="hidden" name="serial_number" value="{{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? '') }}">

            <!-- Tab Navigation -->
            <div style="display: flex; gap: 0.5rem; justify-content: center; margin-bottom: 1rem; background: #f3f4f6; padding: 0.25rem; border-radius: 0.5rem;">
                <button type="button" class="tab-button active" onclick="openTab('owner')" style="background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600;">
                    Owner
                </button>
                <button type="button" class="tab-button" onclick="openTab('driver')" style="background: #e5e7eb; color: #374151; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600;">
                    Driver
                </button>
                <button type="button" class="tab-button" onclick="openTab('vehicle')" style="background: #e5e7eb; color: #374151; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600;">
                    Vehicle
                </button>
                <button type="button" class="tab-button" onclick="openTab('additional')" style="background: #e5e7eb; color: #374151; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600;">
                    Attachments
                </button>
            </div>

            <!-- Owner Tab -->
            <div id="owner-tab" class="tab-content" style="display: block; width: 100%; border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background: #f9fafb;">
                <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Owner Details (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? 'N/A') }})</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="registration_number" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Reg. Number</label>
                        <input type="text" id="registration_number" name="registration_number" required
                               value="{{ old('registration_number', $declaration->registration_number ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('registration_number')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owner_full_name" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Full Name</label>
                        <input type="text" id="owner_full_name" name="owner_full_name" required
                               value="{{ old('owner_full_name', $declaration->owner_full_name ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('owner_full_name')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owner_initials_name" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Name with Initials</label>
                        <input type="text" id="owner_initials_name" name="owner_initials_name" required
                               value="{{ old('owner_initials_name', $declaration->owner_initials_name ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('owner_initials_name')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owner_permanent_address" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Permanent Address</label>
                        <input type="text" id="owner_permanent_address" name="owner_permanent_address" required
                               value="{{ old('owner_permanent_address', $declaration->owner_permanent_address ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('owner_permanent_address')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owner_temporary_address" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Temporary Address (if any)</label>
                        <input type="text" id="owner_temporary_address" name="owner_temporary_address"
                               value="{{ old('owner_temporary_address', $declaration->owner_temporary_address ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('owner_temporary_address')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owner_phone_number" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Phone Number</label>
                        <input type="tel" id="owner_phone_number" name="owner_phone_number" required
                               value="{{ old('owner_phone_number', $declaration->owner_phone_number ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('owner_phone_number')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owner_bank_details" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Bank Account Details</label>
                        <input type="text" id="owner_bank_details" name="owner_bank_details" required
                               value="{{ old('owner_bank_details', $declaration->owner_bank_details ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('owner_bank_details')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Type</label>
                        <select id="vehicle_type" name="vehicle_type_id" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled {{ !old('vehicle_type_id', $declaration->vehicle_type_id ?? '') ? 'selected' : '' }}>Select Vehicle Type</option>
                            @foreach($vehicleTypes as $type)
                                <option value="{{ $type->id }}" {{ old('vehicle_type_id', $declaration->vehicle_type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_type_id')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_model" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Model</label>
                        <select id="vehicle_model" name="vehicle_model_id" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled {{ !old('vehicle_model_id', $declaration->vehicle_model_id ?? '') ? 'selected' : '' }}>Select Vehicle Model</option>
                            @foreach($vehicleModels as $model)
                                <option value="{{ $model->id }}" {{ old('vehicle_model_id', $declaration->vehicle_model_id ?? '') == $model->id ? 'selected' : '' }}>{{ $model->model }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_model_id')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="seats_registered" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Registered Seats</label>
                        <input type="number" id="seats_registered" name="seats_registered" min="1" required
                               value="{{ old('seats_registered', $declaration->seats_registered ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('seats_registered')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="seats_current" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Current Seats</label>
                        <input type="number" id="seats_current" name="seats_current" min="1" required
                               value="{{ old('seats_current', $declaration->seats_current ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('seats_current')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="loan_tax_details" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Loan/Tax Details</label>
                        <input type="text" id="loan_tax_details" name="loan_tax_details"
                               value="{{ old('loan_tax_details', $declaration->loan_tax_details ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('loan_tax_details')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="daily_rent" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Daily Rent</label>
                        <input type="number" id="daily_rent" name="daily_rent" min="0" step="0.01" required
                               value="{{ old('daily_rent', $declaration->daily_rent ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('daily_rent')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="induction_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Induction Date</label>
                        <input type="date" id="induction_date" name="induction_date" required
                               value="{{ old('induction_date', $declaration->induction_date ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('induction_date')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Driver Tab -->
            <div id="driver-tab" class="tab-content" style="display: none; width: 100%; border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background: #f9fafb;">
                <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Driver Details (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? 'N/A') }})</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Driver Form -->
                    <div id="driver-form">
                        <input type="hidden" id="driver-index" value="0">
                        <input type="hidden" id="edit-driver-id" name="drivers[0][id]">
                        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                            <div style="flex: 1; min-width: 220px;">
                                <label for="reg_nic" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Reg No / NIC</label>
                                <input type="text" id="reg_nic" name="drivers[0][reg_nic]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.reg_nic')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="rank" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Rank</label>
                                <input type="text" id="rank" name="drivers[0][rank]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.rank')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="driver_name" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Name</label>
                                <input type="text" id="driver_name" name="drivers[0][driver_name]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.driver_name')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="unit" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Unit</label>
                                <input type="text" id="unit" name="drivers[0][unit]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.unit')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="code_no_driver" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">If Staff Officer Vehicle, Code No</label>
                                <input type="text" id="code_no_driver" name="drivers[0][code_no_driver]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.code_no_driver')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="army_license_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Army / Driving License No</label>
                                <input type="text" id="army_license_no" name="drivers[0][army_license_no]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.army_license_no')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="license_issued_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">License Issued Date</label>
                                <input type="date" id="license_issued_date" name="drivers[0][license_issued_date]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.license_issued_date')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="flex: 1; min-width: 220px;">
                                <label for="license_expire_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">License Expire Date</label>
                                <input type="date" id="license_expire_date" name="drivers[0][license_expire_date]"
                                       style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                                @error('drivers.*.license_expire_date')
                                    <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
                            <button type="button" id="add-driver-btn" onclick="addDriver()" style="background: #00B4D8; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
                                    onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">Add Driver</button>
                            <button type="button" id="update-driver-btn" onclick="updateDriver()" style="display: none; background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
                                    onmouseover="this.style.backgroundColor='#005F8C'" onmouseout="this.style.backgroundColor='#0077B6'">Update Driver</button>
                            <button type="button" onclick="resetDriverForm()" style="background: #6b7280; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
                                    onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">Clear Form</button>
                        </div>
                    </div>
                    <!-- Driver Table -->
                    <div style="margin-top: 1rem; overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                            <thead>
                                <tr style="background-color: #f3f4f6;">
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">SN</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Reg No / NIC</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Rank</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Name</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Unit</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Code No</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">License No</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Issued Date</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Expire Date</th>
                                    <th style="border: 1px solid #90E0EF; padding: 8px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="driver-table-body">
                                @if(isset($declaration) && $declaration->drivers)
                                    @foreach($declaration->drivers as $index => $driver)
                                        <tr data-driver-id="{{ $driver->id }}" data-driver-index="{{ $index }}">
                                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->reg_nic }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->rank }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->driver_name }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->unit }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->code_no_driver ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->army_license_no }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->license_issued_date }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px;">{{ $driver->license_expire_date }}</td>
                                            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                                                <button type="button" onclick="editDriver({{ $index }})" style="background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; margin-right: 0.5rem;"
                                                        onmouseover="this.style.backgroundColor='#005F8C'" onmouseout="this.style.backgroundColor='#0077B6'">Edit</button>
                                                <button type="button" onclick="deleteDriver({{ $index }})" style="background: #dc2626; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;"
                                                        onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
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
            <div id="vehicle-tab" class="tab-content" style="display: none; width: 100%; border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background: #f9fafb;">
                <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Vehicle Details (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? 'N/A') }})</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="civil_number" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">{{ $requestType === 'new_approval' ? 'Civil Number' : 'Army Number' }}</label>
                        <input type="text" id="civil_number" name="civil_number" required
                               value="{{ old('civil_number', $declaration->civil_number ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('civil_number')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="product_classification" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Product Classification</label>
                        <input type="text" id="product_classification" name="product_classification" required
                               value="{{ old('product_classification', $declaration->product_classification ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('product_classification')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="engine_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine No</label>
                        <input type="text" id="engine_no" name="engine_no" required
                               value="{{ old('engine_no', $declaration->engine_no ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('engine_no')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="chassis_number" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Chassis Number</label>
                        <input type="text" id="chassis_number" name="chassis_number" required
                               value="{{ old('chassis_number', $declaration->chassis_number ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('chassis_number')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="year_of_manufacture" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Year of Manufacture</label>
                        <input type="number" id="year_of_manufacture" name="year_of_manufacture" min="1900" required
                               value="{{ old('year_of_manufacture', $declaration->year_of_manufacture ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('year_of_manufacture')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="date_of_original_registration" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Date of Original Registration</label>
                        <input type="date" id="date_of_original_registration" name="date_of_original_registration" required
                               value="{{ old('date_of_original_registration', $declaration->date_of_original_registration ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('date_of_original_registration')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="engine_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine Capacity</label>
                        <select id="engine_capacity" name="engine_capacity_id" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled {{ !old('engine_capacity_id', $declaration->engine_capacity_id ?? '') ? 'selected' : '' }}>Select Engine Capacity</option>
                            @foreach($engineCapacities as $capacity)
                                <option value="{{ $capacity->id }}" {{ old('engine_capacity_id', $declaration->engine_capacity_id ?? '') == $capacity->id ? 'selected' : '' }}>{{ $capacity->engine_capacity }}</option>
                            @endforeach
                        </select>
                        @error('engine_capacity_id')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="section_4_w_2w" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Section 4 W/2W</label>
                        <input type="text" id="section_4_w_2w" name="section_4_w_2w" required
                               value="{{ old('section_4_w_2w', $declaration->section_4_w_2w ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('section_4_w_2w')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="speedometer_hours" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Speedometer Hours at Takeover</label>
                        <input type="number" id="speedometer_hours" name="speedometer_hours" min="0" required
                               value="{{ old('speedometer_hours', $declaration->speedometer_hours ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('speedometer_hours')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="code_no_vehicle" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Code No</label>
                        <input type="text" id="code_no_vehicle" name="code_no_vehicle" required
                               value="{{ old('code_no_vehicle', $declaration->code_no_vehicle ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('code_no_vehicle')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="color" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Color</label>
                        <select id="color" name="color_id" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled {{ !old('color_id', $declaration->color_id ?? '') ? 'selected' : '' }}>Select Color</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" {{ old('color_id', $declaration->color_id ?? '') == $color->id ? 'selected' : '' }}>{{ $color->color }}</option>
                            @endforeach
                        </select>
                        @error('color_id')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="pay_per_day" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Pay per Day</label>
                        <input type="number" id="pay_per_day" name="pay_per_day" min="0" step="0.01" required
                               value="{{ old('pay_per_day', $declaration->pay_per_day ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('pay_per_day')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="fuel_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Type of Fuel</label>
                        <select id="fuel_type" name="fuel_type_id" required
                                style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled {{ !old('fuel_type_id', $declaration->fuel_type_id ?? '') ? 'selected' : '' }}>Select Fuel Type</option>
                            @foreach($fuelTypes as $fuel)
                                <option value="{{ $fuel->id }}" {{ old('fuel_type_id', $declaration->fuel_type_id ?? '') == $fuel->id ? 'selected' : '' }}>{{ $fuel->fuel_type }}</option>
                            @endforeach
                        </select>
                        @error('fuel_type_id')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="tar_weight_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">TAR Weight Capacity</label>
                        <input type="text" id="tar_weight_capacity" name="tar_weight_capacity" required
                               value="{{ old('tar_weight_capacity', $declaration->tar_weight_capacity ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('tar_weight_capacity')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="amount_of_fuel" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Amount of Fuel</label>
                        <input type="number" id="amount_of_fuel" name="amount_of_fuel" min="0" step="0.01" required
                               value="{{ old('amount_of_fuel', $declaration->amount_of_fuel ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('amount_of_fuel')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="reason_for_taking_over" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Reason for Taking Over</label>
                        <input type="text" id="reason_for_taking_over" name="reason_for_taking_over" required
                               value="{{ old('reason_for_taking_over', $declaration->reason_for_taking_over ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('reason_for_taking_over')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="other_matters" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Other Matters</label>
                        <input type="text" id="other_matters" name="other_matters"
                               value="{{ old('other_matters', $declaration->other_matters ?? '') }}"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @error('other_matters')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Attachments Tab -->
            <div id="additional-tab" class="tab-content" style="display: none; width: 100%; border: 1px solid #90E0EF; border-radius: 5px; padding: 1rem; background: #f9fafb;">
                <h3 style="font-size: 16px; font-weight: bold; color: #023E8A; margin-bottom: 1rem;">Attachments (Serial: {{ old('serial_number', $declaration->serial_number ?? request('serial_number') ?? 'N/A') }})</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="registration_certificate" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Registration Certificate</label>
                        <input type="file" id="registration_certificate" name="registration_certificate" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->registration_certificate))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->registration_certificate) }}</span>
                        @endif
                        @error('registration_certificate')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="insurance_certificate" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Insurance Certificate</label>
                        <input type="file" id="insurance_certificate" name="insurance_certificate" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->insurance_certificate))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->insurance_certificate) }}</span>
                        @endif
                        @error('insurance_certificate')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="revenue_license_certificate" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Revenue License Certificate</label>
                        <input type="file" id="revenue_license_certificate" name="revenue_license_certificate" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->revenue_license_certificate))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->revenue_license_certificate) }}</span>
                        @endif
                        @error('revenue_license_certificate')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owners_certified_nic" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Owner's Certified NIC</label>
                        <input type="file" id="owners_certified_nic" name="owners_certified_nic" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->owners_certified_nic))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->owners_certified_nic) }}</span>
                        @endif
                        @error('owners_certified_nic')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="owners_certified_bank_passbook" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Owner's Certified Bank Passbook</label>
                        <input type="file" id="owners_certified_bank_passbook" name="owners_certified_bank_passbook" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->owners_certified_bank_passbook))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->owners_certified_bank_passbook) }}</span>
                        @endif
                        @error('owners_certified_bank_passbook')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="suppliers_scanned_sign_document" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Suppliers Scanned Sign Document</label>
                        <input type="file" id="suppliers_scanned_sign_document" name="suppliers_scanned_sign_document" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->suppliers_scanned_sign_document))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->suppliers_scanned_sign_document) }}</span>
                        @endif
                        @error('suppliers_scanned_sign_document')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="affidavit_non_joint_account" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Affidavit Non-Joint Account</label>
                        <input type="file" id="affidavit_non_joint_account" name="affidavit_non_joint_account" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->affidavit_non_joint_account))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->affidavit_non_joint_account) }}</span>
                        @endif
                        @error('affidavit_non_joint_account')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="affidavit_army_driver" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Affidavit Army Driver</label>
                        <input type="file" id="affidavit_army_driver" name="affidavit_army_driver" accept=".pdf,.jpg,.png"
                               style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if(isset($declaration->affidavit_army_driver))
                            <span style="font-size: 12px; color: #4b5563;">Current file: {{ basename($declaration->affidavit_army_driver) }}</span>
                        @endif
                        @error('affidavit_army_driver')
                            <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: center; width: 100%; margin-top: 1rem;">
                <button type="button" id="prevButton" onclick="previousTab()" style="background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
                        onmouseover="this.style.backgroundColor='#005F8C'" onmouseout="this.style.backgroundColor='#0077B6'" disabled>Previous</button>
                <button type="button" id="nextButton" onclick="nextTab()" style="background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
                        onmouseover="this.style.backgroundColor='#005F8C'" onmouseout="this.style.backgroundColor='#0077B6'">Next</button>
            </div>

            <!-- Submit Button -->
            <div style="width: 100%; display: flex; justify-content: center; margin-top: 1rem;">
                <button type="submit"
                        style="background: #00B4D8; color: white; font-weight: 600; padding: 0.5rem 1.5rem; border-radius: 5px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    <i class="fa-solid fa-save" style="margin-right: 0.5rem;"></i> {{ isset($declaration) ? 'Update Declaration' : 'Save Declaration' }}
                </button>
            </div>
        </form>
    </div>
</div>

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
        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">${tableBody.children.length + 1}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${regNic}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${rank}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${driverName}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${unit}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${codeNoDriver || 'N/A'}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${armyLicenseNo}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${licenseIssuedDate}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px;">${licenseExpireDate}</td>
        <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
            <button type="button" onclick="editDriver(${driverIndex})" style="background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; margin-right: 0.5rem;"
                    onmouseover="this.style.backgroundColor='#005F8C'" onmouseout="this.style.backgroundColor='#0077B6'">Edit</button>
            <button type="button" onclick="deleteDriver(${driverIndex})" style="background: #dc2626; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
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
            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">${Array.from(row.parentNode.children).indexOf(row) + 1}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${regNic}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${rank}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${driverName}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${unit}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${codeNoDriver || 'N/A'}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${armyLicenseNo}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${licenseIssuedDate}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px;">${licenseExpireDate}</td>
            <td style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">
                <button type="button" onclick="editDriver(${index})" style="background: #0077B6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; margin-right: 0.5rem;"
                        onmouseover="this.style.backgroundColor='#005F8C'" onmouseout="this.style.backgroundColor='#0077B6'">Edit</button>
                <button type="button" onclick="deleteDriver(${index})" style="background: #dc2626; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">Delete</button>
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

function openTab(tabName) {
    const tabContentElements = document.getElementsByClassName('tab-content');
    for (let i = 0; i < tabContentElements.length; i++) {
        tabContentElements[i].style.display = 'none';
    }

    const tabButtons = document.getElementsByClassName('tab-button');
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].className = tabButtons[i].className.replace(' active', '');
        tabButtons[i].style.background = '#e5e7eb';
        tabButtons[i].style.color = '#374151';
    }

    const tabContent = document.getElementById(tabName + '-tab');
    if (tabContent) {
        tabContent.style.display = 'block';
    } else {
        console.error(`Tab content not found: ${tabName}-tab`);
        alert(`Tab "${tabName}" not found. Please check the configuration.`);
        return;
    }

    const activeButton = Array.from(tabButtons).find(button => button.getAttribute('onclick').includes(`'${tabName}'`));
    if (activeButton) {
        activeButton.className += ' active';
        activeButton.style.background = '#0077B6';
        activeButton.style.color = 'white';
    }

    updateNavButtons();
}

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