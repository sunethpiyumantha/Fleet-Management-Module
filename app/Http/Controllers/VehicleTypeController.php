<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $types = VehicleType::when($search, function ($query, $search) {
            return $query->where('type', 'like', '%' . $search . '%');
        })->get();

        return view('vehicle-types', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:vehicle_types',
        ]);

        VehicleType::create([
            'type' => $request->type,
        ]);

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type added successfully.');
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:vehicle_types,type,' . $vehicleType->id,
        ]);

        $vehicleType->update([
            'type' => $request->type,
        ]);

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type updated successfully.');
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type deleted successfully.');
    }
}