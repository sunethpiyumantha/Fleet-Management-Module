<?php
namespace App\Http\Controllers;
use App\Models\VehicleAllocationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class VehicleAllocationTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = VehicleAllocationType::query();
        if ($search) {
            $query->where('type', 'LIKE', "%{$search}%");
        }
        $types = $query->orderBy('type')->paginate();
        return view('vehicle-allocation-type', compact('types'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255|unique:vehicle_allocation_types,type',
        ]);
        if ($validator->fails()) {
            return redirect()->route('vehicle-allocation-type.index')
                             ->withErrors($validator)
                             ->withInput();
        }
        VehicleAllocationType::create($request->only('type'));
        return redirect()->route('vehicle-allocation-type.index')
                         ->with('success', 'Vehicle Allocation Type added successfully.');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255|unique:vehicle_allocation_types,type,' . $id,
        ]);
        if ($validator->fails()) {
            return redirect()->route('vehicle-allocation-type.index')
                             ->withErrors($validator)
                             ->withInput();
        }
        $type = VehicleAllocationType::findOrFail($id);
        $type->update($request->only('type'));
        return redirect()->route('vehicle-allocation-type.index')
                         ->with('success', 'Vehicle Allocation Type updated successfully.');
    }
    public function destroy($id)
    {
        $type = VehicleAllocationType::findOrFail($id);
        $type->delete();
        return redirect()->route('vehicle-allocation-type.index')
                         ->with('success', 'Vehicle Allocation Type deleted successfully.');
    }
}