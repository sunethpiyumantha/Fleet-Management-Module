@extends('layouts.app')

@section('title', 'Edit Vehicle - {{ $vehicle->serial_number }}')

@section('content')
<div style="width: 100%; padding: 8px; font-family: Arial, sans-serif; background: white;">
    <div style="background: #0077B6; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
        <h1 style="font-size: 1.875rem; font-weight: bold; margin: 0;">Edit Vehicle - {{ $vehicle->serial_number }}</h1>
    </div>

    @if(session('success'))
    <div style="background-color: #ADE8F4; color: #023E8A; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background-color: #CAF0F8; color: #03045E; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
        <ul style="margin: 0; padding-left: 1rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 1rem; background: #CAF0F8; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
        <div style="flex: 1; min-width: 200px;"><strong>Category:</strong> {{ $vehicle->category->category ?? 'N/A' }}</div>
        <div style="flex: 1; min-width: 200px;"><strong>Sub Category:</strong> {{ $vehicle->subCategory->sub_category ?? 'N/A' }}</div>
        <div style="flex: 1; min-width: 200px;"><strong>Status:</strong> <span style="padding: 0.25rem 0.5rem; border-radius: 0.25rem; @if($vehicle->status->status ?? '' === 'approved') background-color: #10b981; color: white; @elseif($vehicle->status->status ?? '' === 'rejected') background-color: #ef4444; color: white; @else background-color: #f59e0b; color: white; @endif">{{ ucfirst($vehicle->status->status ?? 'N/A') }}</span></div>
    </div>

    <div class="tab-bar">
        <button type="button" class="tab-button active" onclick="openTab('tab1')">Vehicle Identification</button>
        <button type="button" class="tab-button" onclick="openTab('tab2')">Technical Specifications</button>
        <button type="button" class="tab-button" onclick="openTab('tab3')">Administrative & Legal</button>
        <button type="button" class="tab-button" onclick="openTab('tab4')">Operational & Workshop</button>
    </div>

    <style>
        .tab-bar { display: flex; gap: 0.75rem; justify-content: center; margin-bottom: 1.5rem; background: #CAF0F8; padding: 0.25rem; border-radius: 5px; }
        .tab-button { background: #90E0EF; color: #03045E; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .tab-button.active { background: #0077B6; color: white; }
        .tab-button:hover { background: #00B4D8; }
        .tab-content { display: none; }
        .tab-content.active { display: block !important; }
        button:disabled { background: #d1d5db !important; cursor: not-allowed !important; }
        @media (max-width: 48rem) { .tab-button { width: 100%; font-size: 0.9rem; padding: 0.5rem 1rem; } }
        #imageContainer img { width: 100%; height: auto; max-width: 200px; max-height: 200px; object-fit: contain; border-radius: 5px; }
    </style>

    <form method="POST" action="{{ route('vehicles.update', $vehicle->serial_number) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="serial_number" value="{{ $vehicle->serial_number }}">

        <div id="tab1" class="tab-content active">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Type</label>
                        <select id="vehicle_type" name="vehicle_type" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Vehicle Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_allocation_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Allocation Type</label>
                        <select id="vehicle_allocation_type" name="vehicle_allocation_type" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Allocation Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_army_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Army No</label>
                        <input type="text" id="vehicle_army_no" name="vehicle_army_no" value="{{ $vehicle->vehicle_army_no }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="civil_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Civil No</label>
                        <input type="text" id="civil_no" name="civil_no" value="{{ $vehicle->civil_no ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="chassis_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Chassis No</label>
                        <input type="text" id="chassis_no" name="chassis_no" value="{{ $vehicle->chassis_no }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="engine_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine No</label>
                        <input type="text" id="engine_no" name="engine_no" value="{{ $vehicle->engine_no }}" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_make" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Make</label>
                        <select id="vehicle_make" name="vehicle_make" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Make</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_model" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Model</label>
                        <select id="vehicle_model" name="vehicle_model" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Model</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_category" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Category</label>
                        <select id="vehicle_category" name="vehicle_category" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Category</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="vehicle_sub_category" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Sub Category</label>
                        <select id="vehicle_sub_category" name="vehicle_sub_category" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Sub-Category</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="color" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Color</label>
                        <select id="color" name="color" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Color</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Status</label>
                        <select id="status" name="status" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Status</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="current_vehicle_status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Current Vehicle Status</label>
                        <select id="current_vehicle_status" name="current_vehicle_status" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Status</option>
                            <option value="on_road" {{ $vehicle->current_vehicle_status == 'on_road' ? 'selected' : '' }}>On Road</option>
                            <option value="off_road" {{ $vehicle->current_vehicle_status == 'off_road' ? 'selected' : '' }}>Off Road</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="t5_location" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">T5 Location (Estb)</label>
                        <input type="text" id="t5_location" name="t5_location" value="{{ $vehicle->t5_location ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="parking_place" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Parking Place</label>
                        <input type="text" id="parking_place" name="parking_place" value="{{ $vehicle->parking_place ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <div id="tab2" class="tab-content">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="front_tire_size" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Front Tire Size</label>
                        <select id="front_tire_size" name="front_tire_size" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Front Tire Size</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="rear_tire_size" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Rear Tire Size</label>
                        <select id="rear_tire_size" name="rear_tire_size" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Rear Tire Size</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="engine_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Engine Capacity</label>
                        <select id="engine_capacity" name="engine_capacity" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Engine Capacity</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="fuel_type" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Fuel Type</label>
                        <select id="fuel_type" name="fuel_type" required style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Fuel Type</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="seating_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Seating Capacity</label>
                        <input type="text" id="seating_capacity" name="seating_capacity" value="{{ $vehicle->seating_capacity ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="gross_weight" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Gross Weight</label>
                        <input type="text" id="gross_weight" name="gross_weight" value="{{ $vehicle->gross_weight ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="tare_weight" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Tare Weight</label>
                        <input type="text" id="tare_weight" name="tare_weight" value="{{ $vehicle->tare_weight ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="load_capacity" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Load Capacity</label>
                        <input type="text" id="load_capacity" name="load_capacity" value="{{ $vehicle->load_capacity ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <div id="tab3" class="tab-content">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="acquired_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Acquired Date</label>
                        <input type="date" id="acquired_date" name="acquired_date" value="{{ $vehicle->acquired_date ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="handover_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Handover Date to Ordnance</label>
                        <input type="date" id="handover_date" name="handover_date" value="{{ $vehicle->handover_date ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="part_x_no" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Part X No (Itr Ref)</label>
                        <input type="text" id="part_x_no" name="part_x_no" value="{{ $vehicle->part_x_no ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="part_x_location" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Part X Location (Estb)</label>
                        <input type="text" id="part_x_location" name="part_x_location" value="{{ $vehicle->part_x_location ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="part_x_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Part X Date</label>
                        <input type="date" id="part_x_date" name="part_x_date" value="{{ $vehicle->part_x_date ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="insurance_period_from" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Insurance Period From</label>
                        <input type="date" id="insurance_period_from" name="insurance_period_from" value="{{ $vehicle->insurance_period_from ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="insurance_period_to" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Insurance Period To</label>
                        <input type="date" id="insurance_period_to" name="insurance_period_to" value="{{ $vehicle->insurance_period_to ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="emission_test_status" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Emission Test Status</label>
                        <select id="emission_test_status" name="emission_test_status" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Status</option>
                            <option value="yes" {{ $vehicle->emission_test_status == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ $vehicle->emission_test_status == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="emission_test_year" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Emission Test Year</label>
                        <input type="text" id="emission_test_year" name="emission_test_year" value="{{ $vehicle->emission_test_year ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
            </div>
        </div>

        <div id="tab4" class="tab-content">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="workshop" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Workshop</label>
                        <select id="workshop" name="workshop" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Workshop</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="admitted_workshop" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Admitted Workshop</label>
                        <select id="admitted_workshop" name="admitted_workshop" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Admitted Workshop</option>
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="workshop_admitted_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Workshop Admitted Date</label>
                        <input type="date" id="workshop_admitted_date" name="workshop_admitted_date" value="{{ $vehicle->workshop_admitted_date ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="service_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Service Date</label>
                        <input type="date" id="service_date" name="service_date" value="{{ $vehicle->service_date ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="next_service_date" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Next Service Date</label>
                        <input type="date" id="next_service_date" name="next_service_date" value="{{ $vehicle->next_service_date ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="driver" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Driver</label>
                        <select id="driver" name="driver" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                            <option value="" disabled>Select Driver</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; width: 100%; max-width: 900px;">
                    <div style="flex: 1; min-width: 220px;">
                        <label for="fault" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Fault</label>
                        <input type="text" id="fault" name="fault" value="{{ $vehicle->fault ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
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
                        @if($vehicle->image_front)
                        <div style="margin-top: 8px;">
                            <a href="{{ Storage::url($vehicle->image_front) }}" target="_blank">View Current Front Image</a>
                        </div>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="image_rear" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Image (Rear View)</label>
                        <input type="file" id="image_rear" name="image_rear" accept=".jpg,.png" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if($vehicle->image_rear)
                        <div style="margin-top: 8px;">
                            <a href="{{ Storage::url($vehicle->image_rear) }}" target="_blank">View Current Rear Image</a>
                        </div>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label for="image_side" style="display: block; font-size: 14px; margin-bottom: 4px; color: #023E8A;">Vehicle Image (Side View)</label>
                        <input type="file" id="image_side" name="image_side" accept=".jpg,.png" style="width: 100%; padding: 8px; border: 1px solid #90E0EF; border-radius: 5px; color: #03045E;">
                        @if($vehicle->image_side)
                        <div style="margin-top: 8px;">
                            <a href="{{ Storage::url($vehicle->image_side) }}" target="_blank">View Current Side Image</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div style="width: 100%; display: flex; justify-content: center; margin-top: 15px;">
            <button type="submit" style="background-color: #00B4D8; color: white; font-weight: 600; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                <i class="fa-solid fa-save" style="margin-right: 0.25rem;"></i> Update Vehicle
            </button>
        </div>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('vehicles.create') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-block; font-weight: 600;">← Back to All Vehicles</a>
    </div>

    <script>
        function openTab(tabId) {
            const tabContents = document.querySelectorAll('.tab-content');
            const tabButtons = document.querySelectorAll('.tab-button');
            tabContents.forEach(tab => { tab.style.display = 'none'; tab.classList.remove('active'); });
            tabButtons.forEach(button => button.classList.remove('active'));
            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.style.display = 'block';
                selectedTab.classList.add('active');
                document.querySelector(`[onclick="openTab('${tabId}')"]`).classList.add('active');
            }
        }

        function populateSelect(selectId, data, selectedValue = null) {
            const select = document.getElementById(selectId);
            if (!select) {
                console.error(`Element with ID ${selectId} not found`);
                return;
            }
            select.innerHTML = '<option value="" disabled selected>Loading...</option>';
            if (!data || data.length === 0) {
                select.innerHTML = '<option value="" disabled selected>No options available</option>';
                console.warn(`No data for ${selectId}:`, data);
            } else {
                select.innerHTML = '<option value="" disabled>Select</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.text || item.rear_text || item[Object.keys(item).find(k => k !== 'id')] || 'N/A';
                    select.appendChild(option);
                });
                if (selectedValue) {
                    select.value = selectedValue;
                    if (select.value !== selectedValue) {
                        console.warn(`Selected value ${selectedValue} not found in ${selectId} options`);
                    }
                }
                console.log(`Populated ${selectId} with ${data.length} options:`, data, 'Selected:', selectedValue);
            }
        }

        async function fetchData(url) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found');
                return [];
            }
            try {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
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

        async function fetchModels(selectedValue = null) {
            const select = document.getElementById('vehicle_model');
            if (!select) {
                console.error('Element with ID vehicle_model not found');
                return;
            }
            select.innerHTML = '<option value="" disabled selected>Loading...</option>';
            const data = await fetchData('/get-models');
            populateSelect('vehicle_model', data, selectedValue);
        }

        async function fetchSubCategories(catId, selectedValue = null) {
            const select = document.getElementById('vehicle_sub_category');
            if (!select) {
                console.error('Element with ID vehicle_sub_category not found');
                return;
            }
            select.innerHTML = '<option value="" disabled selected>Loading...</option>';
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
                populateSelect('vehicle_type', await fetchData('/get-vehicle-types'), '{{ $vehicle->vehicle_type_id }}');
                populateSelect('vehicle_allocation_type', await fetchData('/get-allocation-types'), '{{ $vehicle->vehicle_allocation_type_id }}');
                populateSelect('vehicle_make', await fetchData('/get-makes'), '{{ $vehicle->vehicle_make_id }}');
                populateSelect('vehicle_category', await fetchData('/get-categories'), '{{ $vehicle->vehicle_category_id }}');
                populateSelect('color', await fetchData('/get-colors'), '{{ $vehicle->color_id }}');
                populateSelect('status', await fetchData('/get-statuses'), '{{ $vehicle->status_id }}');
                const tireData = await fetchData('/get-tire-sizes');
                populateSelect('front_tire_size', tireData.map(item => ({ id: item.id, text: item.text })), '{{ $vehicle->front_tire_size_id }}');
                populateSelect('rear_tire_size', tireData.map(item => ({ id: item.id, text: item.rear_text || item.text })), '{{ $vehicle->rear_tire_size_id }}');
                populateSelect('engine_capacity', await fetchData('/get-engine-capacities'), '{{ $vehicle->engine_capacity_id }}');
                populateSelect('fuel_type', await fetchData('/get-fuel-types'), '{{ $vehicle->fuel_type_id }}');
                populateSelect('workshop', await fetchData('/get-workshops'), '{{ $vehicle->workshop_id }}');
                populateSelect('admitted_workshop', await fetchData('/get-workshops'), '{{ $vehicle->admitted_workshop_id }}');
                populateSelect('driver', await fetchData('/get-drivers'), '{{ $vehicle->driver_id }}');

                await fetchModels('{{ $vehicle->vehicle_model_id }}');
                const initialCatId = '{{ $vehicle->vehicle_category_id }}';
                if (initialCatId) {
                    console.log('Fetching sub-categories for category:', initialCatId);
                    await fetchSubCategories(initialCatId, '{{ $vehicle->vehicle_sub_category_id }}');
                }
            } catch (error) {
                console.error('Error in populateDropdowns:', error);
            }
        }

        document.getElementById('vehicle_category')?.addEventListener('change', function() {
            console.log('Category changed:', this.value);
            fetchSubCategories(this.value);
        });

        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded, initializing dropdowns');
            populateDropdowns();
        });
    </script>
</div>
@endsection