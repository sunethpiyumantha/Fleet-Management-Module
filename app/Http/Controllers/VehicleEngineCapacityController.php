<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleEngineCapacity;

class VehicleEngineCapacityController extends Controller
{
    public function index(Request $request)
    {
        $capacities = VehicleEngineCapacity::all();
        \Log::info('Fetched Vehicle Engine Capacity: ', $capacities->toArray());

        $search = $request->input('search');
        $capacities = VehicleEngineCapacity::when($search, function ($query, $search) {
            return $query->where('engine_capacity', 'LIKE', "%{$search}%");
        })->orderBy('engine_capacity')->get();

        return view('vehicle-engine-capacity', compact('capacities', 'search'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'engine_capacity' => 'required|string|max:250|unique:vehicle_engine_capacities,engine_capacity'
        ]);

        VehicleEngineCapacity::create([
            'engine_capacity' => $request->engine_capacity
        ]);

        return redirect()->back()->with('success', 'Engine capacity Added successfully!');
    }



   public function update(Request $request, $id)
    {
        $request->validate([
            'engine_capacity' => 'required|numeric',
        ]);

        // Check for duplicate engine_capacity, excluding the current record
        $exists = VehicleEngineCapacity::where('engine_capacity', $request->engine_capacity)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['engine_capacity' => 'Engine capacity already exists.'])->withInput();
        }

        $capacity = VehicleEngineCapacity::findOrFail($id);
        $capacity->engine_capacity = $request->engine_capacity;
        $capacity->save();

        return redirect()->route('vehicle-engine-capacity.index')->with('success', 'Engine capacity updated successfully!');
    }

    public function destroy($id)
{
    \Log::info("Attempting to soft delete Vehicle Engine Capacity ID: {$id}");

    try {
        $capacity = VehicleEngineCapacity::findOrFail($id);
        $success = $capacity->delete();

        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));

        if ($success) {
            // Use 'error' key so the alert appears in red
            return redirect()->back()->with('error', 'Vehicle Engine Capacity deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Vehicle Engine Capacity.');
        }
    } catch (\Exception $e) {
        \Log::error("Failed to delete Vehicle Engine Capacity ID {$id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the Vehicle Engine Capacity.');
    }
}

}
