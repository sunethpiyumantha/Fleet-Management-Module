<?php

namespace App\Http\Controllers;

use App\Models\FuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuelTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $fuelTypes = FuelType::when($search, function ($query, $search) {
            return $query->where('fuel_type', 'LIKE', "%{$search}%");
        })->orderBy('fuel_type')->get();

        return view('fuel-type', compact('fuelTypes', 'search')); // ✔ Updated view name
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fuel_type' => 'required|string|max:255|unique:fuel_types',
        ]);

        if ($validator->fails()) {
            return redirect()->route('fuel-types.index')
                            ->withErrors($validator)
                            ->withInput();
        }

        FuelType::create($request->only('fuel_type'));

        return redirect()->route('fuel-types.index')
                        ->with('success', 'Fuel type added successfully.');
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fuel_type' => 'required|string|max:255|unique:fuel_types,fuel_type,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('fuel-types.index')
                            ->withErrors($validator)
                            ->withInput();
        }

        $fuelType = FuelType::findOrFail($id);
        $fuelType->update($request->only('fuel_type'));

        return redirect()->route('fuel-types.index')
                        ->with('success', 'Fuel type updated successfully.');
    }


    public function destroy($id)
    {
        $fuelType = FuelType::findOrFail($id);
        $fuelType->delete();

        return redirect()->route('fuel-types.index')
                        ->with('success', 'Fuel type deleted successfully.');
    }

}
