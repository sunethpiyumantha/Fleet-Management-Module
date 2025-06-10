<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;

class VehicleRequestController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::all();
        $vehicles = VehicleRequest::all(); // Fetch all records from vehicle_requests table
        return view('request-vehicle', compact('categories', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'required_quantity' => 'required|integer|min:1',
            'date_submit' => 'required|date',
        ]);

        VehicleRequest::create([
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'required_quantity' => $request->required_quantity,
            'date_submit' => $request->date_submit,
            'status' => '1',
        ]);

        return redirect()->back()->with('success', 'Request submitted successfully');
    }

    public function getSubCategories($catId)
    {
        $subCategories = VehicleSubCategory::where('cat_id', $catId)->get();
        return response()->json($subCategories);
    }

    public function edit($id)
    {
        return redirect()->back()->with('message', 'Update functionality to be implemented for ID: ' . $id);
    }

    public function destroy($id)
    {
        $vehicle = VehicleRequest::find($id);
        if ($vehicle) {
            $vehicle->delete();
            return redirect()->back()->with('success', 'Vehicle deleted successfully');
        }
        return redirect()->back()->with('error', 'Vehicle not found');
    }
}