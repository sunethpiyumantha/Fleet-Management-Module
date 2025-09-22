<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequestApproval;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleRequestApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = VehicleRequestApproval::with(['category', 'subCategory'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                  ->orWhere('request_type', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($sub) use ($search) {
                      $sub->where('category', 'like', "%{$search}%");
                  })
                  ->orWhereHas('subCategory', function ($sub) use ($search) {
                      $sub->where('sub_category', 'like', "%{$search}%");
                  })
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $approvals = $query->paginate(10);
        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();

        return view('request-vehicle-2', compact('approvals', 'categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
            'vehicle_book' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120', // 5MB max
        ]);

        // Generate unique serial number
        do {
            $serialNumber = 'VRA-' . date('Y') . '-' . strtoupper(Str::random(6));
        } while (VehicleRequestApproval::where('serial_number', $serialNumber)->exists());

        // Handle file upload
        $vehicleLetterPath = null;
        if ($request->hasFile('vehicle_book')) {
            $file = $request->file('vehicle_book');
            $filename = time() . '_' . $serialNumber . '.' . $file->getClientOriginalExtension();
            $vehicleLetterPath = $file->storeAs('vehicle_letters', $filename, 'public');
        }

        VehicleRequestApproval::create([
            'serial_number' => $serialNumber,
            'request_type' => $request->request_type,
            'category_id' => $request->cat_id,
            'sub_category_id' => $request->sub_cat_id,
            'quantity' => $request->qty,
            'vehicle_letter' => $vehicleLetterPath,
        ]);

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request submitted successfully! Serial: ' . $serialNumber);
    }

    public function show(VehicleRequestApproval $vehicleRequestApproval)
    {
        $vehicleRequestApproval->load(['category', 'subCategory', 'approver']);
        return view('vehicle-request-approvals.show', compact('vehicleRequestApproval'));
    }

    public function edit(VehicleRequestApproval $vehicleRequestApproval)
    {
        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();
        return view('vehicle-request-approvals.edit', compact('vehicleRequestApproval', 'categories', 'subCategories'));
    }

    public function update(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
            'vehicle_book' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('vehicle_book')) {
            // Delete old file if exists
            if ($vehicleRequestApproval->vehicle_letter) {
                Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
            }
            
            $file = $request->file('vehicle_book');
            $filename = time() . '_' . $vehicleRequestApproval->serial_number . '.' . $file->getClientOriginalExtension();
            $vehicleLetterPath = $file->storeAs('vehicle_letters', $filename, 'public');
        } else {
            $vehicleLetterPath = $vehicleRequestApproval->vehicle_letter;
        }

        // Update status and approver if approved/rejected
        $updateData = [
            'request_type' => $request->request_type,
            'category_id' => $request->cat_id,
            'sub_category_id' => $request->sub_cat_id,
            'quantity' => $request->qty,
            'vehicle_letter' => $vehicleLetterPath,
            'notes' => $request->notes,
            'status' => $request->status,
        ];

        if (in_array($request->status, ['approved', 'rejected'])) {
            $updateData['approved_at'] = now();
            $updateData['approved_by'] = auth()->id();
        }

        $vehicleRequestApproval->update($updateData);

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request updated successfully!');
    }

    public function destroy(VehicleRequestApproval $vehicleRequestApproval)
    {
        // Delete associated file
        if ($vehicleRequestApproval->vehicle_letter) {
            Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
        }

        $vehicleRequestApproval->delete();

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request deleted successfully!');
    }
}