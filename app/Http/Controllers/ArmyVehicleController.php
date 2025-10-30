<?php

namespace App\Http\Controllers;

use App\Models\ArmyVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArmyVehicleController extends Controller
{
    public function create()
    {
        return view('army-vehicle-reg');
    }

    public function edit($serialNumber)
    {
        $armyVehicle = ArmyVehicle::where('serial_number', $serialNumber)->firstOrFail();
        return view('army-vehicle-reg', compact('armyVehicle'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'serial_number' => 'nullable|string',
            'vehicle_army_no' => 'required|string|unique:army_vehicles',
            'civil_no' => 'nullable|string',
            'chassis_no' => 'required|string',
            'engine_no' => 'required|string',
            'current_vehicle_status' => 'required|in:on_road,off_road',
            't5_location' => 'nullable|string',
            'parking_place' => 'nullable|string',
            'seating_capacity' => 'nullable|integer',
            'gross_weight' => 'nullable|numeric',
            'tare_weight' => 'nullable|numeric',
            'load_capacity' => 'nullable|numeric|max:99999.99',
            'acquired_date' => 'nullable|date',
            'handover_date' => 'nullable|date',
            'part_x_no' => 'nullable|string',
            'part_x_location' => 'nullable|string',
            'part_x_date' => 'nullable|date',
            'insurance_period_from' => 'nullable|date',
            'insurance_period_to' => 'nullable|date',
            'emission_test_status' => 'nullable|in:yes,no',
            'emission_test_year' => 'nullable|integer',
            'workshop_admitted_date' => 'nullable|date',
            'service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'fault' => 'nullable|string',
            'remarks' => 'nullable|string',
            'image_front' => 'nullable|image|max:2048',
            'image_rear' => 'nullable|image|max:2048',
            'image_side' => 'nullable|image|max:2048',
            'vehicle_type' => 'required|exists:vehicle_types,id',
            'vehicle_allocation_type' => 'required|exists:vehicle_allocation_types,id',
            'vehicle_make' => 'required|exists:vehicle_makes,id',
            'vehicle_model' => 'required|exists:vehicle_models,id',
            'vehicle_category' => 'required|exists:vehicle_categories,id',
            'vehicle_sub_category' => 'required|exists:vehicle_sub_categories,id',
            'color' => 'required|exists:vehicle_colors,id',
            'status' => 'required|exists:vehicle_statuses,id',
            'front_tire_size' => 'required|exists:vehicle_tire_sizes,id',
            'rear_tire_size' => 'required|exists:vehicle_tire_sizes,id',
            'engine_capacity' => 'required|exists:vehicle_engine_capacities,id',
            'fuel_type' => 'required|exists:fuel_types,id',
            'workshop' => 'nullable|exists:workshops,id',
            'admitted_workshop' => 'nullable|exists:workshops,id',
            'driver' => 'nullable|exists:drivers,id',
        ]);

        // Generate unique serial number if not provided
        $data['serial_number'] = $data['serial_number'] ?? 'ARMY' . time();

        // Handle file uploads
        if ($request->hasFile('image_front')) {
            $data['image_front'] = $request->file('image_front')->store('army_vehicle_images', 'public');
        }
        if ($request->hasFile('image_rear')) {
            $data['image_rear'] = $request->file('image_rear')->store('army_vehicle_images', 'public');
        }
        if ($request->hasFile('image_side')) {
            $data['image_side'] = $request->file('image_side')->store('army_vehicle_images', 'public');
        }

        // Rename select fields to match database column names
        $data['vehicle_type_id'] = $data['vehicle_type'];
        $data['vehicle_allocation_type_id'] = $data['vehicle_allocation_type'];
        $data['vehicle_make_id'] = $data['vehicle_make'];
        $data['vehicle_model_id'] = $data['vehicle_model'];
        $data['vehicle_category_id'] = $data['vehicle_category'];
        $data['vehicle_sub_category_id'] = $data['vehicle_sub_category'];
        $data['color_id'] = $data['color'];
        $data['status_id'] = $data['status'];
        $data['front_tire_size_id'] = $data['front_tire_size'];
        $data['rear_tire_size_id'] = $data['rear_tire_size'];
        $data['engine_capacity_id'] = $data['engine_capacity'];
        $data['fuel_type_id'] = $data['fuel_type'];
        $data['workshop_id'] = $data['workshop'];
        $data['admitted_workshop_id'] = $data['admitted_workshop'];
        $data['driver_id'] = $data['driver'];

        // Remove temporary fields
        unset($data['vehicle_type']);
        unset($data['vehicle_allocation_type']);
        unset($data['vehicle_make']);
        unset($data['vehicle_model']);
        unset($data['vehicle_category']);
        unset($data['vehicle_sub_category']);
        unset($data['color']);
        unset($data['status']);
        unset($data['front_tire_size']);
        unset($data['rear_tire_size']);
        unset($data['engine_capacity']);
        unset($data['fuel_type']);
        unset($data['workshop']);
        unset($data['admitted_workshop']);
        unset($data['driver']);

        ArmyVehicle::create($data);

        return redirect()->route('army-vehicles.create')->with('success', 'Army Vehicle added successfully.');
    }

    public function update(Request $request, $serialNumber)
    {
        $armyVehicle = ArmyVehicle::where('serial_number', $serialNumber)->firstOrFail();

        $data = $request->validate([
            'vehicle_army_no' => 'required|string|unique:army_vehicles,vehicle_army_no,' . $armyVehicle->id,
            'civil_no' => 'nullable|string',
            'chassis_no' => 'required|string',
            'engine_no' => 'required|string',
            'current_vehicle_status' => 'required|in:on_road,off_road',
            't5_location' => 'nullable|string',
            'parking_place' => 'nullable|string',
            'seating_capacity' => 'nullable|integer',
            'gross_weight' => 'nullable|numeric',
            'tare_weight' => 'nullable|numeric',
            'load_capacity' => 'nullable|numeric|max:99999.99',
            'acquired_date' => 'nullable|date',
            'handover_date' => 'nullable|date',
            'part_x_no' => 'nullable|string',
            'part_x_location' => 'nullable|string',
            'part_x_date' => 'nullable|date',
            'insurance_period_from' => 'nullable|date',
            'insurance_period_to' => 'nullable|date',
            'emission_test_status' => 'nullable|in:yes,no',
            'emission_test_year' => 'nullable|integer',
            'workshop_admitted_date' => 'nullable|date',
            'service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'fault' => 'nullable|string',
            'remarks' => 'nullable|string',
            'image_front' => 'nullable|image|max:2048',
            'image_rear' => 'nullable|image|max:2048',
            'image_side' => 'nullable|image|max:2048',
            'vehicle_type' => 'required|exists:vehicle_types,id',
            'vehicle_allocation_type' => 'required|exists:vehicle_allocation_types,id',
            'vehicle_make' => 'required|exists:vehicle_makes,id',
            'vehicle_model' => 'required|exists:vehicle_models,id',
            'vehicle_category' => 'required|exists:vehicle_categories,id',
            'vehicle_sub_category' => 'required|exists:vehicle_sub_categories,id',
            'color' => 'required|exists:vehicle_colors,id',
            'status' => 'required|exists:vehicle_statuses,id',
            'front_tire_size' => 'required|exists:vehicle_tire_sizes,id',
            'rear_tire_size' => 'required|exists:vehicle_tire_sizes,id',
            'engine_capacity' => 'required|exists:vehicle_engine_capacities,id',
            'fuel_type' => 'required|exists:fuel_types,id',
            'workshop' => 'nullable|exists:workshops,id',
            'admitted_workshop' => 'nullable|exists:workshops,id',
            'driver' => 'nullable|exists:drivers,id',
        ]);

        // Handle file uploads and delete old images if new ones are provided
        if ($request->hasFile('image_front')) {
            if ($armyVehicle->image_front) {
                Storage::disk('public')->delete($armyVehicle->image_front);
            }
            $data['image_front'] = $request->file('image_front')->store('army_vehicle_images', 'public');
        }
        if ($request->hasFile('image_rear')) {
            if ($armyVehicle->image_rear) {
                Storage::disk('public')->delete($armyVehicle->image_rear);
            }
            $data['image_rear'] = $request->file('image_rear')->store('army_vehicle_images', 'public');
        }
        if ($request->hasFile('image_side')) {
            if ($armyVehicle->image_side) {
                Storage::disk('public')->delete($armyVehicle->image_side);
            }
            $data['image_side'] = $request->file('image_side')->store('army_vehicle_images', 'public');
        }

        // Rename select fields to match database column names
        $data['vehicle_type_id'] = $data['vehicle_type'];
        $data['vehicle_allocation_type_id'] = $data['vehicle_allocation_type'];
        $data['vehicle_make_id'] = $data['vehicle_make'];
        $data['vehicle_model_id'] = $data['vehicle_model'];
        $data['vehicle_category_id'] = $data['vehicle_category'];
        $data['vehicle_sub_category_id'] = $data['vehicle_sub_category'];
        $data['color_id'] = $data['color'];
        $data['status_id'] = $data['status'];
        $data['front_tire_size_id'] = $data['front_tire_size'];
        $data['rear_tire_size_id'] = $data['rear_tire_size'];
        $data['engine_capacity_id'] = $data['engine_capacity'];
        $data['fuel_type_id'] = $data['fuel_type'];
        $data['workshop_id'] = $data['workshop'];
        $data['admitted_workshop_id'] = $data['admitted_workshop'];
        $data['driver_id'] = $data['driver'];

        // Remove temporary fields
        unset($data['vehicle_type']);
        unset($data['vehicle_allocation_type']);
        unset($data['vehicle_make']);
        unset($data['vehicle_model']);
        unset($data['vehicle_category']);
        unset($data['vehicle_sub_category']);
        unset($data['color']);
        unset($data['status']);
        unset($data['front_tire_size']);
        unset($data['rear_tire_size']);
        unset($data['engine_capacity']);
        unset($data['fuel_type']);
        unset($data['workshop']);
        unset($data['admitted_workshop']);
        unset($data['driver']);

        $armyVehicle->update($data);

        return redirect()->route('army-vehicles.create')->with('success', 'Army Vehicle updated successfully.');
    }

    public function index()
    {
        $armyVehicles = ArmyVehicle::with('vehicleType')->get()->map(function ($armyVehicle) {
            return [
                'serial_number' => $armyVehicle->serial_number,
                'vehicle_army_no' => $armyVehicle->vehicle_army_no,
                'vehicle_type' => $armyVehicle->vehicleType ? $armyVehicle->vehicleType->name : 'N/A',
            ];
        });
        return response()->json($armyVehicles);
    }
}