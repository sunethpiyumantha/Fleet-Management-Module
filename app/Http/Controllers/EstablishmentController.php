<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    public function index(Request $request)
    {
        $establishments = Establishment::all();
        \Log::info('Fetched establishments: ', $establishments->toArray());

        $search = $request->query('search');
        $query = Establishment::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $establishments = $query->paginate();

        // Debug: Check if view exists
        if (view()->exists('establishments')) {
            return view('establishments', compact('establishments'));
        } else {
            dd('View establishments not found');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:establishments,name',
        ]);

        Establishment::create([
            'name' => $request->name,
        ]);

        return redirect()->route('establishments.index')->with('success', 'Establishment added successfully.');
    }

    public function update(Request $request, Establishment $establishment)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:establishments,name,' . $establishment->id,
        ]);

        $establishment->update([
            'name' => $request->name,
        ]);

        return redirect()->route('establishments.index')->with('success', 'Establishment updated successfully.');
    }

   public function destroy($id)
    {
        \Log::info("Attempting to soft delete establishment ID: {$id}");
        $establishment = Establishment::findOrFail($id);
        $success = $establishment->delete();
        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));
        return redirect()->back()->with('success', 'Establishment deleted successfully!');
    }
}