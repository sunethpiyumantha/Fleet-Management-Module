<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = VehicleType::all();
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


    public function destroy($id)
    {
    \Log::info("Attempting to soft delete vehicle type ID: {$id}");

    $vehicleType = VehicleType::findOrFail($id);
    $success = $vehicleType->delete();

    \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));

    if ($success) {
        // Use 'error' key so it shows in red
        return redirect()->back()->with('error', 'Vehicle Type deleted successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to delete Vehicle Type.');
    }
}

}