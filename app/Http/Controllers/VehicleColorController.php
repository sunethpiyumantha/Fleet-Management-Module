<?php
namespace App\Http\Controllers;
use App\Models\VehicleColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = VehicleColor::all();
        \Log::info('Fetched Vehicle Color: ', $colors->toArray());

        $search = $request->query('search');
        $query = VehicleColor::query();

        if ($search) {
            $query->where('color', 'LIKE', "%{$search}%");
        }

        $colors = $query->get();
        return view('vehicle-color', compact('colors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required|string|max:250|unique:vehicle_colors,color',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-color.index')
                ->withErrors($validator)
                ->withInput();
        }

        VehicleColor::create([
            'color' => $request->color,
        ]);

        return redirect()->route('vehicle-color.index')
            ->with('success', 'Vehicle color added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required|string|max:250|unique:vehicle_colors,color',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-color.index')
                ->withErrors($validator)
                ->withInput();
        }

        $color = VehicleColor::findOrFail($id);
        $color->update([
            'color' => $request->color,
        ]);

        return redirect()->route('vehicle-color.index')
            ->with('success', 'Vehicle color updated successfully.');
    }

    public function destroy($id)
{
    \Log::info("Attempting to soft delete Vehicle Color ID: {$id}");

    try {
        $color = VehicleColor::findOrFail($id);
        $success = $color->delete();

        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));

        if ($success) {
            // Use 'error' key so the message appears in red
            return redirect()->back()->with('error', 'Vehicle Color deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Vehicle Color.');
        }
    } catch (\Exception $e) {
        \Log::error("Failed to delete Vehicle Color ID {$id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the Vehicle Color.');
    }
}

}
