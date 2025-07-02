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
        $vehicleRequest = VehicleRequest::with('category')
            ->where('serial_number', $serial_number)
            ->firstOrFail();

        $vehicleDeclaration = VehicleDeclaration::with([
            'vehicleType',
            'vehicleModel',
            'fuelType',
            'engineCapacity',
            'drivers' => function ($query) {
                $query->whereNull('deleted_at');
            }
        ])
            ->where('serial_number', $serial_number)
            ->firstOrFail();

        return view('vehicle-technical-description', compact('vehicleRequest', 'vehicleDeclaration', 'request_type'));
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

    public function destroy($serial_number)
    {
        $vehicleDeclaration = VehicleDeclaration::withTrashed()->where('serial_number', $serial_number)->firstOrFail();
        $vehicleDeclaration->delete();

        return redirect()->route('some.route')->with('success', 'Declaration soft deleted successfully.');
    }
}