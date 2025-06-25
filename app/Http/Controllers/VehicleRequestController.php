<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleRequest;
use App\Models\VehicleDeclaration;
use Illuminate\Http\Request;

class VehicleRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        $perPage = $request->input('per_page', 15);

        $sortableColumns = ['created_at', 'category', 'sub_category'];
        $sort = in_array($sort, $sortableColumns) ? $sort : 'created_at';
        $order = in_array(strtolower($order), ['asc', 'desc']) ? $order : 'desc';

        $vehicles = VehicleRequest::query()
            ->when($search, function ($query) use ($search) {
                $query->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('request_type', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($q) => $q->where('category', 'like', "%{$search}%"))
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
                }
                return $query->orderBy($sort, $order);
            })
            ->with(['category', 'subCategory'])
            ->paginate($perPage);

        $categories = VehicleCategory::orderBy('category')->get();

        return view('request-vehicle', compact('vehicles', 'categories', 'sort', 'order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'nullable|string|unique:vehicle_requests,serial_number',
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
        ]);

        if (empty($validated['serial_number'])) {
            $validated['serial_number'] = $this->generateUniqueSerialNumber();
        }

        $vehicleRequest = VehicleRequest::create($validated);

        return redirect()->route('vehicle.declaration.create', [
            'serial_number' => $vehicleRequest->serial_number,
            'request_type' => $vehicleRequest->request_type
        ])->with('success', 'Vehicle request created successfully.');
    }

    private function generateUniqueSerialNumber()
    {
        do {
            $serial = now()->format('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (VehicleRequest::where('serial_number', $serial)->exists());

        return $serial;
    }

    public function create()
    {
        $categories = VehicleCategory::orderBy('category')->get();
        return view('request-vehicle', compact('categories'));
    }

    public function edit($id)
    {
        $vehicle = VehicleRequest::findOrFail($id);
        $categories = VehicleCategory::orderBy('category')->get();
        return view('request-vehicle-edit', compact('vehicle', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
        ]);

        $vehicle = VehicleRequest::findOrFail($id);
        $vehicle->update([
            'request_type' => $request->request_type,
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'qty' => $request->qty,
        ]);

        return redirect()->route('vehicle.declaration.edit', [
            'serial_number' => $vehicle->serial_number,
            'request_type' => $vehicle->request_type
        ])->with('success', 'Vehicle request updated successfully.');
    }

    public function destroy($id)
    {
        \Log::info("Attempting to soft delete vehicle request ID: {$id}");
        $vehicle = VehicleRequest::findOrFail($id);

        // Soft delete related VehicleDeclaration records
        $declarations = VehicleDeclaration::where('serial_number', $vehicle->serial_number)->get();
        foreach ($declarations as $declaration) {
            \Log::info("Soft deleting vehicle declaration ID: {$declaration->id} for serial_number: {$vehicle->serial_number}");
            $declaration->delete();
        }

        // Soft delete the VehicleRequest
        $success = $vehicle->delete();
        \Log::info("Soft delete result for vehicle request ID {$id}: " . ($success ? 'Success' : 'Failed'));

        return redirect()->route('vehicle.request.index')->with('success', 'Vehicle request and associated declarations deleted successfully.');
    }

    public function getSubCategories($catId)
    {
        $subCategories = VehicleSubCategory::where('cat_id', $catId)->get(['id', 'sub_category']);
        return response()->json($subCategories);
    }

    public function allRequests(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        $perPage = $request->input('per_page', 15);

        $sortableColumns = ['created_at', 'category', 'sub_category'];
        $sort = in_array($sort, $sortableColumns) ? $sort : 'created_at';
        $order = in_array(strtolower($order), ['asc', 'desc']) ? $order : 'desc';

        $vehicles = VehicleRequest::query()
            ->when($search, function ($query) use ($search) {
                $query->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('request_type', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($q) => $q->where('category', 'like', "%{$search}%"))
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
                }
                return $query->orderBy($sort, $order);
            })
            ->with(['category', 'subCategory'])
            ->paginate($perPage);

        $categories = VehicleCategory::orderBy('category')->get();

        return view('all-request', compact('vehicles', 'categories', 'sort', 'order'));
    }
}