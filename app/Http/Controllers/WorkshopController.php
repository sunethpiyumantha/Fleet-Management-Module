<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkshopController extends Controller
{
    public function index(Request $request)
    {
        $workshops = Workshop::all();
        $search = $request->query('search');
        $workshops = Workshop::when($search, function ($query, $search) {
            return $query->where('workshop_type', 'like', "%{$search}%");
        })->paginate();

        return view('workshop', compact('workshops'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workshop_type' => 'required|unique:workshops,workshop_type',
        ]);

        if ($validator->fails()) {
            return redirect()->route('workshops.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        Workshop::create($request->only('workshop_type'));

        return redirect()->route('workshops.index')
                         ->with('success', 'Workshop type added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'workshop_type' => 'required|unique:workshops,workshop_type',
        ]);

        if ($validator->fails()) {
            return redirect()->route('workshops.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        $workshop = Workshop::findOrFail($id);
        $workshop->update($request->only('workshop_type'));

        return redirect()->route('workshops.index')
                         ->with('success', 'Workshop type updated successfully.');
    }

    public function destroy($id)
    {
        \Log::info("Attempting to soft delete workshop ID: {$id}");
        $workshop = Workshop::findOrFail($id);
        $success = $workshop->delete();
        \Log::info("Soft delete result for ID {$id}: " . ($success ? 'Success' : 'Failed'));
        return redirect()->back()->with('success', 'Workshop deleted successfully!');
    }
}