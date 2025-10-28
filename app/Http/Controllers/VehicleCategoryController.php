<?php
namespace App\Http\Controllers;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = VehicleCategory::all();
        \Log::info('Fetched Vehicle Category: ', $categories->toArray());

        $search = $request->query('search');
        $query = VehicleCategory::query();
        if ($search) {
            $query->where('category', 'LIKE', "%{$search}%");
        }
        $categories = $query->orderBy('category')->paginate();
        return view('vehicle-category', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255|unique:vehicle_categories,category',
        ]);
        if ($validator->fails()) {
            return redirect()->route('vehicle-category.index')
                             ->withErrors($validator)
                             ->withInput();
        }
        VehicleCategory::create($request->only('category'));
        return redirect()->route('vehicle-category.index')
                         ->with('success', 'Vehicle Category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255|unique:vehicle_categories,category,' . $id,
        ]);
        if ($validator->fails()) {
            return redirect()->route('vehicle-category.index')
                             ->withErrors($validator)
                             ->withInput();
        }
        $category = VehicleCategory::findOrFail($id);
        $category->update($request->only('category'));
        return redirect()->route('vehicle-category.index')
                         ->with('success', 'Vehicle Category updated successfully.');
    }

    public function destroy($id)
{
    \Log::info("Attempting to soft delete Vehicle Category ID: {$id}");

    try {
        $category = VehicleCategory::findOrFail($id);
        $success = $category->delete();

        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));

        if ($success) {
            // Use 'error' key so it shows in red
            return redirect()->back()->with('error', 'Vehicle Category deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Vehicle Category.');
        }
    } catch (\Exception $e) {
        \Log::error("Failed to delete Vehicle Category ID {$id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the Vehicle Category.');
    }
}

}