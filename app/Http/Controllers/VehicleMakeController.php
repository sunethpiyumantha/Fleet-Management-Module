<?php

namespace App\Http\Controllers;

use App\Models\VehicleMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleMakeController extends Controller
{
    public function index(Request $request)
    {
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
        $make = VehicleMake::findOrFail($id);
        $make->delete();
        return redirect()->route('vehicle-make.index')
                         ->with('success', 'Vehicle Make deleted successfully.');
    }
}