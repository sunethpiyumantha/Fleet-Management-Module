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

        $subCategories = $query->orderBy($sort, $order)->get();
        $categories = VehicleCategory::all();

        return view('vehicle-sub-category', compact('subCategories', 'categories'));
    }

   public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cat_id' => 'required|integer|exists:vehicle_categories,id',
                'sub_category' => 'required|string|max:255',
            ]);

            $validated['sub_category'] = trim($validated['sub_category']);

            $exists = VehicleSubCategory::where('cat_id', $validated['cat_id'])
                ->where('sub_category', $validated['sub_category'])
                ->exists();

            if ($exists) {
                return redirect()->route('vehicle-sub-category.index')->withErrors([
                    'error' => 'The subcategory "' . $validated['sub_category'] . '" already exists for this category.',
                ])->withInput();
            }

            VehicleSubCategory::create($validated);

            return redirect()->route('vehicle-sub-category.index')->with('success', 'Vehicle subcategory created successfully!');
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->route('vehicle-sub-category.index')->withErrors([
                'error' => 'The subcategory "' . $validated['sub_category'] . '" already exists for this category.',
            ])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'cat_id' => 'required|integer|exists:vehicle_categories,id',
                'sub_category' => 'required|string|max:255',
            ]);

            $subCategory = VehicleSubCategory::findOrFail($id);

            $exists = VehicleSubCategory::where('cat_id', $validated['cat_id'])
                ->where('sub_category', trim($validated['sub_category']))
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return redirect()->route('vehicle-sub-category.index')->withErrors([
                    'error' => 'The subcategory "' . $validated['sub_category'] . '" already exists for this category.',
                ])->withInput();
            }

            $subCategory->update($validated);

            return redirect()->route('vehicle-sub-category.index')->with('success', 'Vehicle subcategory updated successfully!');
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->route('vehicle-sub-category.index')->withErrors([
                'error' => 'The subcategory "' . $validated['sub_category'] . '" already exists for this category.',
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        $subCategory = VehicleSubCategory::findOrFail($id);
        $subCategory->delete();

        return redirect()->route('vehicle-sub-category.index')->with('success', 'Vehicle subcategory deleted successfully!');
    }
}