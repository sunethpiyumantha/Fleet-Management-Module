<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;

class VehicleRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort', 'category');
        $order = $request->query('order', 'asc');

        $query = VehicleRequest::query()
            ->with(['category', 'subCategory'])
            ->when($search, fn($q) => $q->whereHas('category', fn($q) => $q->where('category', 'like', "%{$search}%"))
                                        ->orWhereHas('subCategory', fn($q) => $q->where('sub_category', 'like', "%{$search}%"))
                                        ->orWhere('required_quantity', 'like', "%{$search}%")
                                        ->orWhere('date_submit', 'like', "%{$search}%"))
            ->when($sort == 'category', fn($q) => $q->join('vehicle_categories', 'vehicle_requests.cat_id', '=', 'vehicle_categories.id')
                                                    ->orderBy('vehicle_categories.category', $order))
            ->when($sort == 'sub_category', fn($q) => $q->join('vehicle_sub_categories', 'vehicle_requests.sub_cat_id', '=', 'vehicle_sub_categories.id')
                                                        ->orderBy('vehicle_sub_categories.sub_category', $order))
            ->when($sort == 'required_quantity', fn($q) => $q->orderBy('required_quantity', $order))
            ->when($sort == 'date_submit', fn($q) => $q->orderBy('date_submit', $order));

        $vehicles = $query->paginate();
        $categories = VehicleCategory::all();

        return view('request-vehicle', compact('vehicles', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'required_quantity' => 'required|integer|min:1',
        ]);

        VehicleRequest::create([
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'required_quantity' => $request->required_quantity,
            'date_submit' => now(),
        ]);

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request submitted successfully.');
    }

    public function edit($id)
    {
        $vehicle = VehicleRequest::findOrFail($id);
        $categories = VehicleCategory::all(); // Corrected from Category to VehicleCategory
        return view('edit-vehicle', compact('vehicle', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'required_quantity' => 'required|integer|min:1',
        ]);

        $vehicle = VehicleRequest::findOrFail($id);
        $vehicle->update([
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'required_quantity' => $request->required_quantity,
            'date_submit' => now(), // Auto-update timestamp
        ]);

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request updated successfully.');
    }

    public function destroy($id)
    {
        $vehicle = VehicleRequest::findOrFail($id);
        $vehicle->delete();
        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request deleted successfully!');
    }

    public function getSubCategories($catId)
    {
        $subCategories = VehicleSubCategory::where('cat_id', $catId)->get(['id', 'sub_category']);
        return response()->json($subCategories);
    }
}