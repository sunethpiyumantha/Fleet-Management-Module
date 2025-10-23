<?php

namespace App\Http\Controllers;

use App\Models\VehicleMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleMakeController extends Controller
{
    public function index(Request $request)
    {
        $makes = VehicleMake::all();
        \Log::info('Fetched Vehicle Make: ', $makes->toArray());

        $search = $request->query('search');
        $query = VehicleMake::query();

        if ($search) {
            $query->where('make', 'LIKE', "%{$search}%");
        }

        $makes = $query->orderBy('make')->paginate();
        return view('vehicle-make', compact('makes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'required|string|max:255|unique:vehicle_makes,make',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-make.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        VehicleMake::create($request->only('make'));
        return redirect()->route('vehicle-make.index')
                         ->with('success', 'Vehicle Make added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'required|string|max:255|unique:vehicle_makes,make,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-make.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        $make = VehicleMake::findOrFail($id);
        $make->update($request->only('make'));
        return redirect()->route('vehicle-make.index')
                         ->with('success', 'Vehicle Make updated successfully.');
    }

    public function destroy($id)
{
    \Log::info("Attempting to soft delete vehicle make ID: {$id}");

    $make = VehicleMake::findOrFail($id);
    $success = $make->delete();

    \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));

    if ($success) {
        // Use 'error' key so it appears red (delete action)
        return redirect()->back()->with('error', 'Vehicle make deleted successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to delete vehicle make.');
    }
}

}