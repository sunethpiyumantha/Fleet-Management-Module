<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use Illuminate\Http\Request;

class VehicleSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort', 'category');
        $order = $request->query('order', 'asc');

        $query = VehicleSubCategory::query()
            ->join('vehicle_categories', 'vehicle_sub_categories.cat_id', '=', 'vehicle_categories.id')
            ->select('vehicle_sub_categories.*', 'vehicle_categories.category')
            ->when($search, fn($q) => $q->where('vehicle_categories.category', 'like', "%{$search}%")
                                        ->orWhere('vehicle_sub_categories.sub_category', 'like', "%{$search}%"))
            ->orderBy($sort == 'category' ? 'vehicle_categories.category' : 'vehicle_sub_categories.sub_category', $order);

        $subCategories = $query->paginate(10);
        $categories = VehicleCategory::all();

        return view('vehicle-sub-category', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_category' => 'required|string|max:255',
        ]);

        VehicleSubCategory::create([
            'cat_id' => $request->cat_id,
            'sub_category' => $request->sub_category,
        ]);

        return redirect()->route('vehicle-sub-category.index')->with('success', 'Sub-category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_category' => 'required|string|max:255',
        ]);

        $subCategory = VehicleSubCategory::findOrFail($id);
        $subCategory->update([
            'cat_id' => $request->cat_id,
            'sub_category' => $request->sub_category,
        ]);

        return redirect()->route('vehicle-sub-category.index')->with('success', 'Sub-category updated successfully.');
    }

    public function destroy($id)
    {
        $subCategory = VehicleSubCategory::findOrFail($id);
        $subCategory->delete();

        return redirect()->route('vehicle-sub-category.index')->with('success', 'Sub-category deleted successfully.');
    }
}