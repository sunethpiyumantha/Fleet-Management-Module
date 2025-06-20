<?php

namespace App\Http\Controllers;

use App\Models\VehicleDeclaration;
use App\Models\VehicleType;
use App\Models\VehicleModel;
use App\Models\VehicleEngineCapacity;
use App\Models\VehicleColor;
use App\Models\FuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleDeclarationFormController extends Controller
{
    /**
     * Show the vehicle declaration form for creating a new declaration.
     */
    public function create(Request $request)
    {
        $vehicleTypes = VehicleType::all();
        $vehicleModels = VehicleModel::all();
        $engineCapacities = VehicleEngineCapacity::all();
        $colors = VehicleColor::all();
        $fuelTypes = FuelType::all();

        $serialNumber = $request->query('serial_number');

        return view('vehicle-declaration-form', compact(
            'vehicleTypes',
            'vehicleModels',
            'engineCapacities',
            'colors',
            'fuelTypes',
            'serialNumber'
        ));
    }

    /**
     * Show the vehicle declaration form for editing an existing declaration.
     */
    public function edit($serial_number)
    {
        $declaration = VehicleDeclaration::where('serial_number', $serial_number)->firstOrFail();
        $vehicleTypes = VehicleType::all();
        $vehicleModels = VehicleModel::all();
        $engineCapacities = VehicleEngineCapacity::all();
        $colors = VehicleColor::all();
        $fuelTypes = FuelType::all();

        return view('vehicle-declaration-form', compact(
            'declaration',
            'vehicleTypes',
            'vehicleModels',
            'engineCapacities',
            'colors',
            'fuelTypes'
        ));
    }

    /**
     * Store a new vehicle declaration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|exists:vehicle_requests,serial_number',
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
            'reg_nic' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'code_no_driver' => 'nullable|string|max:255',
            'army_license_no' => 'required|string|max:255',
            'license_issued_date' => 'required|date',
            'license_expire_date' => 'required|date|after:license_issued_date',
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
                $filePaths[$field] = $request->file($field)->store('declarations', 'public');
            }
        }

        VehicleDeclaration::create(array_merge(
            $validated,
            $filePaths
        ));

        return redirect()->route('vehicle.request.all')->with('success', 'Vehicle declaration submitted successfully!');
    }

    /**
     * Update an existing vehicle declaration.
     */
    public function update(Request $request, $id)
    {
        $declaration = VehicleDeclaration::findOrFail($id);

        $validated = $request->validate([
            'serial_number' => 'required|string|exists:vehicle_requests,serial_number',
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
            'reg_nic' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'code_no_driver' => 'nullable|string|max:255',
            'army_license_no' => 'required|string|max:255',
            'license_issued_date' => 'required|date',
            'license_expire_date' => 'required|date|after:license_issued_date',
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
                // Delete old file if it exists
                if ($declaration->$field) {
                    Storage::disk('public')->delete($declaration->$field);
                }
                $filePaths[$field] = $request->file($field)->store('declarations', 'public');
            } else {
                // Retain existing file path if no new file is uploaded
                $filePaths[$field] = $declaration->$field;
            }
        }

        $declaration->update(array_merge(
            $validated,
            $filePaths
        ));

        return redirect()->route('vehicle.request.all')->with('success', 'Vehicle declaration updated successfully!');
    }
}