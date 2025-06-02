<?php

namespace App\Http\Controllers;
use App\Models\VehicleType;

use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::latest()->paginate(5);
        return view('vehicle-types', compact('vehicleTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|unique:vehicle_types,vehicle_type',
        ]);

        VehicleType::create([
            'vehicle_type' => $request->vehicle_type,
        ]);

        return redirect()->back()->with('success', 'Vehicle Type added.');
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'vehicle_type' => 'required|unique:vehicle_types,vehicle_type,' . $vehicleType->id,
        ]);

        $vehicleType->update([
            'vehicle_type' => $request->vehicle_type,
        ]);

        return redirect()->back()->with('success', 'Vehicle Type updated.');
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return redirect()->back()->with('success', 'Vehicle Type deleted.');
    }
}


