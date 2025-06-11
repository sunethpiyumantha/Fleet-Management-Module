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
        $search = $request->input('search');
        $sort = $request->input('sort', 'category');
        $order = $request->input('order', 'asc');

        $vehicles = VehicleRequest::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('category', function ($q) use ($search) {
                    $q->where('category', 'like', "%{$search}%");
                })->orWhereHas('subCategory', function ($q) use ($search) {
                    $q->where('sub_category', 'like', "%{$search}%");
                });
            })
            ->when($sort, function ($query, $sort) use ($order) {
                if ($sort == 'category') {
                    return $query->join('vehicle_categories', 'vehicle_requests.cat_id', '=', 'vehicle_categories.id')
                        ->orderBy('vehicle_categories.category', $order);
                } elseif ($sort == 'sub_category') {
                    return $query->join('vehicle_sub_categories', 'vehicle_requests.sub_cat_id', '=', 'vehicle_sub_categories.id')
                        ->orderBy('vehicle_sub_categories.sub_category', $order);
                } else {
                    return $query->orderBy($sort, $order);
                }
            })
            ->with(['category', 'subCategory'])
            ->paginate(10);

        $categories = VehicleCategory::all();

        return view('request-vehicle', compact('vehicles', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
        ]);

        VehicleRequest::create([
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'qty' => $request->qty,
        ]);

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request created successfully.');
    }

    public function edit($id)
    {
        $vehicle = VehicleRequest::findOrFail($id);
        $categories = VehicleCategory::all();
        return view('request-vehicle-edit', compact('vehicle', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
        ]);

        $vehicle = VehicleRequest::findOrFail($id);
        $vehicle->update([
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'qty' => $request->qty,
        ]);

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request updated successfully.');
    }

    public function destroy($id)
    {
        $vehicle = VehicleRequest::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request deleted successfully.');
    }

    public function getSubCategories($catId)
    {
        $subCategories = VehicleSubCategory::where('cat_id', $catId)->get(['id', 'sub_category']);

        return response()->json($subCategories);
    }
}