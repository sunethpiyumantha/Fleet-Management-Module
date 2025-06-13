<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleModelController extends Controller
{
    public function index(Request $request)
    {
        $models =  VehicleModel::all();
        \Log::info('Fetched Vehicle Make: ', $models->toArray());

        $search = $request->query('search');
        $query = VehicleModel::query();

        if ($search) {
            $query->where('model', 'LIKE', "%{$search}%");
        }

        $models = $query->orderBy('model')->paginate();

        return view('vehicle-models', compact('models'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string|max:255|unique:vehicle_models,model',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-models.index')
                ->withErrors($validator)
                ->withInput();
        }

        VehicleModel::create([
            'model' => $request->input('model'),
        ]);

        return redirect()->route('vehicle-models.index')
            ->with('success', 'Vehicle model added successfully.');
    }

    public function update(Request $request, VehicleModel $vehicleModel)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string|max:255|unique:vehicle_models,model,' . $vehicleModel->id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-models.index')
                ->withErrors($validator)
                ->withInput();
        }

        $vehicleModel->update([
            'model' => $request->input('model'),
        ]);

        return redirect()->route('vehicle-models.index')
            ->with('success', 'Vehicle model updated successfully.');
    }

    public function destroy($id)
    {
        \Log::info("Attempting to soft delete vehicle model ID: {$id}");
        $vehicleModel = VehicleModel::findOrFail($id);
        $success = $vehicleModel->delete();
        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));
        return redirect()->back()->with('success', 'Vehicle model deleted successfully!');
    }

}