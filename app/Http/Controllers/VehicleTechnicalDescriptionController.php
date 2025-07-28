<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequest;
use App\Models\VehicleDeclaration;
use App\Models\VehicleTechnicalDescription;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleTechnicalDescriptionController extends Controller
{
    public function create($serial_number, $request_type)
    {
        try {
            // Fetch the vehicle request with its category
            $vehicleRequest = VehicleRequest::with('category')
                ->where('serial_number', $serial_number)
                ->firstOrFail();

            // Fetch the vehicle declaration with related data
            $vehicleDeclaration = VehicleDeclaration::with([
                'vehicleType',
                'vehicleModel',
                'fuelType',
                'engineCapacity',
                'drivers' => function ($query) {
                    $query->whereNull('deleted_at');
                }
            ])
                ->where('serial_number', $serial_number)
                ->firstOrFail();

            // Fetch all vehicle categories for the dropdown
            $categories = VehicleCategory::orderBy('category')->get();

            return view('vehicle-technical-description', compact('vehicleRequest', 'vehicleDeclaration', 'request_type', 'categories'));
        } catch (\Exception $e) {
            Log::error("Error in VehicleTechnicalDescriptionController@create: {$e->getMessage()}", [
                'serial_number' => $serial_number,
                'request_type' => $request_type
            ]);
            return redirect()->back()->with('error', 'Failed to load vehicle technical description form.');
        }
    }

    public function store(Request $request, $serial_number)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'gross_weight' => 'required|numeric|min:0', // Changed to numeric for weight
                'seats_sleme' => 'required|integer|min:1',  // Changed to integer for seats
                'comparable' => 'required|in:yes,no',
                'seats_mvr' => 'required|integer|min:1',    // Changed to integer for seats
            ]);

            // Create technical description
            VehicleTechnicalDescription::create([
                'serial_number' => $serial_number,
                'gross_weight' => $validated['gross_weight'],
                'seats_sleme' => $validated['seats_sleme'],
                'comparable' => $validated['comparable'],
                'seats_mvr' => $validated['seats_mvr'],
            ]);

            return redirect()->route('vehicle.inspection.index')
                ->with('success', 'Technical description submitted successfully.');
        } catch (\Exception $e) {
            Log::error("Error in VehicleTechnicalDescriptionController@store: {$e->getMessage()}", [
                'serial_number' => $serial_number,
                'input' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to submit technical description.');
        }
    }

    public function destroy($serial_number)
    {
        try {
            // Start a transaction to ensure data consistency
            \DB::beginTransaction();

            // Fetch the vehicle declaration (including soft-deleted ones)
            $vehicleDeclaration = VehicleDeclaration::withTrashed()
                ->where('serial_number', $serial_number)
                ->firstOrFail();

            // Soft delete related technical description if it exists
            $technicalDescription = VehicleTechnicalDescription::where('serial_number', $serial_number)->first();
            if ($technicalDescription) {
                $technicalDescription->delete();
                Log::info("Soft deleted VehicleTechnicalDescription for serial_number: {$serial_number}");
            }

            // Soft delete the vehicle declaration
            $vehicleDeclaration->delete();

            \DB::commit();
            return redirect()->route('vehicle.inspection.index')
                ->with('success', 'Declaration and related technical description soft deleted successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error("Error in VehicleTechnicalDescriptionController@destroy: {$e->getMessage()}", [
                'serial_number' => $serial_number
            ]);
            return redirect()->back()->with('error', 'Failed to delete declaration: ' . $e->getMessage());
        }
    }
}