<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequestApproval;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
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
        $query = VehicleRequestApproval::with(['category', 'subCategory', 'currentUser', 'initiator', 'initiateEstablishment', 'currentEstablishment'])
            ->orderBy('created_at', 'desc');

        // Filter to own requests for Fleet Operator role (using current_user_id)
        if ($user->role && $user->role->name === 'Fleet Operator') {
            $query->where('current_user_id', $user->id);
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
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('initiateEstablishment', function ($sub) use ($search) {
                      $sub->where('e_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('currentEstablishment', function ($sub) use ($search) {
                      $sub->where('e_name', 'like', "%{$search}%");
                  });
            });
        }

        $approvals = $query->paginate(10);
        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();

        return view('request-vehicle-2', compact('approvals', 'categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $this->authorize('Request Create');

        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
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

        $user = auth()->user();
        if (!$user) {
            abort(401, 'User not authenticated.');
        }

        $userEstablishmentId = $user->establishment_id;

        VehicleRequestApproval::create([
            'serial_number' => $serialNumber,
            'request_type' => $request->request_type,
            'category_id' => $request->cat_id,
            'sub_category_id' => $request->sub_cat_id,
            'quantity' => $request->qty,
            'vehicle_letter' => $vehicleLetterPath,
            'current_user_id' => $user->id, // Set current_user_id
            'initiated_by' => $user->id, // Set initiated_by
            'initiate_establishment_id' => $userEstablishmentId, // Auto-set initiate
            'current_establishment_id' => $userEstablishmentId, // Auto-set current (initially same)
            'status' => 'pending',
        ]);

        // FIXED: Redirect to page 1 (clears search/filter and shows new record at top)
        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request submitted successfully! Serial: ' . $serialNumber);
    }

    public function edit(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Edit (own)', $vehicleRequestApproval);
        if ($vehicleRequestApproval->current_user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
            abort(403);
        }

        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();

        return view('vehicle-request-edit', compact('vehicleRequestApproval', 'categories', 'subCategories'));
    }

    public function update(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $user = Auth::id();
        $oldStatus = $vehicleRequestApproval->status;

        // Authorization logic (updated to use current_user_id)
        if ($oldStatus === 'pending' && $vehicleRequestApproval->current_user_id == $user) {
            // This is an edit action by owner
        } else {
            // This is an approve/reject action
            $newStatus = $request->status ?? $oldStatus;
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

        // Server-side protection: Prevent Fleet Operators from changing status
        $authUser = Auth::user();
        if ($authUser->role && $authUser->role->name === 'Fleet Operator' && $request->status !== $vehicleRequestApproval->status) {
            return back()->withErrors(['status' => 'Status cannot be changed by Fleet Operators.']);
        }

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

        // FIXED: Redirect to page 1 (clears search/filter and refreshes list)
        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request updated successfully!');
    }

    public function reject(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Reject Request', $vehicleRequestApproval);

        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        // Handle file if provided (optional for rejection)
        $vehicleLetterPath = $vehicleRequestApproval->vehicle_letter;
        if ($request->hasFile('vehicle_book')) {
            if ($vehicleLetterPath) {
                Storage::disk('public')->delete($vehicleLetterPath);
            }
            $file = $request->file('vehicle_book');
            $filename = time() . '_' . $vehicleRequestApproval->serial_number . '.' . $file->getClientOriginalExtension();
            $vehicleLetterPath = $file->storeAs('vehicle_letters', $filename, 'public');
        }

        $vehicleRequestApproval->update([
            'status' => 'rejected',
            'notes' => $request->notes ?? 'Rejected via UI',
            'vehicle_letter' => $vehicleLetterPath,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        // FIXED: Redirect to page 1 (clears search/filter and refreshes list)
        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request rejected successfully!');
    }

    public function destroy(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Delete (own, before approval)', $vehicleRequestApproval);
        if ($vehicleRequestApproval->current_user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
            abort(403);
        }

        // Delete associated file
        if ($vehicleRequestApproval->vehicle_letter) {
            Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
        }

        $vehicleRequestApproval->delete();

        // FIXED: Redirect to page 1 (clears search/filter and refreshes list)
        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request deleted successfully!');
    }

    public function forward(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Forward Request', $vehicleRequestApproval);
        if ($vehicleRequestApproval->current_user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
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
            // Optionally update current_user_id or current_establishment_id here if forwarding changes them
        ]);

        // FIXED: Redirect to page 1 (clears search/filter and refreshes list)
        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request forwarded successfully!');
    }
}