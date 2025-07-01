<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequest;
use App\Models\VehicleDeclaration;
use App\Models\VehicleTechnicalDescription;
use Illuminate\Http\Request;

class VehicleTechnicalDescriptionController extends Controller
{
    public function create($serial_number, $request_type)
    {
        $vehicleRequest = VehicleRequest::where('serial_number', $serial_number)
            ->orWhere('id', $serial_number)
            ->with('category')
            ->firstOrFail();
        $vehicleDeclaration = VehicleDeclaration::where('serial_number', $serial_number)->first();
        return view('vehicle-technical-description', compact('vehicleRequest', 'vehicleDeclaration'));
    }

    public function store(Request $request, $serial_number)
    {
        $validated = $request->validate([
            'gross_weight' => 'required|string',
            'seats_sleme' => 'required|string',
            'comparable' => 'required|in:yes,no',
            'seats_mvr' => 'required|string',
        ]);

        VehicleTechnicalDescription::create([
            'serial_number' => $serial_number,
            'gross_weight' => $validated['gross_weight'],
            'seats_sleme' => $validated['seats_sleme'],
            'comparable' => $validated['comparable'],
            'seats_mvr' => $validated['seats_mvr'],
        ]);

        return redirect()->route('vehicle.inspection.index')->with('success', 'Technical description submitted successfully.');
    }
}