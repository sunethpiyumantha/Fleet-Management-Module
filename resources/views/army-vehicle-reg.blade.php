@extends('layouts.app')

@section('title', 'Army Vehicle Information - ' . ($vehicle->serial_number ?? 'New Vehicle'))

@section('content')
<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background: white;">
    @if(isset($vehicle))
    <div style="background: #0077B6; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
        <h1 style="font-size: 1.875rem; font-weight: bold; margin: 0;">Army Vehicle Information - {{ $vehicle->serial_number }}</h1>
        <p style="margin: 0.5rem 0 0 0; font-size: 1rem; opacity: 0.9;">{{ ucfirst(str_replace('_', ' ', $vehicle->request_type ?? '')) }} Request</p>
    </div>
    @else
    <div style="background: #0077B6; color: white; font-weight: bold; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">Army Vehicle registration</div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
        <div style="background-color: #adf4c9; color: #006519; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error / Delete Messages -->
    @if (session('error'))
        <div style="background-color: #f8d7da; color: #842029; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #842029; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li style="margin-bottom: 0.25rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($vehicle))
    <div style="display: flex; flex-wrap: wrap; gap: 1rem; background: #CAF0F8; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
        <div style="flex: 1; min-width: 200px;"><strong>Category:</strong> {{ $vehicle->category->category ?? 'N/A' }}</div>
        <div style="flex: 1; min-width: 200px;"><strong>Sub Category:</strong> {{ $vehicle->subCategory->sub_category ?? 'N/A' }}</div>
        <div style="flex: 1; min-width: 200px;"><strong>Status:</strong> 
            <span style="padding: 0.25rem 0.5rem; border-radius: 0.25rem; 
                @if($vehicle->status_id && $vehicle->status->name === 'approved') background-color: #10b981; color: white; 
                @elseif($vehicle->status_id && $vehicle->status->name === 'rejected') background-color: #ef4444; color: white; 
                @else background-color: #f59e0b; color: white; @endif">
                {{ ucfirst($vehicle->status->name ?? 'pending') }}
            </span>
        </div>
    </div>
    @endif

    <!-- Tab Bar -->
    <div style="display: flex; gap: 0.75rem; justify-content: center; margin-bottom: 1.5rem; background: #CAF0F8; padding: 0.25rem; border-radius: 5px; flex-wrap: wrap;">
        <button type="button" onclick="openTab('tab1')" style="background: #0077B6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; min-width: 140px;">Vehicle Identification</button>
        <button type="button" onclick="openTab('tab2')" style="background: #90E0EF; color: #03045E; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; min-width: 140px;">Technical Specifications</button>
        <button type="button" onclick="openTab('tab3')" style="background: #90E0EF; color: #03045E; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; min-width: 140px;">Administrative & Legal</button>
        <button type="button" onclick="openTab('tab4')" style="background: #90E0EF; color: #03045E; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; min-width: 140px;">Operational & Workshop</button>
    </div>

    <form method="POST" @if(isset($vehicle)) action="{{ route('army-vehicles.update', $vehicle->serial_number) }}" @method('PUT') @else action="{{ route('army-vehicles.store') }}" @endif enctype="multipart/form-data" style="max-width: 1000px; margin: 0 auto;">
        @csrf
        @if(isset($vehicle))
        <input type="hidden" name="serial_number" value="{{ $vehicle->serial_number }}">
        @endif

        <!-- Tab 1: Vehicle Identification -->
        <div id="tab1" style="display: block; background: #f8fdff; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Type</label>
                        <select name="vehicle_type" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="vehicle_type">
                            <option value="" disabled selected>Select Vehicle Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Allocation Type</label>
                        <select name="vehicle_allocation_type" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="vehicle_allocation_type">
                            <option value="" disabled selected>Select Allocation Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Army No</label>
                        <input type="text" name="vehicle_army_no" value="{{ $vehicle->vehicle_army_no ?? '' }}" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Civil No</label>
                        <input type="text" name="civil_no" value="{{ $vehicle->civil_no ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Chassis No</label>
                        <input type="text" name="chassis_no" value="{{ $vehicle->chassis_no ?? '' }}" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Engine No</label>
                        <input type="text" name="engine_no" value="{{ $vehicle->engine_no ?? '' }}" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Make</label>
                        <select name="vehicle_make" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="vehicle_make">
                            <option value="" disabled selected>Select Make</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Model</label>
                        <select name="vehicle_model" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="vehicle_model">
                            <option value="" disabled selected>Select Model</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Category</label>
                        <select name="vehicle_category" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="vehicle_category">
                            <option value="" disabled selected>Select Category</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Sub Category</label>
                        <select name="vehicle_sub_category" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="vehicle_sub_category">
                            <option value="" disabled selected>Select Sub-Category</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Color</label>
                        <select name="color" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="color">
                            <option value="" disabled selected>Select Color</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Status</label>
                        <select name="status" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="status">
                            <option value="" disabled selected>Select Status</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Current Vehicle Status</label>
                        <select name="current_vehicle_status" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                            <option value="" disabled selected>Select Status</option>
                            <option value="on_road" {{ isset($vehicle) && $vehicle->current_vehicle_status == 'on_road' ? 'selected' : '' }}>On Road</option>
                            <option value="off_road" {{ isset($vehicle) && $vehicle->current_vehicle_status == 'off_road' ? 'selected' : '' }}>Off Road</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">T5 Location (Estb)</label>
                        <input type="text" name="t5_location" value="{{ $vehicle->t5_location ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Parking Place</label>
                        <input type="text" name="parking_place" value="{{ $vehicle->parking_place ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Technical Specifications -->
        <div id="tab2" style="display: none; background: #f8fdff; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Front Tire Size</label>
                        <select name="front_tire_size" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="front_tire_size">
                            <option value="" disabled selected>Select Front Tire Size</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Rear Tire Size</label>
                        <select name="rear_tire_size" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="rear_tire_size">
                            <option value="" disabled selected>Select Rear Tire Size</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Engine Capacity</label>
                        <select name="engine_capacity" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="engine_capacity">
                            <option value="" disabled selected>Select Engine Capacity</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Fuel Type</label>
                        <select name="fuel_type" required style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="fuel_type">
                            <option value="" disabled selected>Select Fuel Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Seating Capacity</label>
                        <input type="number" name="seating_capacity" value="{{ $vehicle->seating_capacity ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Gross Weight</label>
                        <input type="number" step="0.01" name="gross_weight" value="{{ $vehicle->gross_weight ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Tare Weight</label>
                        <input type="number" step="0.01" name="tare_weight" value="{{ $vehicle->tare_weight ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Load Capacity</label>
                        <input type="number" step="0.01" name="load_capacity" value="{{ $vehicle->load_capacity ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Administrative & Legal -->
        <div id="tab3" style="display: none; background: #f8fdff; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Acquired Date</label>
                        <input type="date" name="acquired_date" value="{{ $vehicle->acquired_date ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Handover Date to Ordnance</label>
                        <input type="date" name="handover_date" value="{{ $vehicle->handover_date ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Part X No (Itr Ref)</label>
                        <input type="text" name="part_x_no" value="{{ $vehicle->part_x_no ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Part X Location (Estb)</label>
                        <input type="text" name="part_x_location" value="{{ $vehicle->part_x_location ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Part X Date</label>
                        <input type="date" name="part_x_date" value="{{ $vehicle->part_x_date ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Insurance Period From</label>
                        <input type="date" name="insurance_period_from" value="{{ $vehicle->insurance_period_from ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Insurance Period To</label>
                        <input type="date" name="insurance_period_to" value="{{ $vehicle->insurance_period_to ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Emission Test Status</label>
                        <select name="emission_test_status" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                            <option value="" disabled selected>Select Status</option>
                            <option value="yes" {{ isset($vehicle) && $vehicle->emission_test_status == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ isset($vehicle) && $vehicle->emission_test_status == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Emission Test Year</label>
                        <input type="number" name="emission_test_year" value="{{ $vehicle->emission_test_year ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Operational & Workshop -->
        <div id="tab4" style="display: none; background: #f8fdff; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Workshop</label>
                        <select name="workshop" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="workshop">
                            <option value="" disabled selected>Select Workshop</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Admitted Workshop</label>
                        <select name="admitted_workshop" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="admitted_workshop">
                            <option value="" disabled selected>Select Admitted Workshop</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Workshop Admitted Date</label>
                        <input type="date" name="workshop_admitted_date" value="{{ $vehicle->workshop_admitted_date ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Service Date</label>
                        <input type="date" name="service_date" value="{{ $vehicle->service_date ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Next Service Date</label>
                        <input type="date" name="next_service_date" value="{{ $vehicle->next_service_date ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Driver</label>
                        <select name="driver" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;" id="driver">
                            <option value="" disabled selected>Select Driver</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Fault</label>
                        <input type="text" name="fault" value="{{ $vehicle->fault ?? '' }}" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                    </div>
                    <div style="flex: 2; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Remarks</label>
                        <textarea name="remarks" style="width: 100%; height: 100px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; padding: 10px; background: white; font-size: 14px;">{{ $vehicle->remarks ?? '' }}</textarea>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Image (Front View)</label>
                        <input type="file" name="image_front" accept=".jpg,.png" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                        @if(isset($vehicle) && $vehicle->image_front)
                        <img src="{{ Storage::url($vehicle->image_front) }}" alt="Front View" style="max-width: 100px; margin-top: 5px;">
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Image (Rear View)</label>
                        <input type="file" name="image_rear" accept=".jpg,.png" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                        @if(isset($vehicle) && $vehicle->image_rear)
                        <img src="{{ Storage::url($vehicle->image_rear) }}" alt="Rear View" style="max-width: 100px; margin-top: 5px;">
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A; font-weight: 600;">Vehicle Image (Side View)</label>
                        <input type="file" name="image_side" accept=".jpg,.png" style="width: 100%; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; background: white; font-size: 14px;">
                        @if(isset($vehicle) && $vehicle->image_side)
                        <img src="{{ Storage::url($vehicle->image_side) }}" alt="Side View" style="max-width: 100px; margin-top: 5px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div style="width: 100%; display: flex; justify-content: center; margin-top: 20px;">
            <button type="submit" style="background-color: #00B4D8; color: white; font-weight: 600; padding: 12px 30px; border-radius: 6px; border: none; cursor: pointer; font-size: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" 
                    onmouseover="this.style.backgroundColor='#0096C7'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)'" 
                    onmouseout="this.style.backgroundColor='#00B4D8'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                @if(isset($vehicle)) Update @else Submit @endif
            </button>
        </div>
    </form>

    <!-- Back Link -->
    @if(isset($vehicle))
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('army-vehicles.create') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; display: inline-block; font-weight: 600; font-size: 14px;">
            Back to All Army Vehicles
        </a>
    </div>
    @endif

    <!-- Search & Table -->
    <div style="margin-top: 2rem; max-width: 1000px; margin-left: auto; margin-right: auto;">
        <input type="text" id="searchInput" placeholder="Search Army Vehicles..." style="flex: 1; padding: 10px; border: 1px solid #90E0EF; border-radius: 6px; color: #03045E; font-size: 14px; margin-bottom: 15px; width: 100%;">

        <div style="overflow-x: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; background: white;">
                <thead style="background: #023E8A; color: white;">
                    <tr>
                        <th style="border: 1px solid #90E0EF; padding: 12px; text-align: left; cursor: pointer;" onclick="sortTable(0)">Vehicle Army No</th>
                        <th style="border: 1px solid #90E0EF; padding: 12px; text-align: left; cursor: pointer;" onclick="sortTable(1)">Vehicle Type</th>
                        <th style="border: 1px solid #90E0EF; padding: 12px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Rows populated by JS -->
                </tbody>
            </table>
        </div>

        <div id="pagination" style="margin-top: 15px; text-align: center;"></div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); justify-content: center; align-items: center; z-index: 1000;">
        <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 90%; max-height: 90%; overflow: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            <h3 id="modalTitle" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #023E8A; text-align: center;">Vehicle Images</h3>
            <div id="imageContainer" style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;"></div>
            <button onclick="closeImageModal()" style="margin-top: 1.5rem; background-color: #00B4D8; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; border: none; cursor: pointer; font-size: 14px; display: block; margin-left: auto; margin-right: auto;"
                    onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">Close</button>
        </div>
    </div>
</div>

<script>
    // Tab functionality
    function openTab(tabId) {
        const tabs = ['tab1', 'tab2', 'tab3', 'tab4'];
        tabs.forEach(id => {
            const tab = document.getElementById(id);
            const button = document.querySelector(`[onclick="openTab('${id}')"]`);
            if (id === tabId) {
                tab.style.display = 'block';
                button.style.background = '#0077B6';
                button.style.color = 'white';
            } else {
                tab.style.display = 'none';
                button.style.background = '#90E0EF';
                button.style.color = '#03045E';
            }
        });
    }

    // Modal functions
    function openImageModal(vehicleArmyNo, images) {
        document.getElementById('modalTitle').textContent = `Vehicle Images for ${vehicleArmyNo}`;
        const container = document.getElementById('imageContainer');
        container.innerHTML = '';
        if (images.length === 0) {
            container.innerHTML = '<p style="color: #666; text-align: center; width: 100%;">No images available.</p>';
        } else {
            images.forEach(src => {
                const img = document.createElement('img');
                img.src = '{{ Storage::url("") }}/' + src;  // Adjust path if needed
                img.style.maxWidth = '250px';
                img.style.maxHeight = '250px';
                img.style.borderRadius = '8px';
                img.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                container.appendChild(img);
            });
        }
        document.getElementById('imageModal').style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            closeImageModal();
        }
    }

    // Dropdown population functions
    async function fetchData(url) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();
            console.log(`Fetched data from ${url}:`, data);
            return data;
        } catch (error) {
            console.error(`Error fetching ${url}:`, error);
            return [];
        }
    }

    function populateSelect(selectId, data, selectedValue = null) {
        const select = document.getElementById(selectId);
        if (!select) {
            console.error('Element with ID ' + selectId + ' not found');
            return;
        }
        select.innerHTML = '<option value="" disabled selected>Loading...</option>';
        setTimeout(() => {
            select.innerHTML = '<option value="" disabled selected>Select ' + selectId.replace(/-/g, ' ') + '</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name || item.text || item.sub_category || item.category;
                if (selectedValue && option.value == selectedValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
            if (selectedValue && !select.querySelector('option[value="' + selectedValue + '"]')) {
                console.warn('Selected value not found in options for ' + selectId);
            }
        }, 100);
    }

    async function fetchModels(selectedValue = null) {
        const data = await fetchData('/get-models');
        populateSelect('vehicle_model', data, selectedValue);
    }

    async function fetchSubCategories(catId, selectedValue = null) {
        const select = document.getElementById('vehicle_sub_category');
        if (!select) return;
        if (!catId) {
            select.innerHTML = '<option value="" disabled selected>Select a Category first</option>';
            return;
        }
        const data = await fetchData(`/get-sub-categories/${catId}`);
        populateSelect('vehicle_sub_category', data, selectedValue);
    }

    async function populateDropdowns() {
        console.log('Starting populateDropdowns');
        try {
            // Independent dropdowns
            const vehicleTypeData = await fetchData('/get-vehicle-types');
            populateSelect('vehicle_type', vehicleTypeData, '{{ $vehicle->vehicle_type_id ?? "" }}');

            const allocationData = await fetchData('/get-allocation-types');
            populateSelect('vehicle_allocation_type', allocationData, '{{ $vehicle->vehicle_allocation_type_id ?? "" }}');

            const makeData = await fetchData('/get-makes');
            populateSelect('vehicle_make', makeData, '{{ $vehicle->vehicle_make_id ?? "" }}');

            const categoryData = await fetchData('/get-categories');
            populateSelect('vehicle_category', categoryData, '{{ $vehicle->vehicle_category_id ?? "" }}');

            const colorData = await fetchData('/get-colors');
            populateSelect('color', colorData, '{{ $vehicle->color_id ?? "" }}');

            const statusData = await fetchData('/get-statuses');
            populateSelect('status', statusData, '{{ $vehicle->status_id ?? "" }}');

            const tireData = await fetchData('/get-tire-sizes');
            populateSelect('front_tire_size', tireData, '{{ $vehicle->front_tire_size_id ?? "" }}');
            populateSelect('rear_tire_size', tireData, '{{ $vehicle->rear_tire_size_id ?? "" }}');

            const engineData = await fetchData('/get-engine-capacities');
            populateSelect('engine_capacity', engineData, '{{ $vehicle->engine_capacity_id ?? "" }}');

            const fuelData = await fetchData('/get-fuel-types');
            populateSelect('fuel_type', fuelData, '{{ $vehicle->fuel_type_id ?? "" }}');

            const workshopData = await fetchData('/get-workshops');
            populateSelect('workshop', workshopData, '{{ $vehicle->workshop_id ?? "" }}');
            populateSelect('admitted_workshop', workshopData, '{{ $vehicle->admitted_workshop_id ?? "" }}');

            const driverData = await fetchData('/get-drivers');
            populateSelect('driver', driverData, '{{ $vehicle->driver_id ?? "" }}');

            // Load models
            await fetchModels('{{ $vehicle->vehicle_model_id ?? "" }}');

            // Sub-categories
            const initialCatId = '{{ $vehicle->vehicle_category_id ?? "" }}';
            if (initialCatId) {
                await fetchSubCategories(initialCatId, '{{ $vehicle->vehicle_sub_category_id ?? "" }}');
            }
        } catch (error) {
            console.error('Error in populateDropdowns:', error);
        }
    }

    document.getElementById('vehicle_category')?.addEventListener('change', function() {
        fetchSubCategories(this.value);
    });

    // Table functionality
    let vehiclesData = [];
    const rowsPerPage = 5;
    let currentPage = 1;
    let sortAsc = true;

    async function loadArmyVehicles() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }
        try {
            const response = await fetch('/army-vehicles', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            vehiclesData = await response.json();
            console.log('Loaded army vehicles:', vehiclesData);
            renderTable();
        } catch (error) {
            console.error('Error loading army vehicles:', error);
        }
    }

    function renderTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        let filtered = vehiclesData.filter(v => 
            v.vehicle_army_no.toLowerCase().includes(search) || 
            v.vehicle_type.toLowerCase().includes(search)
        );

        // Sort (simple client-side)
        if (sortCol !== undefined) {
            filtered.sort((a, b) => {
                const valA = sortCol === 0 ? a.vehicle_army_no : a.vehicle_type;
                const valB = sortCol === 0 ? b.vehicle_army_no : b.vehicle_type;
                return sortAsc ? valA.localeCompare(valB) : valB.localeCompare(valA);
            });
        }

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginated = filtered.slice(start, end);

        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        paginated.forEach(vehicle => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="border: 1px solid #90E0EF; padding: 12px;">${vehicle.vehicle_army_no}</td>
                <td style="border: 1px solid #90E0EF; padding: 12px;">${vehicle.vehicle_type}</td>
                <td style="border: 1px solid #90E0EF; padding: 12px; text-align: center;">
                    <a href="/army-vehicles/${vehicle.serial_number}/edit" style="color: #00B4D8; text-decoration: none; font-weight: 600;">Edit</a>
                    <!-- Add images if available, but since index doesn't return, placeholder -->
                    <button onclick="openImageModal('${vehicle.vehicle_army_no}', [])" style="margin-left: 10px; background: none; border: none; color: #00B4D8; cursor: pointer;">View Images</button>
                </td>
            `;
            tbody.appendChild(row);
        });

        renderPagination(filtered.length);
    }

    function renderPagination(total) {
        const totalPages = Math.ceil(total / rowsPerPage);
        const container = document.getElementById('pagination');
        container.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.style = `margin: 0 4px; padding: 8px 12px; background: ${i === currentPage ? '#023E8A' : '#00B4D8'}; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;`;
            btn.onclick = () => { currentPage = i; renderTable(); };
            container.appendChild(btn);
        }
    }

    let sortCol = undefined;
    function sortTable(colIndex) {
        if (sortCol === colIndex) {
            sortAsc = !sortAsc;
        } else {
            sortCol = colIndex;
            sortAsc = true;
        }
        renderTable();
    }

    document.getElementById('searchInput').addEventListener('input', () => { 
        currentPage = 1; 
        renderTable(); 
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        populateDropdowns();
        loadArmyVehicles();
    });
</script>
@endsection