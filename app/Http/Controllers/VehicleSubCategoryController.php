<?php
namespace App\Http\Controllers;
use App\Models\VehicleSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = VehicleSubCategory::query();
        if ($search) {
            $query->where('sub_category', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
        }
        $subCategories = $query->orderBy('category')->orderBy('sub_category')->paginate();
        return view('vehicle-sub-category', compact('subCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'sub_category' => 'required|string|max:255|unique:vehicle_sub_categories,sub_category,NULL,id,category,' . $request->category,
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-sub-category.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        VehicleSubCategory::create($request->only('category', 'sub_category'));
        return redirect()->route('vehicle-sub-category.index')
                         ->with('success', 'Vehicle Sub Category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'sub_category' => 'required|string|max:255|unique:vehicle_sub_categories,sub_category,' . $id . ',id,category,' . $request->category,
        ]);

        if ($validator->fails()) {
            return redirect()->route('vehicle-sub-category.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        $subCategory = VehicleSubCategory::findOrFail($id);
        $subCategory->update($request->only('category', 'sub_category'));
        return redirect()->route('vehicle-sub-category.index')
                         ->with('success', 'Vehicle Sub Category updated successfully.');
    }

    public function destroy($id)
    {
        $subCategory = VehicleSubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->route('vehicle-sub-category.index')
                         ->with('success', 'Vehicle Sub Category deleted successfully.');
    }
}