<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstablishmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $establishments = Establishment::query();

        if ($search) {
            $establishments->where('name', 'LIKE', "%{$search}%");
        }

        // Fetch all establishments (for client-side pagination in Blade)
        $establishments = $establishments->get();
        Log::info('Fetched establishments: ', $establishments->toArray());

        // Check if view exists (for debugging)
        if (!view()->exists('establishments')) {
            abort(404, 'View establishments not found');
        }

        return view('establishments', compact('establishments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:establishments,e_name',
        ]);

        Establishment::create([
            'e_name' => $request->name,
            'abb_name' => '',  // Changed from null to empty string to satisfy NOT NULL constraint
            'type_code' => 0,  // Default value (adjust if needed based on business logic)
        ]);

        return redirect()->route('establishments.index')->with('success', 'Establishment added successfully.');
    }

    public function update(Request $request, $e_id)
    {
        $establishment = Establishment::findOrFail($e_id);

        $request->validate([
            'name' => 'required|string|max:255|unique:establishments,name,' . $establishment->e_id,
        ]);

        $establishment->update([
            'name' => $request->name,
        ]);

        return redirect()->route('establishments.index')->with('success', 'Establishment updated successfully.');
    }

    public function destroy($e_id)
    {
        Log::info("Attempting to delete establishment with e_id: {$e_id}");
        $establishment = Establishment::findOrFail($e_id);

        // Since soft deletes aren't supported (no deleted_at column), use hard delete
        $success = $establishment->forceDelete(); // Use forceDelete() or remove if not needed
        Log::info("Delete result for e_id {$e_id}: " . ($success ? 'Success' : 'Failed'));

        return redirect()->back()->with('success', 'Establishment deleted successfully!');
    }
}