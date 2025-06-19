<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleType;
use App\Models\VehicleModel;
use App\Models\VehicleDeclaration;

class VehicleDeclarationFormController extends Controller
{
    public function index()
    {
        // Optionally, list all declarations or redirect to create
        return redirect()->route('vehicle-declaration.create');
    }

    public function create()
    {
        $vehicleTypes = VehicleType::all();
        $vehicleModels = VehicleModel::all();
        \Log::info('Vehicle Types: ', $vehicleTypes->toArray());
        \Log::info('Vehicle Models: ', $vehicleModels->toArray());
        return view('vehicle-declaration-form', compact('vehicleTypes', 'vehicleModels'));
    }
        public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'registration_number' => 'required|string|max:255|unique:vehicle_declarations',
            'owner_full_name' => 'required|string|max:255',
            'owner_initials_name' => 'required|string|max:255',
            'owner_permanent_address' => 'required|string|max:255',
            'owner_temporary_address' => 'nullable|string|max:255',
            'owner_phone_number' => 'required|string|max:20',
            'owner_bank_details' => 'required|string|max:255',
            'vehicle_type' => 'required|exists:vehicle_types,id',
            'vehicle_model' => 'required|exists:vehicle_models,id',
            'seats_registered' => 'required|integer|min:1',
            'seats_current' => 'required|integer|min:1',
            'loan_tax_details' => 'nullable|string|max:255',
            'daily_rent' => 'required|numeric|min:0',
            'induction_date' => 'required|date',
            'owner_next_of_kin' => 'required|string|max:255',
            'driver_full_name' => 'required|string|max:255',
            'driver_address' => 'required|string|max:255',
            'driver_license_number' => 'required|string|max:255',
            'driver_nic_number' => 'required|string|max:255',
            'driver_next_of_kin' => 'required|string|max:255',
            'civil_number' => 'required|string|max:255',
            'product_classification' => 'required|string|max:255',
            'engine_no' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'year_of_manufacture' => 'required|integer',
            'date_of_original_registration' => 'required|date',
            'engine_capacity' => 'required|string|max:255',
            'section_4_w_2w' => 'required|string|max:255',
            'speedometer_hours' => 'required|integer',
            'code_no' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'pay_per_day' => 'required|numeric|min:0',
            'type_of_fuel' => 'required|string|max:255',
            'tar_weight_capacity' => 'required|string|max:255',
            'amount_of_fuel' => 'required|numeric|min:0',
            'reason_for_taking_over' => 'required|string|max:255',
            'other_matters' => 'nullable|string|max:255',
            'registration_certificate' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'insurance_certificate' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'Revenue_License_Certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'Owners_certified_NIC' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'Owners_Certified_Bank_Passbook' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'Supliers_Scanned_Sign_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'Affidavit_non-joint_Account' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'Affidavit_Army_Driver' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Handle file uploads
        $filePaths = [];
        $files = [
            'registration_certificate' => 'registration_certificate_path',
            'insurance_certificate' => 'insurance_certificate_path',
            'Revenue_License_Certificate' => 'revenue_license_certificate_path',
            'Owners_certified_NIC' => 'owners_certified_nic_path',
            'Owners_Certified_Bank_Passbook' => 'owners_certified_bank_passbook_path',
            'Supliers_Scanned_Sign_document' => 'suppliers_scanned_sign_document_path',
            'Affidavit_non-joint_Account' => 'affidavit_non_joint_account_path',
            'Affidavit_Army_Driver' => 'affidavit_army_driver_path',
        ];

        foreach ($files as $inputName => $columnName) {
            if ($request->hasFile($inputName)) {
                $filePaths[$columnName] = $request->file($inputName)->store('documents', 'public');
            }
        }

        // Prepare data for saving
        $data = [
            'registration_number' => $validated['registration_number'],
            'owner_full_name' => $validated['owner_full_name'],
            'owner_initials_name' => $validated['owner_initials_name'],
            'owner_permanent_address' => $validated['owner_permanent_address'],
            'owner_temporary_address' => $validated['owner_temporary_address'],
            'owner_phone_number' => $validated['owner_phone_number'],
            'owner_bank_details' => $validated['owner_bank_details'],
            'vehicle_type_id' => $validated['vehicle_type'],
            'vehicle_model_id' => $validated['vehicle_model'],
            'seats_registered' => $validated['seats_registered'],
            'seats_current' => $validated['seats_current'],
            'loan_tax_details' => $validated['loan_tax_details'],
            'daily_rent' => $validated['daily_rent'],
            'induction_date' => $validated['induction_date'],
            'owner_next_of_kin' => $validated['owner_next_of_kin'],
            'driver_full_name' => $validated['driver_full_name'],
            'driver_address' => $validated['driver_address'],
            'driver_license_number' => $validated['driver_license_number'],
            'driver_nic_number' => $validated['driver_nic_number'],
            'driver_next_of_kin' => $validated['driver_next_of_kin'],
            'civil_number' => $validated['civil_number'],
            'product_classification' => $validated['product_classification'],
            'engine_no' => $validated['engine_no'],
            'chassis_number' => $validated['chassis_number'],
            'year_of_manufacture' => $validated['year_of_manufacture'],
            'date_of_original_registration' => $validated['date_of_original_registration'],
            'engine_capacity' => $validated['engine_capacity'],
            'section_4_w_2w' => $validated['section_4_w_2w'],
            'speedometer_hours' => $validated['speedometer_hours'],
            'code_no' => $validated['code_no'],
            'color' => $validated['color'],
            'pay_per_day' => $validated['pay_per_day'],
            'type_of_fuel' => $validated['type_of_fuel'],
            'tar_weight_capacity' => $validated['tar_weight_capacity'],
            'amount_of_fuel' => $validated['amount_of_fuel'],
            'reason_for_taking_over' => $validated['reason_for_taking_over'],
            'other_matters' => $validated['other_matters'],
        ];

        // Merge file paths
        $data = array_merge($data, $filePaths);

        // Save to database
        VehicleDeclaration::create($data);

        return redirect()->route('vehicle-declaration.create')->with('success', 'Vehicle declaration submitted successfully!');
    }

    public function getVehicleModels($vehicleTypeId)
    {
        $vehicleModels = VehicleModel::where('vehicle_type_id', $vehicleTypeId)->get();
        return response()->json($vehicleModels);
    }
}