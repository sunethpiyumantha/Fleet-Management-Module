<?php

namespace App\Http\Controllers;

use App\Models\VehicleDeclaration;
use App\Models\Driver;
use App\Models\VehicleType;
use App\Models\VehicleModel;
use App\Models\VehicleEngineCapacity;
use App\Models\VehicleColor;
use App\Models\FuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleDeclarationFormController extends Controller
{
    public function create(Request $request)
    {
        $vehicleTypes = VehicleType::all();
        $vehicleModels = VehicleModel::all();
        $engineCapacities = VehicleEngineCapacity::all();
        $colors = VehicleColor::all();
        $fuelTypes = FuelType::all();
        $serialNumber = $request->query('serial_number');
        $requestType = $request->query('request_type'); // Pass request_type

        return view('vehicle-declaration-form', compact(
            'vehicleTypes',
            'vehicleModels',
            'engineCapacities',
            'colors',
            'fuelTypes',
            'serialNumber',
            'requestType' // Add to compact
        ));
    }

    public function edit($serial_number)
    {
        $declaration = VehicleDeclaration::with('drivers') // Load only non-deleted drivers
        ->where('serial_number', $serial_number)
        ->firstOrFail();

        $vehicleTypes = VehicleType::all();
        $vehicleModels = VehicleModel::all();
        $engineCapacities = VehicleEngineCapacity::all();
        $colors = VehicleColor::all();
        $fuelTypes = FuelType::all();
        $requestType = request()->query('request_type'); // Pass request_type from query

        $deletedDrivers = VehicleDeclaration::find($declaration->id)
        ->drivers()
        ->onlyTrashed()
        ->get();

        return view('vehicle-declaration-form', compact(
            'declaration',
            'vehicleTypes',
            'deletedDrivers',
            'vehicleModels',
            'engineCapacities',
            'colors',
            'fuelTypes',
            'requestType' // Add to compact
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // Handle file uploads
        $filePaths = $this->handleFileUploads($request, null);

        // Create vehicle declaration
        $declaration = VehicleDeclaration::create(array_merge(
            $request->except(['drivers', ...array_keys($filePaths)]),
            $filePaths
        ));

        // Create associated drivers
        if ($request->has('drivers')) {
            foreach ($request->drivers as $driverData) {
                $declaration->drivers()->create($driverData);
            }
        }

        return redirect()->route('vehicle.request.all')->with('success', 'Vehicle declaration submitted successfully!');
    }

    public function update(Request $request, $id)
    {
        $declaration = VehicleDeclaration::findOrFail($id);
        $validated = $this->validateRequest($request, $id);

        // Handle file uploads
        $filePaths = $this->handleFileUploads($request, $declaration);

        // Update vehicle declaration
        $declaration->update(array_merge(
            $request->except(['drivers', ...array_keys($filePaths)]),
            $filePaths
        ));

        // Sync drivers with soft delete
        $existingDriverIds = $declaration->drivers()->withTrashed()->pluck('id')->toArray();
        $submittedDriverIds = array_filter(array_column($request->drivers, 'id'));

        // Soft delete drivers not in the submitted list
        Driver::whereIn('id', array_diff($existingDriverIds, $submittedDriverIds))->delete();

        // Update or create drivers
        if ($request->has('drivers')) {
            foreach ($request->drivers as $driverData) {
                if (isset($driverData['id']) && in_array($driverData['id'], $existingDriverIds)) {
                    $driver = Driver::withTrashed()->find($driverData['id']);
                    if ($driver->trashed()) {
                        $driver->restore(); // Restore soft-deleted driver if resubmitted
                    }
                    $driver->update($driverData);
                } else {
                    $declaration->drivers()->create($driverData);
                }
            }
        }

        return redirect()->route('vehicle.request.all')->with('success', 'Vehicle declaration updated successfully!');
    }

    public function restoreDriver($id)
    {
        $driver = Driver::withTrashed()->findOrFail($id);
        $driver->restore();
        return back()->with('success', 'Driver restored successfully!');
    }

    private function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'serial_number' => ['required', 'string', 'exists:vehicle_requests,serial_number', $id ? 'unique:vehicle_declarations,serial_number,' . $id : 'unique:vehicle_declarations,serial_number'],
            'registration_number' => 'required|string|max:255',
            'owner_full_name' => 'required|string|max:255',
            'owner_initials_name' => 'required|string|max:255',
            'owner_permanent_address' => 'required|string|max:255',
            'owner_temporary_address' => 'nullable|string|max:255',
            'owner_phone_number' => 'required|string|max:20',
            'owner_bank_details' => 'required|string|max:255',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'seats_registered' => 'required|integer|min:1',
            'seats_current' => 'required|integer|min:1',
            'loan_tax_details' => 'nullable|string|max:255',
            'daily_rent' => 'required|numeric|min:0',
            'induction_date' => 'required|date',
            'drivers' => 'required|array|min:1',
            'drivers.*.id' => 'nullable|exists:drivers,id',
            'drivers.*.reg_nic' => 'required|string|max:255',
            'drivers.*.rank' => 'required|string|max:255',
            'drivers.*.driver_name' => 'required|string|max:255',
            'drivers.*.unit' => 'required|string|max:255',
            'drivers.*.code_no_driver' => 'nullable|string|max:255',
            'drivers.*.army_license_no' => 'required|string|max:255',
            'drivers.*.license_issued_date' => 'required|date',
            'drivers.*.license_expire_date' => 'required|date|after:drivers.*.license_issued_date',
            'civil_number' => 'required|string|max:255',
            'product_classification' => 'required|string|max:255',
            'engine_no' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'year_of_manufacture' => 'required|integer|min:1900',
            'date_of_original_registration' => 'required|date',
            'engine_capacity_id' => 'required|exists:vehicle_engine_capacities,id',
            'section_4_w_2w' => 'required|string|max:255',
            'speedometer_hours' => 'required|integer|min:0',
            'code_no_vehicle' => 'required|string|max:255',
            'color_id' => 'required|exists:vehicle_colors,id',
            'pay_per_day' => 'required|numeric|min:0',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'tar_weight_capacity' => 'required|string|max:255',
            'amount_of_fuel' => 'required|numeric|min:0',
            'reason_for_taking_over' => 'required|string|max:255',
            'other_matters' => 'nullable|string|max:255',
            'registration_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'insurance_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'revenue_license_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'owners_certified_nic' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'owners_certified_bank_passbook' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'suppliers_scanned_sign_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'affidavit_non_joint_account' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'affidavit_army_driver' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
    }

    private function handleFileUploads(Request $request, $declaration = null)
    {
        $fileFields = [
            'registration_certificate',
            'insurance_certificate',
            'revenue_license_certificate',
            'owners_certified_nic',
            'owners_certified_bank_passbook',
            'suppliers_scanned_sign_document',
            'affidavit_non_joint_account',
            'affidavit_army_driver',
        ];

        $filePaths = [];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if updating
                if ($declaration && $declaration->$field) {
                    Storage::disk('public')->delete($declaration->$field);
                }
                $filePaths[$field] = $request->file($field)->store('declarations', 'public');
            } else {
                $filePaths[$field] = $declaration->$field ?? null;
            }
        }

        return $filePaths;
    }
}