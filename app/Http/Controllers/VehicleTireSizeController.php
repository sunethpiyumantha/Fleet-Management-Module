<?php

namespace App\Http\Controllers;

use App\Models\VehicleTireSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleTireSizeController extends Controller
{
    public function index(Request $request)
    {
        $tireSizes = VehicleTireSize::all();
        $search = $request->query('search');
        $query = VehicleTireSize::query();

        if ($search) {
            $query->where('front_tire_size', 'LIKE', "%{$search}%")
                  ->orWhere('rear_tire_size', 'LIKE', "%{$search}%");
        }

        $tireSizes = $query->orderBy('front_tire_size')->paginate();
        return view('vehicle-tire-sizes', compact('tireSizes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'front_tire_size' => 'required|string|max:255',
            'rear_tire_size' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-tire-sizes.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        VehicleTireSize::create($request->only('front_tire_size', 'rear_tire_size'));
        return redirect()->route('vehicle-tire-sizes.index')
                         ->with('success', 'Vehicle Tire Size added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'front_tire_size' => 'required|string|max:255',
            'rear_tire_size' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-tire-sizes.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        $tireSize = VehicleTireSize::findOrFail($id);
        $tireSize->update($request->only('front_tire_size', 'rear_tire_size'));
        return redirect()->route('vehicle-tire-sizes.index')
                         ->with('success', 'Vehicle Tire Size updated successfully.');
    }


    public function destroy($id)
{
    \Log::info("Attempting to soft delete Vehicle Tire Size ID: {$id}");

    try {
        $tireSize = VehicleTireSize::findOrFail($id);
        $success = $tireSize->delete();

        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));

        if ($success) {
            // Use 'error' key so the message appears in red
            return redirect()->back()->with('error', 'Vehicle Tire Size deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Vehicle Tire Size.');
        }
    } catch (\Exception $e) {
        \Log::error("Failed to delete Vehicle Tire Size ID {$id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the Vehicle Tire Size.');
    }
}

}