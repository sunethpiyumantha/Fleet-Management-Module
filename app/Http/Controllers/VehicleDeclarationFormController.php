<?php

namespace App\Http\Controllers;

use App\Models\VehicleDeclaration;
use App\Models\VehicleType;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VehicleDeclarationFormController extends Controller
{
    /**
     * Display the vehicle declaration form
     */
    public function index()
    {
        $vehicleTypes = VehicleType::withTrashed()->get(); // Include soft-deleted records for testing
        $vehicleDeclarations = VehicleDeclaration::with(['vehicleType', 'vehicleModel'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Debug: Check if vehicleTypes has data
        // dd($vehicleTypes);
        
        return view('vehicle-declaration-form', compact('vehicleTypes', 'vehicleDeclarations'));
    }

    /**
     * Store a newly created vehicle declaration
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|string|max:255|unique:vehicle_declarations,registration_number',
            'owner_full_name' => 'required|string|max:255',
            'owner_initials_name' => 'required|string|max:255',
            'owner_permanent_address' => 'required|string',
            'owner_temporary_address' => 'nullable|string',
            'owner_phone_number' => 'required|string|max:20',
            'owner_bank_details' => 'required|string',
            'vehicle_type' => 'required|exists:vehicle_types,id',
            'vehicle_model' => 'required|exists:vehicle_models,id',
            'seats_registered' => 'required|integer|min:1',
            'seats_current' => 'required|integer|min:1',
            'registration_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
            'insurance_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
            'loan_tax_details' => 'nullable|string',
            'daily_rent' => 'required|numeric|min:0',
            'induction_date' => 'required|date',
            'owner_next_of_kin' => 'required|string|max:255',
            'driver_full_name' => 'required|string|max:255',
            'driver_address' => 'required|string',
            'driver_license_number' => 'required|string|max:255',
            'driver_nic_number' => 'required|string|max:20',
            'driver_next_of_kin' => 'required|string|max:255',
            'document_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_4' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->except(['_token', 'registration_certificate', 'insurance_certificate', 'document_1', 'document_2', 'document_3', 'document_4']);
            $data['vehicle_type_id'] = $request->vehicle_type;
            $data['vehicle_model_id'] = $request->vehicle_model;

            // Handle file uploads
            if ($request->hasFile('registration_certificate')) {
                $data['registration_certificate'] = $request->file('registration_certificate')->store('vehicle_declarations/certificates', 'public');
            }

            if ($request->hasFile('insurance_certificate')) {
                $data['insurance_certificate'] = $request->file('insurance_certificate')->store('vehicle_declarations/certificates', 'public');
            }

            // Handle additional documents
            for ($i = 1; $i <= 4; $i++) {
                $fieldName = "document_$i";
                if ($request->hasFile($fieldName)) {
                    $data[$fieldName] = $request->file($fieldName)->store('vehicle_declarations/documents', 'public');
                }
            }

            VehicleDeclaration::create($data);

            DB::commit();

            return redirect()->back()->with('success', 'Vehicle declaration submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit vehicle declaration. Please try again.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified vehicle declaration
     */
    public function edit($id)
    {
        $vehicleDeclaration = VehicleDeclaration::findOrFail($id);
        $vehicleTypes = VehicleType::active()->get();
        $vehicleModels = VehicleModel::active()->byVehicleType($vehicleDeclaration->vehicle_type_id)->get();
        
        return view('vehicle-declaration-form', compact('vehicleDeclaration', 'vehicleTypes', 'vehicleModels'));
    }

    /**
     * Update the specified vehicle declaration
     */
    public function update(Request $request, $id)
    {
        $vehicleDeclaration = VehicleDeclaration::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|string|max:255|unique:vehicle_declarations,registration_number,' . $id,
            'owner_full_name' => 'required|string|max:255',
            'owner_initials_name' => 'required|string|max:255',
            'owner_permanent_address' => 'required|string',
            'owner_temporary_address' => 'nullable|string',
            'owner_phone_number' => 'required|string|max:20',
            'owner_bank_details' => 'required|string',
            'vehicle_type' => 'required|exists:vehicle_types,id',
            'vehicle_model' => 'required|exists:vehicle_models,id',
            'seats_registered' => 'required|integer|min:1',
            'seats_current' => 'required|integer|min:1',
            'registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'insurance_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'loan_tax_details' => 'nullable|string',
            'daily_rent' => 'required|numeric|min:0',
            'induction_date' => 'required|date',
            'owner_next_of_kin' => 'required|string|max:255',
            'driver_full_name' => 'required|string|max:255',
            'driver_address' => 'required|string',
            'driver_license_number' => 'required|string|max:255',
            'driver_nic_number' => 'required|string|max:20',
            'driver_next_of_kin' => 'required|string|max:255',
            'document_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_4' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->except(['_token', '_method', 'registration_certificate', 'insurance_certificate', 'document_1', 'document_2', 'document_3', 'document_4']);
            $data['vehicle_type_id'] = $request->vehicle_type;
            $data['vehicle_model_id'] = $request->vehicle_model;

            // Handle file uploads and delete old files
            if ($request->hasFile('registration_certificate')) {
                if ($vehicleDeclaration->registration_certificate) {
                    Storage::disk('public')->delete($vehicleDeclaration->registration_certificate);
                }
                $data['registration_certificate'] = $request->file('registration_certificate')->store('vehicle_declarations/certificates', 'public');
            }

            if ($request->hasFile('insurance_certificate')) {
                if ($vehicleDeclaration->insurance_certificate) {
                    Storage::disk('public')->delete($vehicleDeclaration->insurance_certificate);
                }
                $data['insurance_certificate'] = $request->file('insurance_certificate')->store('vehicle_declarations/certificates', 'public');
            }

            // Handle additional documents
            for ($i = 1; $i <= 4; $i++) {
                $fieldName = "document_$i";
                if ($request->hasFile($fieldName)) {
                    if ($vehicleDeclaration->$fieldName) {
                        Storage::disk('public')->delete($vehicleDeclaration->$fieldName);
                    }
                    $data[$fieldName] = $request->file($fieldName)->store('vehicle_declarations/documents', 'public');
                }
            }

            $vehicleDeclaration->update($data);

            DB::commit();

            return redirect()->route('vehicle-declaration.index')->with('success', 'Vehicle declaration updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update vehicle declaration. Please try again.')->withInput();
        }
    }

    /**
     * Remove the specified vehicle declaration (Soft Delete)
     */
    public function destroy($id)
    {
        try {
            $vehicleDeclaration = VehicleDeclaration::findOrFail($id);
            $vehicleDeclaration->delete(); // This will soft delete

            return redirect()->back()->with('success', 'Vehicle declaration deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete vehicle declaration. Please try again.');
        }
    }

    /**
     * Restore a soft deleted vehicle declaration
     */
    public function restore($id)
    {
        try {
            $vehicleDeclaration = VehicleDeclaration::withTrashed()->findOrFail($id);
            $vehicleDeclaration->restore();

            return redirect()->back()->with('success', 'Vehicle declaration restored successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore vehicle declaration. Please try again.');
        }
    }

    /**
     * Get vehicle models by vehicle type (AJAX)
     */
    public function getVehicleModels($vehicleTypeId)
    {
        $vehicleModels = VehicleModel::active()->byVehicleType($vehicleTypeId)->get();
        
        return response()->json($vehicleModels);
    }

    /**
     * Show the specified vehicle declaration
     */
    public function show($id)
    {
        $vehicleDeclaration = VehicleDeclaration::with(['vehicleType', 'vehicleModel'])->findOrFail($id);
        
        return view('vehicle-declaration-show', compact('vehicleDeclaration'));
    }
}