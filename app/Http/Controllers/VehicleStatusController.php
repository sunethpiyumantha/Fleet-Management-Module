<?php
namespace App\Http\Controllers;

use App\Models\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleStatusController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = VehicleStatus::query();

        if ($search) {
            $query->where('status', 'LIKE', "%{$search}%");
        }

        $statuses = $query->get();
        \Log::info('Fetched Vehicle Statuses: ', $statuses->toArray());

        return view('vehicle-status', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:255|unique:vehicle_statuses',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-status.index')->withErrors($validator)->withInput();
        }

        VehicleStatus::create($request->only('status'));
        return redirect()->route('vehicle-status.index')->with('success', 'Vehicle status added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:255|unique:vehicle_statuses,status,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-status.index')->withErrors($validator)->withInput();
        }

        $status = VehicleStatus::findOrFail($id);
        $status->update($request->only('status'));
        return redirect()->route('vehicle-status.index')->with('success', 'Vehicle status updated successfully.');
    }

    public function destroy($id)
    {
        \Log::info("Attempting to soft delete vehicle status ID: {$id}");
        $status = VehicleStatus::findOrFail($id);
        $success = $status->delete();
        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));
        return redirect()->route('vehicle-status.index')->with('success', 'Vehicle status deleted successfully.');
    }
}