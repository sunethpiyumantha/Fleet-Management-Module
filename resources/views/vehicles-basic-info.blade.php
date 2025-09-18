```blade
@extends('layouts.app')

@section('title', 'Vehicle Basic Information - ' . ($vehicle->serial_number ?? 'New Vehicle'))

@section('content')
<div style="width: 100%; padding: 20px; font-family: Arial, sans-serif; background: white;">

    <!-- Serial Number Display at the Top -->
    @if(isset($vehicle))
    <div style="background: #0077B6; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
        <h1 style="font-size: 1.875rem; font-weight: bold; margin: 0;">
            Vehicle Information - {{ $vehicle->serial_number }}
        </h1>
        <p style="margin: 0.5rem 0 0 0; font-size: 1rem; opacity: 0.9;">
            {{ ucfirst(str_replace('_', ' ', $vehicle->request_type)) }} Request
        </p>
    </div>
    @else
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
        Manage Vehicles
    </div>
    @endif

    <!-- Success or Error Messages -->
    @if (session('success'))
        <div style="background-color: #ADE8F4; color: #023E8A; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #CAF0F8; color: #03045E; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Quick Info Bar -->
    @if(isset($vehicle))
    <div style="display: flex; flex-wrap: wrap; gap: 1rem; background: #CAF0F8; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
        <div style="flex: 1; min-width: 200px;">
            <strong>Category:</strong> {{ $vehicle->category->category ?? 'N/A' }}
        </div>
        <div style="flex: 1; min-width: 200px;">
            <strong>Sub Category:</strong> {{ $vehicle->subCategory->sub_category ?? 'N/A' }}
        </div>
        <div style="flex: 1; min-width: 200px;">
            <strong>Status:</strong> 
            <span style="padding: 0.25rem 0.5rem; border-radius: 0.25rem; 
                @if($vehicle->status === 'approved') background-color: #10b981; color: white;
                @elseif($vehicle->status === 'rejected') background-color: #ef4444; color: white;
                @else background-color: #f59e0b; color: white; @endif">
                {{ ucfirst($vehicle->status) }}
            </span>
        </div>
    </div>
    @endif

    <!-- Modern Tabs Navigation -->
    <div class="tab-bar">
        <button type="button" class="tab-button active" onclick="openTab('tab1')">Vehicle Identification</button>
        <button type="button" class="tab-button" onclick="openTab('tab2')">Technical Specifications</button>
        <button type="button" class="tab-button" onclick="openTab('tab3')">Administrative & Legal</button>
        <button type="button" class="tab-button" onclick="openTab('tab4')">Operational & Workshop</button>
    </div>

    <!-- CSS for Tabs and Form -->
    <style>
        .tab-bar {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 1.5rem;
            background: #CAF0F8;
            padding: 0.25rem;
            border-radius: 5px;
        }
        .tab-button {
            background: #90E0EF;
            color: #03045E;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        .tab-button.active {
            background: #0077B6;
            color: white;
        }
        .tab-button:hover {
            background: #00B4D8;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block !important;
        }
        button:disabled {
            background: #d1d5db !important;
            cursor: not-allowed !important;
        }
        @media (max-width: 48rem) {
            .tab-button {
                width: 100%;
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }
        #imageContainer img {
            width: 100%;
            height: auto;
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            border-radius: 5px;
        }
    </style>

    <!-- Form -->
    <form style="margin-bottom: 20px;" method="POST" action="/vehicles/store" enctype="multipart/form-data">
        @csrf

        <!-- Hidden field to store the serial number -->
        @if(isset($vehicle))
        <input type="hidden" name="serial_number" value="{{ $vehicle->serial_number }}">
        @endif

        <!-- Tab 1: Vehicle Identification & Basic Details -->
        <div id="tab1" class="tab-content active">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Type</label>
                        <select id="vehicle_type" name="vehicle_type" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Vehicle Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_allocation_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Allocation Type</label>
                        <select id="vehicle_allocation_type" name="vehicle_allocation_type" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Allocation Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_army_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Army No</label>
                        <input type="text" id="vehicle_army_no" name="vehicle_army_no" value="{{ $vehicle->vehicle_army_no ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="civil_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Civil No</label>
                        <input type="text" id="civil_no" name="civil_no" value="{{ $vehicle->civil_no ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="chassis_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Chassis No</label>
                        <input type="text" id="chassis_no" name="chassis_no" value="{{ $vehicle->chassis_no ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="engine_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine No</label>
                        <input type="text" id="engine_no" name="engine_no" value="{{ $vehicle->engine_no ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_make" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Make</label>
                        <select id="vehicle_make" name="vehicle_make" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Make</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_model" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Model</label>
                        <select id="vehicle_model" name="vehicle_model" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Model</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_category" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Category</label>
                        <select id="vehicle_category" name="vehicle_category" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Category</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_sub_category" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Sub Category</label>
                        <select id="vehicle_sub_category" name="vehicle_sub_category" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Sub-Category</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="color" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Color</label>
                        <select id="color" name="color" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Color</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Status</label>
                        <select id="status" name="status" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Status</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="current_vehicle_status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Current Vehicle Status</label>
                        <select id="current_vehicle_status" name="current_vehicle_status" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Status</option>
                            <option value="on_road" {{ isset($vehicle->current_vehicle_status) && $vehicle->current_vehicle_status == 'on_road' ? 'selected' : '' }}>On Road</option>
                            <option value="off_road" {{ isset($vehicle->current_vehicle_status) && $vehicle->current_vehicle_status == 'off_road' ? 'selected' : '' }}>Off Road</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="t5_location" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">T5 Location (Estb)</label>
                        <select id="t5_location" name="t5_location" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Location</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="parking_place" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Parking Place</label>
                        <input type="text" id="parking_place" name="parking_place" value="{{ $vehicle->parking_place ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Technical Specifications -->
        <div id="tab2" class="tab-content">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="front_tire_size" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Front Tire Size</label>
                        <select id="front_tire_size" name="front_tire_size" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Front Tire Size</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="rear_tire_size" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Rear Tire Size</label>
                        <select id="rear_tire_size" name="rear_tire_size" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Rear Tire Size</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="engine_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine Capacity</label>
                        <select id="engine_capacity" name="engine_capacity" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Engine Capacity</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="fuel_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Fuel Type</label>
                        <select id="fuel_type" name="fuel_type" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Fuel Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="seating_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Seating Capacity</label>
                        <input type="text" id="seating_capacity" name="seating_capacity" value="{{ $vehicle->seating_capacity ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="gross_weight" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Gross Weight</label>
                        <input type="text" id="gross_weight" name="gross_weight" value="{{ $vehicle->gross_weight ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="tare_weight" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Tare Weight</label>
                        <input type="text" id="tare_weight" name="tare_weight" value="{{ $vehicle->tare_weight ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="load_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Load Capacity</label>
                        <input type="text" id="load_capacity" name="load_capacity" value="{{ $vehicle->load_capacity ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Administrative & Legal Information -->
        <div id="tab3" class="tab-content">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="acquired_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Acquired Date</label>
                        <input type="date" id="acquired_date" name="acquired_date" value="{{ $vehicle->acquired_date ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="handover_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Handover Date to Ordnance</label>
                        <input type="date" id="handover_date" name="handover_date" value="{{ $vehicle->handover_date ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="part_x_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Part X No (Itr Ref)</label>
                        <input type="text" id="part_x_no" name="part_x_no" value="{{ $vehicle->part_x_no ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="part_x_location" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Part X Location (Estb)</label>
                        <select id="part_x_location" name="part_x_location" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Location</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="part_x_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Part X Date</label>
                        <input type="date" id="part_x_date" name="part_x_date" value="{{ $vehicle->part_x_date ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="insurance_period_from" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Insurance Period From</label>
                        <input type="date" id="insurance_period_from" name="insurance_period_from" value="{{ $vehicle->insurance_period_from ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="insurance_period_to" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Insurance Period To</label>
                        <input type="date" id="insurance_period_to" name="insurance_period_to" value="{{ $vehicle->insurance_period_to ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="emission_test_status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Emission Test Status</label>
                        <select id="emission_test_status" name="emission_test_status" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Status</option>
                            <option value="yes" {{ isset($vehicle->emission_test_status) && $vehicle->emission_test_status == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ isset($vehicle->emission_test_status) && $vehicle->emission_test_status == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="emission_test_year" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Emission Test Year</label>
                        <input type="text" id="emission_test_year" name="emission_test_year" value="{{ $vehicle->emission_test_year ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Operational, Workshop & Miscellaneous Information -->
        <div id="tab4" class="tab-content">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="workshop" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Workshop</label>
                        <select id="workshop" name="workshop" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Workshop</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="admitted_workshop" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Admitted Workshop</label>
                        <select id="admitted_workshop" name="admitted_workshop" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Admitted Workshop</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="workshop_admitted_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Workshop Admitted Date</label>
                        <input type="date" id="workshop_admitted_date" name="workshop_admitted_date" value="{{ $vehicle->workshop_admitted_date ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="service_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Service Date</label>
                        <input type="text" id="service_date" name="service_date" value="{{ $vehicle->service_date ?? '' }}" readonly style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; background-color: #f3f4f6;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="next_service_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Next Service Date</label>
                        <input type="text" id="next_service_date" name="next_service_date" value="{{ $vehicle->next_service_date ?? '' }}" readonly style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; background-color: #f3f4f6;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="driver" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Driver</label>
                        <select id="driver" name="driver" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Driver</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="fault" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Fault</label>
                        <select id="fault" name="fault" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled selected>Select Fault</option>
                        </select>
                    </div>
                    <div style="flex: 2; min-width: 220px;">
                        <label for="remarks" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Remarks</label>
                        <textarea id="remarks" name="remarks" style="width: 100%; height: 100px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E; padding: 8px;">{{ $vehicle->remarks ?? '' }}</textarea>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="image_front" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Image (Front View)</label>
                        <input type="file" id="image_front" name="image_front" accept=".jpg,.png" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="image_rear" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Image (Rear View)</label>
                        <input type="file" id="image_rear" name="image_rear" accept=".jpg,.png" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="image_side" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Image (Side View)</label>
                        <input type="file" id="image_side" name="image_side" accept=".jpg,.png" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div style="width: 100%; display: flex; justify-content: center; margin-top: 15px;">
            <button type="submit" style="background-color: #00B4D8; color: white; font-weight: 600; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
            </button>
        </div>
    </form>

    <!-- Back Button -->
    @if(isset($vehicle))
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('vehicle.all.info') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-block; font-weight: 600;">
            ← Back to All Vehicles
        </a>
    </div>
    @endif

    <!-- Search Bar -->
    <form method="GET" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search Vehicles..." value="{{ request('search') }}" style="flex: 1; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
        <button type="submit" style="background-color: #0096C7; color: white; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;" onmouseover="this.style.backgroundColor='#023E8A'" onmouseout="this.style.backgroundColor='#0096C7'">🔍</button>
    </form>

    <!-- Vehicles Table -->
    <div style="overflow-x: auto;">
        <table id="vehicleTable" style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px; border: 1px solid #90E0EF;">
            <thead style="background: #023E8A; color: white; text-align: left;">
                <tr>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(0)">Vehicle Army No ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; cursor: pointer;" onclick="sortTable(1)">Vehicle Type ▲▼</th>
                    <th style="border: 1px solid #90E0EF; padding: 8px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" style="margin-top: 15px; text-align: center;"></div>

    <!-- Image Modal -->
    <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
        <div style="background: #CAF0F8; padding: 1.5rem; border-radius: 5px; max-width: 90%; max-height: 90%; overflow: auto;">
            <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #023E8A;">Vehicle Images</h3>
            <div id="imageContainer" style="display: flex; flex-wrap: wrap; gap: 1rem;"></div>
            <button onclick="closeImageModal()" style="margin-top: 1rem; background-color: #00B4D8; color: white; padding: 0.5rem 1rem; border-radius: 5px; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">Close</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Tab Switching
        function openTab(tabId) {
            const tabContents = document.querySelectorAll('.tab-content');
            const tabButtons = document.querySelectorAll('.tab-button');

            tabContents.forEach(tab => {
                tab.style.display = 'none';
                tab.classList.remove('active');
            });
            tabButtons.forEach(button => button.classList.remove('active'));

            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.style.display = 'block';
                selectedTab.classList.add('active');
                document.querySelector(`[onclick="openTab('${tabId}')"]`).classList.add('active');
            } else {
                console.error('Tab not found:', tabId);
            }
        }

        // Sub-category fetching
        document.getElementById('vehicle_category').addEventListener('change', function() {
            const catId = this.value;
            const subCatSelect = document.getElementById('vehicle_sub_category');
            subCatSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

            if (!catId) {
                subCatSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
                return;
            }

            fetch(`/get-sub-categories/${catId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                subCatSelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
                if (data.length === 0) {
                    subCatSelect.innerHTML = '<option value="" disabled selected>No sub-categories available</option>';
                } else {
                    data.forEach(subCat => {
                        const option = document.createElement('option');
                        option.value = subCat.id;
                        option.textContent = subCat.sub_category;
                        subCatSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching sub-categories:', error);
                subCatSelect.innerHTML = '<option value="" disabled selected>Error loading sub-categories</option>';
            });
        });

        // Pre-fill form with vehicle data if available
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($vehicle))
                document.getElementById('vehicle_type').value = '{{ $vehicle->vehicle_type ?? '' }}';
                document.getElementById('vehicle_allocation_type').value = '{{ $vehicle->vehicle_allocation_type ?? '' }}';
                document.getElementById('vehicle_make').value = '{{ $vehicle->vehicle_make ?? '' }}';
                document.getElementById('vehicle_model').value = '{{ $vehicle->vehicle_model ?? '' }}';
                document.getElementById('vehicle_category').value = '{{ $vehicle->vehicle_category ?? '' }}';
                document.getElementById('vehicle_sub_category').value = '{{ $vehicle->vehicle_sub_category ?? '' }}';
                document.getElementById('color').value = '{{ $vehicle->color ?? '' }}';
                document.getElementById('status').value = '{{ $vehicle->status ?? '' }}';
                document.getElementById('t5_location').value = '{{ $vehicle->t5_location ?? '' }}';
                document.getElementById('front_tire_size').value = '{{ $vehicle->front_tire_size ?? '' }}';
                document.getElementById('rear_tire_size').value = '{{ $vehicle->rear_tire_size ?? '' }}';
                document.getElementById('engine_capacity').value = '{{ $vehicle->engine_capacity ?? '' }}';
                document.getElementById('fuel_type').value = '{{ $vehicle->fuel_type ?? '' }}';
                document.getElementById('part_x_location').value = '{{ $vehicle->part_x_location ?? '' }}';
                document.getElementById('workshop').value = '{{ $vehicle->workshop ?? '' }}';
                document.getElementById('admitted_workshop').value = '{{ $vehicle->admitted_workshop ?? '' }}';
                document.getElementById('driver').value = '{{ $vehicle->driver ?? '' }}';
                document.getElementById('fault').value = '{{ $vehicle->fault ?? '' }}';
            @endif
        });

        // Image Modal
        function openImageModal(vehicleArmyNo, images) {
            const modal = document.getElementById('imageModal');
            const title = document.getElementById('modalTitle');
            const container = document.getElementById('imageContainer');

            title.textContent = `Vehicle Images for ${vehicleArmyNo}`;
            container.innerHTML = '';

            if (images.length === 0) {
                container.innerHTML = '<p>No images available.</p>';
            } else {
                images.forEach(src => {
                    const img = document.createElement('img');
                    img.src = src;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    img.style.borderRadius = '5px';
                    container.appendChild(img);
                });
            }

            modal.style.display = 'flex';
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Table Sorting + Pagination
        const rowsPerPage = 5;
        let currentPage = 1;
        let sortAsc = true;
        let tableRows = Array.from(document.querySelectorAll("#vehicleTable tbody tr"));

        function renderTable() {
            const search = document.getElementById("searchInput").value.toLowerCase();
            const filtered = tableRows.filter(row =>
                row.cells[0].innerText.toLowerCase().includes(search) ||
                row.cells[1].innerText.toLowerCase().includes(search)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginated = filtered.slice(start, start + rowsPerPage);

            const tbody = document.getElementById("tableBody");
            tbody.innerHTML = "";
            paginated.forEach(row => tbody.appendChild(row.cloneNode(true)));

            renderPagination(filtered.length);
        }

        function renderPagination(totalRows) {
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const container = document.getElementById("pagination");
            container.innerHTML = "";

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.style = "margin: 0 4px; padding: 5px 10px; background: #00B4D8; color: white; border: none; border-radius: 3px; cursor: pointer;";
                if (i === currentPage) {
                    btn.style.backgroundColor = "#023E8A";
                }
                btn.addEventListener("click", () => {
                    currentPage = i;
                    renderTable();
                });
                container.appendChild(btn);
            }
        }

        document.getElementById("searchInput").addEventListener("input", () => {
            currentPage = 1;
            renderTable();
        });

        function sortTable(colIndex) {
            sortAsc = !sortAsc;
            tableRows.sort((a, b) => {
                const textA = a.cells[colIndex].innerText.toLowerCase();
                const textB = b.cells[colIndex].innerText.toLowerCase();
                return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textA);
            });
            renderTable();
        }

        // Initial Render
        renderTable();
    </script>
</div>
@endsection
```