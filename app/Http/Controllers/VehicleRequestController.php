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
        $perPage = $request->input('per_page', 15);

        // Whitelist sortable columns
        $sortableColumns = ['category', 'sub_category', 'created_at'];
        $sort = in_array($sort, $sortableColumns) ? $sort : 'created_at';
        $order = in_array(strtolower($order), ['asc', 'desc']) ? $order : 'desc';

        $vehicles = VehicleRequest::query()
            ->when($search, function ($query) use ($search) {
                $query->whereHas('category', fn ($q) => $q->where('category', 'like', "%{$search}%"))
                      ->orWhereHas('subCategory', fn ($q) => $q->where('sub_category', 'like', "%{$search}%"));
            })
            ->when($sort, function ($query) use ($sort, $order) {
                if ($sort === 'category') {
                    return $query->join('vehicle_categories', 'vehicle_requests.cat_id', '=', 'vehicle_categories.id')
                                 ->orderBy('vehicle_categories.category', $order)
                                 ->select('vehicle_requests.*');
                } elseif ($sort === 'sub_category') {
                    return $query->join('vehicle_sub_categories', 'vehicle_requests.sub_cat_id', '=', 'vehicle_sub_categories.id')
                                 ->orderBy('vehicle_sub_categories.sub_category', $order)
                                 ->select('vehicle_requests.*');
                } else {
                    return $query->orderBy($sort, $order);
                }
            }, fn ($query) => $query->orderBy('created_at', 'desc'))
            ->with(['category', 'subCategory'])
            ->paginate($perPage);

        \Log::info('Fetched Vehicle Requests: ', $vehicles->toArray());

        $categories = VehicleCategory::all();

        return view('request-vehicle', compact('vehicles', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
        ]);

        VehicleRequest::create($validated);

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
        $validated = $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
        ]);

        $vehicle = VehicleRequest::findOrFail($id);
        $vehicle->update($validated);

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request updated successfully.');
    }

    public function destroy($id)
    {
        \Log::info("Attempting to soft delete vehicle request ID: {$id}");
        $vehicle = VehicleRequest::findOrFail($id);
        $success = $vehicle->delete();
        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));
        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request deleted successfully.');
    }

    public function getSubCategories($catId)
    {
        $subCategories = VehicleSubCategory::where('cat_id', $catId)->get(['id', 'sub_category']);
        return response()->json($subCategories);
    }
}