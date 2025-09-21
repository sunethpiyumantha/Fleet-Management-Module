<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'serial_number' => 'required|unique:vehicles,serial_number,' . ($request->serial_number ? $request->serial_number : 'NULL'),
            // Add more validation as needed
        ]);

        Vehicle::updateOrCreate(
            ['serial_number' => $request->serial_number],
            $validated
        );

        return redirect()->back()->with('success', 'Vehicle saved successfully!');
    }
}