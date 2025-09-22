<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function create()
    {
        return view('vehicles-basic-info');
    }

    public function edit($serialNumber)
    {
        $vehicle = Vehicle::where('serial_number', $serialNumber)->firstOrFail();
        return view('vehicles-basic-info', compact('vehicle'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'serial_number' => 'nullable|string',
            'vehicle_army_no' => 'required|string',
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
        ]);

        // Generate unique serial number if not provided
        $data['serial_number'] = $data['serial_number'] ?? 'VEH' . time();

        // Handle file uploads
        if ($request->hasFile('image_front')) {
            $data['image_front'] = $request->file('image_front')->store('vehicle_images', 'public');
        }
        if ($request->hasFile('image_rear')) {
            $data['image_rear'] = $request->file('image_rear')->store('vehicle_images', 'public');
        }
        if ($request->hasFile('image_side')) {
            $data['image_side'] = $request->file('image_side')->store('vehicle_images', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('vehicles.create')->with('success', 'Vehicle added successfully.');
    }

    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }
}