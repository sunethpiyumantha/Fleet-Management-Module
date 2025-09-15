@extends('layouts.app')

@section('title', 'Vehicle Basic Information - ' . ($vehicle->serial_number ?? 'New Vehicle'))

@section('content')
<div style="max-width: 80rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        
        <!-- Serial Number Display at the Top -->
        @if(isset($vehicle))
        <div style="background: linear-gradient(90deg, #f97316 0%, #ea580c 100%); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: center;">
            <h1 style="font-size: 1.875rem; font-weight: bold; margin: 0;">
                Vehicle Information - {{ $vehicle->serial_number }}
            </h1>
            <p style="margin: 0.5rem 0 0 0; font-size: 1rem; opacity: 0.9;">
                {{ ucfirst(str_replace('_', ' ', $vehicle->request_type)) }} Request
            </p>
        </div>
        @else
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Vehicle Management</h2>
        @endif

        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Quick Info Bar -->
        @if(isset($vehicle))
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; background: #f3f4f6; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
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
                background: #f3f4f6;
                padding: 0.25rem;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                flex-wrap: wrap;
            }
            .tab-button {
                background: #e5e7eb;
                color: #000;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 0.375rem;
                cursor: pointer;
                transition: all 0.3s ease;
                font-weight: 600;
                position: relative;
                overflow: hidden;
            }
            .tab-button.active {
                background: linear-gradient(90deg, #f97316 0%, #ea580c 100%);
                color: #fff;
                border-bottom: 2px solid #f97316;
            }
            .tab-button:hover {
                background: #d1d5db;
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
                border-radius: 0.25rem;
            }
        </style>

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;" method="POST" action="/vehicles/store" enctype="multipart/form-data">
            @csrf

            <!-- Hidden field to store the serial number -->
            @if(isset($vehicle))
            <input type="hidden" name="serial_number" value="{{ $vehicle->serial_number }}">
            @endif

            <!-- Tab 1: Vehicle Identification & Basic Details -->
            <div id="tab1" class="tab-content active">
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Type</label>
                            <select id="vehicle_type" name="vehicle_type" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Vehicle Type</option>
                                <!-- Add options dynamically or statically -->
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_allocation_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Allocation Type</label>
                            <select id="vehicle_allocation_type" name="vehicle_allocation_type" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Allocation Type</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_army_no" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Army No</label>
                            <input type="text" id="vehicle_army_no" name="vehicle_army_no" value="{{ $vehicle->vehicle_army_no ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="civil_no" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Civil No</label>
                            <input type="text" id="civil_no" name="civil_no" value="{{ $vehicle->civil_no ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="chassis_no" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Chassis No</label>
                            <input type="text" id="chassis_no" name="chassis_no" value="{{ $vehicle->chassis_no ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="engine_no" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine No</label>
                            <input type="text" id="engine_no" name="engine_no" value="{{ $vehicle->engine_no ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_make" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Make</label>
                            <select id="vehicle_make" name="vehicle_make" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Make</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_model" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Model</label>
                            <select id="vehicle_model" name="vehicle_model" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Model</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_category" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Category</label>
                            <select id="vehicle_category" name="vehicle_category" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Category</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="vehicle_sub_category" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Sub Category</label>
                            <select id="vehicle_sub_category" name="vehicle_sub_category" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Sub-Category</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="color" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Color</label>
                            <select id="color" name="color" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Color</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="status" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Status</label>
                            <select id="status" name="status" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Status</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="current_vehicle_status" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Current Vehicle Status</label>
                            <select id="current_vehicle_status" name="current_vehicle_status" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Status</option>
                                <option value="on_road" {{ isset($vehicle->current_vehicle_status) && $vehicle->current_vehicle_status == 'on_road' ? 'selected' : '' }}>On Road</option>
                                <option value="off_road" {{ isset($vehicle->current_vehicle_status) && $vehicle->current_vehicle_status == 'off_road' ? 'selected' : '' }}>Off Road</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="t5_location" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">T5 Location (Estb)</label>
                            <select id="t5_location" name="t5_location" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Location</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="parking_place" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Parking Place</label>
                            <input type="text" id="parking_place" name="parking_place" value="{{ $vehicle->parking_place ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Technical Specifications -->
            <div id="tab2" class="tab-content">
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="front_tire_size" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Front Tire Size</label>
                            <select id="front_tire_size" name="front_tire_size" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Front Tire Size</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="rear_tire_size" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Rear Tire Size</label>
                            <select id="rear_tire_size" name="rear_tire_size" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Rear Tire Size</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="engine_capacity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Engine Capacity</label>
                            <select id="engine_capacity" name="engine_capacity" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Engine Capacity</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="fuel_type" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Fuel Type</label>
                            <select id="fuel_type" name="fuel_type" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Fuel Type</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="seating_capacity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Seating Capacity</label>
                            <input type="text" id="seating_capacity" name="seating_capacity" value="{{ $vehicle->seating_capacity ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="gross_weight" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Gross Weight</label>
                            <input type="text" id="gross_weight" name="gross_weight" value="{{ $vehicle->gross_weight ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="tare_weight" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Tare Weight</label>
                            <input type="text" id="tare_weight" name="tare_weight" value="{{ $vehicle->tare_weight ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="load_capacity" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Load Capacity</label>
                            <input type="text" id="load_capacity" name="load_capacity" value="{{ $vehicle->load_capacity ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Administrative & Legal Information -->
            <div id="tab3" class="tab-content">
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="acquired_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Acquired Date</label>
                            <input type="date" id="acquired_date" name="acquired_date" value="{{ $vehicle->acquired_date ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="handover_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Handover Date to Ordnance</label>
                            <input type="date" id="handover_date" name="handover_date" value="{{ $vehicle->handover_date ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="part_x_no" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Part X No (Itr Ref)</label>
                            <input type="text" id="part_x_no" name="part_x_no" value="{{ $vehicle->part_x_no ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="part_x_location" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Part X Location (Estb)</label>
                            <select id="part_x_location" name="part_x_location" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Location</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="part_x_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Part X Date</label>
                            <input type="date" id="part_x_date" name="part_x_date" value="{{ $vehicle->part_x_date ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="insurance_period_from" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Insurance Period From</label>
                            <input type="date" id="insurance_period_from" name="insurance_period_from" value="{{ $vehicle->insurance_period_from ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="insurance_period_to" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Insurance Period To</label>
                            <input type="date" id="insurance_period_to" name="insurance_period_to" value="{{ $vehicle->insurance_period_to ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="emission_test_status" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Emission Test Status</label>
                            <select id="emission_test_status" name="emission_test_status" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Status</option>
                                <option value="yes" {{ isset($vehicle->emission_test_status) && $vehicle->emission_test_status == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ isset($vehicle->emission_test_status) && $vehicle->emission_test_status == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="emission_test_year" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Emission Test Year</label>
                            <input type="text" id="emission_test_year" name="emission_test_year" value="{{ $vehicle->emission_test_year ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Operational, Workshop & Miscellaneous Information -->
            <div id="tab4" class="tab-content">
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="workshop" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Workshop</label>
                            <select id="workshop" name="workshop" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Workshop</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="admitted_workshop" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Admitted Workshop</label>
                            <select id="admitted_workshop" name="admitted_workshop" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Admitted Workshop</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="workshop_admitted_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Workshop Admitted Date</label>
                            <input type="date" id="workshop_admitted_date" name="workshop_admitted_date" value="{{ $vehicle->workshop_admitted_date ?? '' }}" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="service_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Service Date</label>
                            <input type="text" id="service_date" name="service_date" value="{{ $vehicle->service_date ?? '' }}" readonly style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; background-color: #f3f4f6;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="next_service_date" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Next Service Date</label>
                            <input type="text" id="next_service_date" name="next_service_date" value="{{ $vehicle->next_service_date ?? '' }}" readonly style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem; background-color: #f3f4f6;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="driver" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Driver</label>
                            <select id="driver" name="driver" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Driver</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="fault" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Fault</label>
                            <select id="fault" name="fault" required style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                                <option value="" disabled selected>Select Fault</option>
                            </select>
                        </div>
                        <div style="flex: 1 1 500px;">
                            <label for="remarks" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Remarks</label>
                            <textarea id="remarks" name="remarks" style="width: 100%; height: 100px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">{{ $vehicle->remarks ?? '' }}</textarea>
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: nowrap; gap: 1rem; justify-content: center; width: 100%; max-width: 900px;">
                        <div style="flex: 1 1 250px;">
                            <label for="image_front" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image (Front View)</label>
                            <input type="file" id="image_front" name="image_front" accept=".jpg,.png" style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="image_rear" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image (Rear View)</label>
                            <input type="file" id="image_rear" name="image_rear" accept=".jpg,.png" style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                        <div style="flex: 1 1 250px;">
                            <label for="image_side" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Vehicle Image (Side View)</label>
                            <input type="file" id="image_side" name="image_side" accept=".jpg,.png" style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div style="width: 100%; display: flex; justify-content: center; margin-top: 1.5rem;">
                <button type="submit" style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                    <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Submit
                </button>
            </div>
        </form>

        <!-- Back Button -->
        @if(isset($vehicle))
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('vehicle.all.info') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; display: inline-block; font-weight: 600;">
                ← Back to All Vehicles
            </a>
        </div>
        @endif

        <!-- Image Modal -->
        <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
            <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; max-width: 90%; max-height: 90%; overflow: auto;">
                <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Vehicle Images</h3>
                <div id="imageContainer" style="display: flex; flex-wrap: wrap; gap: 1rem;"></div>
                <button onclick="closeImageModal()" style="margin-top: 1rem; background-color: #f97316; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                    Close
                </button>
            </div>
        </div>

        <script>
            // Tab Switching
            function openTab(tabId) {
                const tabContents = document.querySelectorAll('.tab-content');
                const tabButtons = document.querySelectorAll('.tab-button');
                
                tabContents.forEach(tab => {
                    tab.style.display = 'none';
                    tab.classList.remove('active');
                });
                tabButtons.forEach(button => {
                    button.classList.remove('active');
                    button.style.borderBottom = '2px solid transparent';
                });

                const selectedTab = document.getElementById(tabId);
                if (selectedTab) {
                    selectedTab.style.display = 'block';
                    selectedTab.classList.add('active');
                    const selectedButton = document.querySelector(`[onclick="openTab('${tabId}')"]`);
                    if (selectedButton) {
                        selectedButton.classList.add('active');
                        selectedButton.style.borderBottom = '2px solid #f97316';
                    }
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
                    // Pre-fill form fields
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
                        img.style.borderRadius = '0.25rem';
                        container.appendChild(img);
                    });
                }

                modal.style.display = 'flex';
            }

            function closeImageModal() {
                document.getElementById('imageModal').style.display = 'none';
            }
        </script>
    </div>
</div>
@endsection