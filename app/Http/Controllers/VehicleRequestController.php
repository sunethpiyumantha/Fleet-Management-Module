<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleRequest;
use App\Models\VehicleDeclaration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\VehicleCertificate;
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
        DB::beginTransaction();
        try {
            $vehicle = VehicleRequest::findOrFail($id);
            Log::info("Soft deleting VehicleRequest ID: {$id}, serial_number: {$vehicle->serial_number}");

            // Soft delete related vehicle declarations and their drivers
            foreach ($vehicle->declarations as $declaration) {
                Log::info("Soft deleting VehicleDeclaration ID: {$declaration->id} and its drivers");
                $declaration->drivers()->delete();
                $declaration->delete();
            }

            // Soft delete related vehicle certificates
            $certificates = VehicleCertificate::where('vehicle_request_id', $id)->get();
            foreach ($certificates as $certificate) {
                $certificate->delete();
                Log::info("Soft deleted VehicleCertificate ID: {$certificate->id}, serial_number: {$certificate->serial_number}");
            }

            $vehicle->delete();
            Log::info("Successfully soft deleted VehicleRequest ID: {$id}, serial_number: {$vehicle->serial_number}");

            DB::commit();
            return redirect()->route('vehicle.request.all')
                ->with('success', 'Vehicle request, declarations, certificates, and drivers soft deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to soft delete VehicleRequest ID: {$id}. Error: {$e->getMessage()}");
            return redirect()->back()
                ->with('error', 'Failed to delete vehicle request: ' . $e->getMessage());
        }
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

    public function vehicleInspection(Request $request)
    {
        \Log::info('vehicleInspection method called', [
            'url' => $request->fullUrl(),
            'search' => $request->input('search'),
            'sort' => $request->input('sort', 'created_at'),
            'order' => $request->input('order', 'desc'),
            'per_page' => $request->input('per_page', 15)
        ]);

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

        \Log::info('vehicleInspection returning view', ['vehicle_count' => $vehicles->count()]);

        return view('vehicle-inspection', compact('vehicles', 'categories', 'sort', 'order'));
    }

    public function vehicleInspectionForm2(Request $request)
    {
        \Log::info('vehicleInspectionForm2 method called', [
            'url' => $request->fullUrl(),
            'search' => $request->input('search'),
            'sort' => $request->input('sort', 'created_at'),
            'order' => $request->input('order', 'desc'),
            'per_page' => $request->input('per_page', 15)
        ]);

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

        \Log::info('vehicleInspectionForm2 returning view', ['vehicle_count' => $vehicles->count()]);

        return view('vehicle-inspection-form2', compact('vehicles', 'categories', 'sort', 'order'));
    }

    public function certificateCreate(Request $request)
    {
        \Log::info('certificateCreate method called', [
            'serial_number' => $request->query('serial_number'),
            'request_type' => $request->query('request_type')
        ]);

        $serial_number = $request->query('serial_number');
        $request_type = $request->query('request_type');

        // Fetch VehicleRequest
        $vehicle = VehicleRequest::where('serial_number', $serial_number)
            ->where('request_type', $request_type)
            ->firstOrFail();

        // Fetch associated VehicleDeclaration
        $declaration = VehicleDeclaration::with('technicalDescriptions')
            ->where('serial_number', $serial_number)
            ->first();

        if (!$declaration) {
            \Log::warning('No VehicleDeclaration found for serial_number: ' . $serial_number);
            // Optionally redirect or handle missing declaration
            // For now, proceed with null declaration
        }

        return view('certificate-of-industrial-aptitude', compact('vehicle', 'serial_number', 'request_type', 'declaration'));
    }

   public function certificateStore(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|max:255',
            'request_type' => 'required|string|max:255',
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'engine_performance' => 'required|string|max:255',
            'electrical_system' => 'required|string|max:255',
            'transmission_system' => 'required|string|max:255',
            'tires' => 'required|string|max:255',
            'brake_system' => 'required|string|max:255',
            'suspension_system' => 'required|string|max:255',
            'air_conditioning' => 'required|string|max:255',
            'seats_condition' => 'required|string|max:255',
            'fuel_efficiency' => 'required|string|max:255',
            'speedometer_reading' => 'required|string|max:255',
            'speedometer_operation' => 'required|string|max:255',
            'running_distance_function' => 'required|string|max:255',
            'improvements' => 'required|string',
            'transmission_operation' => 'required|string|max:255',
            'battery_type' => 'required|string|max:255',
            'battery_capacity' => 'required|string|max:255',
            'battery_number' => 'required|string|max:255',
            'water_capacity' => 'nullable|string|max:255',
            'cover_outer' => 'required|string|max:255',
            'certificate_validity' => 'required|string|max:255',
            'seats_mvr' => 'required|string|max:255',
            'seats_installed' => 'required|string|max:255',
            'other_matters' => 'nullable|string',
            'vehicle_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('vehicle_picture')) {
            $path = $request->file('vehicle_picture')->store('vehicle_pictures', 'public');
            $validated['vehicle_picture'] = $path;
        }

        DB::beginTransaction();
        try {
            // Save to VehicleCertificate
            $certificate = new VehicleCertificate;
            $certificate->fill($validated);
            $certificate->vehicle_request_id = VehicleRequest::where('serial_number', $request->serial_number)->first()->id;
            $certificate->save();

            // Update VehicleDeclaration with matching fields
            $declaration = VehicleDeclaration::where('serial_number', $request->serial_number)->first();
            if ($declaration) {
                $declaration->update([
                    'engine_no' => $request->engine_number,
                    'chassis_number' => $request->chassis_number,
                    'seats_registered' => $request->seats_mvr,
                    'seats_current' => $request->seats_installed,
                    'other_matters' => $request->other_matters,
                    // 'amount_of_fuel' => $request->fuel_efficiency, // Commented out until mapping is confirmed
                ]);
            }

            DB::commit();
            return redirect()->route('vehicle.inspection.form2')->with('success', 'Certificate of Industrial Aptitude submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to store certificate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to submit certificate: ' . $e->getMessage());
        }
    }

    
}
