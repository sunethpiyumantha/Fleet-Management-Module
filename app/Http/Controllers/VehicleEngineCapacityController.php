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
            'engine_capacity' => 'required|string|max:250'
        ]);

        VehicleEngineCapacity::create($request->only('engine_capacity'));
        return redirect()->back()->with('success', 'Added successfully!');
    }

    public function update(Request $request, $id)
    {
        $capacity = VehicleEngineCapacity::findOrFail($id);
        $capacity->update($request->only('engine_capacity'));

        return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function destroy($id)
    {
        $capacity = VehicleEngineCapacity::findOrFail($id);
        $capacity->delete();

        return redirect()->back()->with('success', 'Deleted successfully!');
    }
}
