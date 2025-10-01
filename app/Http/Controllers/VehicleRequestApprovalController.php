<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequestApproval;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $query = VehicleRequestApproval::with(['category', 'subCategory', 'user', 'initiateEstablishment', 'currentEstablishment'])
            ->orderBy('created_at', 'desc');

        // Filter to own requests for Fleet Operator role
        if ($user->role && $user->role->name === 'Fleet Operator') {
            $query->where('user_id', $user->id);
        }

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
        $establishments = Establishment::all();

        return view('request-vehicle-2', compact('approvals', 'categories', 'subCategories', 'establishments'));
    }

    public function store(Request $request)
    {
        $this->authorize('Request Create');

        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
            'initiate_establishment_id' => 'required|exists:establishments,e_id',
            'current_establishment_id' => 'nullable|exists:establishments,e_id',
            'vehicle_book' => 'required|file|mimes:pdf,jpg|max:5120', // 5MB max, only pdf and jpg
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

        $userId = auth()->id();
        if (!$userId) {
            abort(401, 'User not authenticated.');
        }

        VehicleRequestApproval::create([
            'serial_number' => $serialNumber,
            'request_type' => $request->request_type,
            'category_id' => $request->cat_id,
            'sub_category_id' => $request->sub_cat_id,
            'quantity' => $request->qty,
            'vehicle_letter' => $vehicleLetterPath,
            'user_id' => $userId,
            'initiated_by' => $userId, // Fix: Add this for NOT NULL field
            'current_user_id' => $userId, // Optional: For consistency
            'initiate_establishment_id' => $request->initiate_establishment_id,
            'current_establishment_id' => $request->current_establishment_id,
            'status' => 'pending',
        ]);

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request submitted successfully! Serial: ' . $serialNumber);
    }

    public function show(VehicleRequestApproval $vehicleRequestApproval)
    {
        $user = Auth::user();
        if ($user->role && $user->role->name === 'Fleet Operator' && $vehicleRequestApproval->user_id != $user->id) {
            abort(403);
        }
        $vehicleRequestApproval->load(['category', 'subCategory', 'approver', 'user', 'initiateEstablishment', 'currentEstablishment']);
        return view('vehicle-request-approvals.show', compact('vehicleRequestApproval'));
    }

    public function edit(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Edit (own)', $vehicleRequestApproval);
        if ($vehicleRequestApproval->user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
            abort(403);
        }
        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();
        $establishments = Establishment::all();
        return view('vehicle-request-approvals.edit', compact('vehicleRequestApproval', 'categories', 'subCategories', 'establishments'));
    }

    public function update(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $oldStatus = $vehicleRequestApproval->status;
        $newStatus = $request->status;
        $user = Auth::id();

        if ($newStatus === 'pending') {
            // This is an edit action
            $this->authorize('Request Edit (own)', $vehicleRequestApproval);
            if ($vehicleRequestApproval->user_id != $user || $oldStatus != 'pending') {
                abort(403);
            }
        } else {
            // This is an approve/reject action
            $perm = $newStatus === 'approved' ? 'Approve Request' : 'Reject Request';
            $this->authorize($perm, $vehicleRequestApproval);
        }

        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
            'vehicle_book' => 'nullable|file|mimes:pdf,jpg|max:5120', // only pdf and jpg
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
            $updateData['approved_by'] = $user;
        }

        $vehicleRequestApproval->update($updateData);

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request updated successfully!');
    }

    public function destroy(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Delete (own, before approval)', $vehicleRequestApproval);
        if ($vehicleRequestApproval->user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
            abort(403);
        }

        // Delete associated file
        if ($vehicleRequestApproval->vehicle_letter) {
            Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
        }

        $vehicleRequestApproval->delete();

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request deleted successfully!');
    }

    public function forward(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Forward Request', $vehicleRequestApproval);
        if ($vehicleRequestApproval->user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $vehicleRequestApproval->update([
            'status' => 'forwarded',
            'forward_reason' => $request->reason,
            'forwarded_at' => now(),
            'forwarded_by' => Auth::id(),
        ]);

        return redirect()->route('vehicle-requests.approvals.index')
            ->with('success', 'Vehicle request forwarded successfully!');
    }
}