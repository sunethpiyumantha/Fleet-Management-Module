<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
            ->when($sort == 'category', fn($q) => $q->orderBy('vehicle_categories.category', $order))
            ->when($sort != 'category', fn($q) => $q->orderBy('vehicle_sub_categories.sub_category', $order));

        $subCategories = $query->get(); // Changed from paginate to get to fetch all records
        $categories = VehicleCategory::all();

        if ($request->expectsJson()) {
            return response()->json([
                'subCategories' => $subCategories,
                'categories' => $categories
            ]);
        }

        return view('vehicle-sub-category', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cat_id' => 'required|integer|exists:vehicle_categories,id',
                'sub_category' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-]+$/',
            ], [
                'sub_category.regex' => 'The sub category may only contain letters, numbers, spaces, and hyphens.'
            ]);

            $validated['sub_category'] = trim($validated['sub_category']);

            $exists = VehicleSubCategory::where('cat_id', $validated['cat_id'])
                ->where('sub_category', $validated['sub_category'])
                ->exists();

            if ($exists) {
                $error = ['error' => "The subcategory '{$validated['sub_category']}' already exists for this category."];
                return $request->expectsJson() 
                    ? response()->json($error, 422)
                    : redirect()->route('vehicle-sub-category.index')->withErrors($error)->withInput();
            }

            $subCategory = VehicleSubCategory::create($validated);
            $message = ['success' => 'Vehicle subcategory created successfully!'];

            return $request->expectsJson()
                ? response()->json(['message' => $message['success'], 'data' => $subCategory], 201)
                : redirect()->route('vehicle-sub-category.index')->with($message);
        } catch (QueryException $e) {
            $error = ['error' => "Failed to create subcategory: {$e->getMessage()}"];
            return $request->expectsJson()
                ? response()->json($error, 500)
                : redirect()->route('vehicle-sub-category.index')->withErrors($error)->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'cat_id' => 'required|integer|exists:vehicle_categories,id',
                'sub_category' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-]+$/',
            ], [
                'sub_category.regex' => 'The sub category may only contain letters, numbers, spaces, and hyphens.'
            ]);

            $subCategory = VehicleSubCategory::findOrFail($id);

            $exists = VehicleSubCategory::where('cat_id', $validated['cat_id'])
                ->where('sub_category', trim($validated['sub_category']))
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                $error = ['error' => "The subcategory '{$validated['sub_category']}' already exists for this category."];
                return $request->expectsJson()
                    ? response()->json($error, 422)
                    : redirect()->route('vehicle-sub-category.index')->withErrors($error)->withInput();
            }

            $subCategory->update($validated);
            $message = ['success' => 'Vehicle subcategory updated successfully!'];

            return $request->expectsJson()
                ? response()->json(['message' => $message['success'], 'data' => $subCategory])
                : redirect()->route('vehicle-sub-category.index')->with($message);
        } catch (QueryException $e) {
            $error = ['error' => "Failed to update subcategory: {$e->getMessage()}"];
            return $request->expectsJson()
                ? response()->json($error, 500)
                : redirect()->route('vehicle-sub-category.index')->withErrors($error)->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $subCategory = VehicleSubCategory::findOrFail($id);

            // Check if there are related vehicle requests
            if ($subCategory->vehicleRequests()->exists()) {
                $error = ['error' => 'Cannot delete subcategory because it has associated vehicle requests.'];
                return request()->expectsJson()
                    ? response()->json($error, 422)
                    : redirect()->route('vehicle-sub-category.index')->withErrors($error);
            }

            $subCategory->delete(); // Soft delete
            $message = ['success' => 'Vehicle subcategory deleted successfully!'];

            return request()->expectsJson()
                ? response()->json($message)
                : redirect()->route('vehicle-sub-category.index')->with($message);
        } catch (QueryException $e) {
            $error = ['error' => "Failed to delete subcategory: {$e->getMessage()}"];
            return request()->expectsJson()
                ? response()->json($error, 500)
                : redirect()->route('vehicle-sub-category.index')->withErrors($error);
        }
    }
}