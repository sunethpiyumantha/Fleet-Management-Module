<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleEngineCapacity;

class VehicleEngineCapacityController extends Controller
{
    public function index(Request $request)
    {
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

        return redirect()->back()->with('success', 'Added successfully!');
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
        $capacity = VehicleEngineCapacity::findOrFail($id);
        $capacity->forceDelete(); // <- use this if you want actual deletion

        return redirect()->back()->with('success', 'Deleted successfully!');
    }

}
