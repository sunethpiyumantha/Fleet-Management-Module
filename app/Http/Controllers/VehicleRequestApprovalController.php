<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequestApproval;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\Establishment;
use App\Models\Vehicle;
use App\Models\RequestProcess;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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

        // Filter based on role
        if ($user->role && $user->role->name === 'Fleet Operator') {
            $query->where('current_user_id', $user->id);
        } elseif ($user->role && $user->role->name === 'Establishment Head') {
            // CHANGE: Include 'rejected' status for visibility in default establishment
            $query->whereIn('status', ['forwarded', 'sent', 'rejected'])
                  ->where('current_establishment_id', $user->establishment_id);
        } elseif ($user->role && $user->role->name === 'Request Handler') {
            // CHANGE: Include 'rejected' status for visibility in default establishment (all rejects in est, plus personal forwards/sents)
            $query->where(function ($q) use ($user) {
                $q->where(function ($sub) use ($user) {
                    $sub->whereIn('status', ['forwarded', 'sent'])
                        ->where('current_user_id', $user->id);
                })->orWhere(function ($sub) use ($user) {
                    $sub->where('status', 'rejected')
                        ->where('current_establishment_id', $user->establishment_id);
                });
            });
        } elseif ($user->role && $user->role->name === 'Establishment Admin') {
            // CHANGE: Same as Request Handler for consistency
            $query->where(function ($q) use ($user) {
                $q->where(function ($sub) use ($user) {
                    $sub->whereIn('status', ['forwarded', 'sent'])
                        ->where('current_user_id', $user->id);
                })->orWhere(function ($sub) use ($user) {
                    $sub->where('status', 'rejected')
                        ->where('current_establishment_id', $user->establishment_id);
                });
            });
        }

        // Exclude approved from main list
        $query->where('status', '!=', 'approved');

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

        $approvals = $query->get();
        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();

        return view('request-vehicle-2', compact('approvals', 'categories', 'subCategories'));
    }

    public function approvedIndex(Request $request)
    {
        $user = Auth::user();
        $query = VehicleRequestApproval::with(['category', 'subCategory', 'currentUser', 'initiator', 'initiateEstablishment', 'currentEstablishment'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');

        // Filter based on role for approved requests
        if ($user->role && $user->role->name === 'Fleet Operator') {
            $query->where('current_user_id', $user->id);
        } elseif ($user->role && $user->role->name === 'Establishment Head') {
            $query->where('current_establishment_id', $user->establishment_id);
        } elseif ($user->role && $user->role->name === 'Request Handler') {
            $query->where(function ($q) use ($user) {
                $q->where('current_user_id', $user->id)
                  ->orWhere('current_establishment_id', $user->establishment_id);
            });
        } elseif ($user->role && $user->role->name === 'Establishment Admin') {
            $query->where(function ($q) use ($user) {
                $q->where('current_user_id', $user->id)
                  ->orWhere('current_establishment_id', $user->establishment_id);
            });
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

        $approvals = $query->get();

        return view('vehicle-approved', compact('approvals'));
    }

    public function rejectedIndex(Request $request)
    {
        $user = Auth::user();
        $query = VehicleRequestApproval::with(['category', 'subCategory', 'currentUser', 'initiator', 'initiateEstablishment', 'currentEstablishment'])
            ->where('status', 'rejected')
            ->orderBy('created_at', 'desc');

        // Filter based on role for rejected requests
        if ($user->role && $user->role->name === 'Fleet Operator') {
            $query->where('current_user_id', $user->id);
        } elseif ($user->role && $user->role->name === 'Establishment Head') {
            $query->where('current_establishment_id', $user->establishment_id);
        } elseif ($user->role && $user->role->name === 'Request Handler') {
            $query->where(function ($q) use ($user) {
                $q->where('current_user_id', $user->id)
                ->orWhere('current_establishment_id', $user->establishment_id);
            });
        } elseif ($user->role && $user->role->name === 'Establishment Admin') {
            $query->where(function ($q) use ($user) {
                $q->where('current_user_id', $user->id)
                ->orWhere('current_establishment_id', $user->establishment_id);
            });
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

        $approvals = $query->get();

        return view('vehicle-rejected', compact('approvals'));
    }

    public function forwardedIndex(Request $request)
    {
        $user = Auth::user();
        $query = RequestProcess::with([
            'vehicleRequestApproval' => function ($q) {
                $q->with(['category', 'subCategory', 'currentUser', 'initiator', 'initiateEstablishment', 'currentEstablishment']);
            },
            'fromUser', 'toUser', 'fromEstablishment', 'toEstablishment'
        ])
        ->where('from_user_id', $user->id)  // Outgoing from this user
        ->where('status', 'forwarded')      // Only forwarding actions (exclude approves/rejects)
        ->orderBy('processed_at', 'desc');  // Order by forward timestamp

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('vehicleRequestApproval', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('serial_number', 'like', "%{$search}%")
                        ->orWhere('request_type', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($subQ) use ($search) {
                            $subQ->where('category', 'like', "%{$search}%");
                        })
                        ->orWhereHas('subCategory', function ($subQ) use ($search) {
                            $subQ->where('sub_category', 'like', "%{$search}%");
                        })
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('initiateEstablishment', function ($subQ) use ($search) {
                            $subQ->where('e_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('currentEstablishment', function ($subQ) use ($search) {
                            $subQ->where('e_name', 'like', "%{$search}%");
                        });
                });
            });
        }

        $processes = $query->get();
        $approvals = $processes->pluck('vehicleRequestApproval')->filter()->values();  // Filter out nulls and re-index

        return view('vehicle-forwarded', compact('approvals'));
    }

    public function store(Request $request)
    {
        $this->authorize('Request Create');

        $request->validate([
            'request_type' => 'required|in:replacement,new_approval',
            'cat_id' => 'required|exists:vehicle_categories,id',
            'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',
            'qty' => 'required|integer|min:1',
            'vehicle_book' => 'required|file|mimes:pdf,jpg|max:5120',
        ]);

        do {
            $serialNumber = 'VRA-' . date('Y') . '-' . strtoupper(Str::random(6));
        } while (VehicleRequestApproval::where('serial_number', $serialNumber)->exists());

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
            'current_user_id' => $user->id,
            'initiated_by' => $user->id,
            'initiate_establishment_id' => $userEstablishmentId,
            'current_establishment_id' => $userEstablishmentId,
            'status' => 'pending',
        ]);

        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request submitted successfully! Serial: ' . $serialNumber);
    }

    public function show(VehicleRequestApproval $vehicleRequestApproval)
    {
        // Load necessary relations
        $vehicleRequestApproval->load([
            'category', 
            'subCategory', 
            'currentUser', 
            'initiator', 
            'initiateEstablishment', 
            'currentEstablishment',
            'requestProcesses' => function ($query) {
                $query->with(['fromUser', 'toUser', 'fromEstablishment', 'toEstablishment'])
                    ->orderBy('processed_at', 'asc');
            }
        ]);

        $userRole = Auth::user()->role->name ?? '';
        $processStatuses = RequestProcess::STATUSES;  // Pass static constant to view

        return view('vehicle-request-approvals.show', compact('vehicleRequestApproval', 'userRole', 'processStatuses'));
    }

    public function edit(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Edit (own)', $vehicleRequestApproval);
        if ($vehicleRequestApproval->current_user_id != Auth::id() || !in_array($vehicleRequestApproval->status, ['pending', 'rejected'])) {
            abort(403);
        }

        $categories = VehicleCategory::all();
        $subCategories = VehicleSubCategory::all();

        return view('vehicle-request-approvals.edit', compact('vehicleRequestApproval', 'categories', 'subCategories'));
    }

    public function update(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Edit (own)', $vehicleRequestApproval);

        $user = Auth::id();
        $oldStatus = $vehicleRequestApproval->status;

        if (in_array($oldStatus, ['pending', 'rejected']) && $vehicleRequestApproval->current_user_id == $user) {
            $request->validate([
                'request_type' => 'required|in:replacement,new_approval',
                'cat_id' => 'required|exists:vehicle_categories,id',  // Changed to match form
                'sub_cat_id' => 'required|exists:vehicle_sub_categories,id',  // Changed to match form
                'qty' => 'required|integer|min:1',  // Changed to match form
                'vehicle_book' => 'nullable|file|mimes:pdf,jpg|max:5120',  // Note: Form uses 'vehicle_book', but validation was 'vehicle_letter'—fixed below
            ]);

            // Map form names to DB column names (consistent with store())
            $updateData = [
                'request_type' => $request->request_type,
                'category_id' => $request->cat_id,
                'sub_category_id' => $request->sub_cat_id,
                'quantity' => $request->qty,
            ];

            // Handle file upload (note: form uses 'vehicle_book', but DB uses 'vehicle_letter'—update request key here)
            if ($request->hasFile('vehicle_book')) {
                if ($vehicleRequestApproval->vehicle_letter) {
                    Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
                }
                $file = $request->file('vehicle_book');
                $filename = time() . '_' . $vehicleRequestApproval->serial_number . '.' . $file->getClientOriginalExtension();
                $updateData['vehicle_letter'] = $file->storeAs('vehicle_letters', $filename, 'public');
            }

            $vehicleRequestApproval->update($updateData);

            return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
                ->with('success', 'Vehicle request updated successfully!');
        }

        abort(403, 'Unauthorized to update this request.');
    }

    public function rejectForm(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Reject Request', $vehicleRequestApproval);
        
        $user = Auth::user();
        $userRole = $user->role->name ?? '';
        
        // CHANGE: Allow rejection on 'sent' status for inter-establishment rejects
        if (!in_array($userRole, ['Request Handler', 'Establishment Head', 'Establishment Admin']) || 
            !in_array($vehicleRequestApproval->status, ['forwarded', 'sent'])) {
            abort(403, 'Unauthorized to reject this request.');
        }

        return view('reject', compact('vehicleRequestApproval'));
    }

    public function reject(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Reject Request', $vehicleRequestApproval);

        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $fleetOperator = User::find($vehicleRequestApproval->initiated_by);
        if (!$fleetOperator) {
            return back()->withErrors(['error' => 'Original request creator not found.']);
        }

        try {
            RequestProcess::create([
                'req_id' => $vehicleRequestApproval->serial_number,
                'from_user_id' => Auth::id(),
                'from_establishment_id' => Auth::user()->establishment_id,
                'to_user_id' => $fleetOperator->id,
                'to_establishment_id' => $fleetOperator->establishment_id,
                'remark' => $request->notes,
                'status' => 'rejected',
                'processed_at' => now(),
            ]);

            $vehicleRequestApproval->update([
                'status' => 'rejected',
                'notes' => $request->notes,
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'current_user_id' => $fleetOperator->id,
                'current_establishment_id' => $fleetOperator->establishment_id,
            ]);

            // Notify initiator
            $initiator = $vehicleRequestApproval->initiator;
            if ($initiator && $initiator->id !== Auth::id()) {
                Notification::create([
                    'user_id' => $initiator->id,
                    'title' => 'Request Rejected',
                    'message' => "Your vehicle request {$vehicleRequestApproval->serial_number} has been rejected. Reason: {$request->notes}.",
                    'type' => 'rejected',
                    'request_id' => $vehicleRequestApproval->id,
                    'is_read' => false,
                ]);
            }

            // Optionally notify current user if rejecting own or has permission
            if (Auth::id() !== $initiator->id && Auth::user()->hasPermission('Request List (all / own)')) {
                Notification::create([
                    'user_id' => Auth::id(),
                    'title' => 'Request You Forwarded Rejected',
                    'message' => "Vehicle request {$vehicleRequestApproval->serial_number} has been rejected.",
                    'type' => 'rejected',
                    'request_id' => $vehicleRequestApproval->id,
                    'is_read' => false,
                ]);
            }

            return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
                ->with('success', 'Vehicle request rejected successfully and returned to Fleet Operator!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject request: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Delete (own, before approval)', $vehicleRequestApproval);
        if ($vehicleRequestApproval->current_user_id != Auth::id() || $vehicleRequestApproval->status != 'pending') {
            abort(403);
        }

        if ($vehicleRequestApproval->vehicle_letter) {
            Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
        }

        $vehicleRequestApproval->delete();

        return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
            ->with('success', 'Vehicle request deleted successfully!');
    }

    public function forward(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Forward Request', $vehicleRequestApproval);

        $user = Auth::user();
        $isHead = $user->role && $user->role->name === 'Establishment Head';

        if ($isHead) {
            if (!in_array($vehicleRequestApproval->status, ['forwarded', 'sent']) || $vehicleRequestApproval->current_establishment_id != $user->establishment_id) {
                abort(403, 'Unauthorized to forward this request.');
            }
        } else {
            if ($vehicleRequestApproval->current_user_id != $user->id || !in_array($vehicleRequestApproval->status, ['pending', 'forwarded', 'rejected', 'sent'])) {
                abort(403, 'Unauthorized to forward this request.');
            }
        }

        $request->validate([
            'forward_to' => 'required|exists:users,id',
            'remark' => 'required|string|max:1000',
        ]);

        $forwardToUser = User::findOrFail($request->forward_to);

        try {
            RequestProcess::create([
                'req_id' => $vehicleRequestApproval->serial_number,
                'from_user_id' => Auth::id(),
                'from_establishment_id' => Auth::user()->establishment_id,
                'to_user_id' => $forwardToUser->id,
                'to_establishment_id' => $forwardToUser->establishment_id,
                'remark' => $request->remark,
                'status' => 'forwarded',
                'processed_at' => now(),
            ]);

            $newStatus = $isHead ? 'sent' : 'forwarded';

            $vehicleRequestApproval->update([
                'status' => $newStatus,
                'forward_reason' => $request->remark,
                'forwarded_at' => now(),
                'forwarded_by' => Auth::id(),
                'current_user_id' => $forwardToUser->id,
                'current_establishment_id' => $forwardToUser->establishment_id,
            ]);

            // Notify forwarded-to user (only if they have relevant permissions like 'Approve Request' or 'Request List (all / own)')
            if ($forwardToUser->hasAnyPermission(['Approve Request', 'Request List (all / own)'])) {
                Notification::create([
                    'user_id' => $forwardToUser->id,
                    'title' => 'New Request Forwarded to You',
                    'message' => "Vehicle request {$vehicleRequestApproval->serial_number} has been forwarded to you by " . Auth::user()->name . ". Remark: {$request->remark}.",
                    'type' => 'forwarded',
                    'request_id' => $vehicleRequestApproval->id,
                    'is_read' => false,
                ]);
            }

            // Optionally notify initiator if forwarded back or across
            $initiator = $vehicleRequestApproval->initiator;
            if ($initiator && ($isHead || true)) { // Adjust condition based on logic (e.g., if forwarding back)
                Notification::create([
                    'user_id' => $initiator->id,
                    'title' => 'Request Forwarded',
                    'message' => "Your vehicle request {$vehicleRequestApproval->serial_number} has been forwarded to {$forwardToUser->name}.",
                    'type' => 'forwarded',
                    'request_id' => $vehicleRequestApproval->id,
                    'is_read' => false,
                ]);
            }

            return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
                ->with('success', 'Request forwarded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to forward request: ' . $e->getMessage())->withInput();
        }
    }

    public function showForwardForm($req_id)
    {
        $user = Auth::user();
        
        if (!$user->role || $user->role->name !== 'Establishment Head') {
            abort(403, 'Unauthorized');
        }

        $vehicleRequest = VehicleRequestApproval::where('serial_number', $req_id)
            ->where('status', 'forwarded')
            ->where('current_establishment_id', $user->establishment_id)
            ->firstOrFail();

        $establishments = Establishment::where('e_id', '!=', $user->establishment_id)->get();

        return view('forward', compact('req_id', 'establishments'));
    }
    
    public function genericForward(Request $request)
    {
        $user = Auth::user();
        $isHead = $user->role && $user->role->name === 'Establishment Head';
        $isDSTHead = $isHead && $user->establishment_id == 1094;

        if ($isHead) {
            if ($isDSTHead) {
                $validator = Validator::make($request->all(), [
                    'req_id' => 'required|string',
                    'action' => 'required|in:approve,reject',
                    'vehicle_type' => 'required_if:action,approve|in:army,hired',
                    'army_vehicle_id' => 'required_if:vehicle_type,army|exists:vehicles,id',
                    'remark' => 'required|string|max:1000',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'req_id' => 'required|string',
                    'forward_to_establishment' => 'required|exists:establishments,e_id',
                    'forward_to_user' => 'required|exists:users,id',
                    'remark' => 'required|string|max:1000',
                ]);

                if (!$validator->fails()) {
                    $selectedUser = User::find($request->forward_to_user);
                    if (!$selectedUser || $selectedUser->establishment_id != $request->forward_to_establishment) {
                        return redirect()->back()->with('error', 'Selected user does not belong to the chosen establishment.')->withInput();
                    }
                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'req_id' => 'required|string',
                'forward_to' => 'required|exists:users,id',
                'remark' => 'required|string|max:1000',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $req_id = $request->req_id;

        try {
            $vehicleRequestApproval = VehicleRequestApproval::where('serial_number', $req_id)->firstOrFail();
            
            if ($isHead) {
                if ($isDSTHead) {
                    $action = $request->action;
                    $remark = $request->remark;
                    $newStatus = ($action === 'approve') ? 'approved' : 'rejected';

                    $forwardToEstablishmentId = $vehicleRequestApproval->initiate_establishment_id;

                    $fleetOperator = User::where('establishment_id', $forwardToEstablishmentId)
                        ->whereHas('role', function ($query) {
                            $query->where('name', 'Fleet Operator');
                        })
                        ->first();

                    if (!$fleetOperator) {
                        return back()->with('error', 'No Fleet Operator found in the initiating establishment.')->withInput();
                    }

                    $forwardToUser = $fleetOperator;

                    RequestProcess::create([
                        'req_id' => $req_id,
                        'from_user_id' => Auth::id(),
                        'from_establishment_id' => Auth::user()->establishment_id,
                        'to_user_id' => $forwardToUser->id,
                        'to_establishment_id' => $forwardToEstablishmentId,
                        'remark' => $remark,
                        'status' => $newStatus,
                        'processed_at' => now(),
                    ]);

                    $updateData = [
                        'status' => $newStatus,
                        'forward_reason' => $remark,
                        'forwarded_at' => now(),
                        'forwarded_by' => Auth::id(),
                        'current_user_id' => $forwardToUser->id,
                        'current_establishment_id' => $forwardToEstablishmentId,
                    ];

                    if ($action === 'approve') {
                        $updateData['vehicle_type'] = $request->vehicle_type;
                        
                        if ($request->vehicle_type === 'army') {
                            if (!$request->army_vehicle_id) {
                                return back()->withErrors(['army_vehicle_id' => 'Army vehicle selection is required.']);
                            }
                            $updateData['assigned_vehicle_id'] = $request->army_vehicle_id;
                        }
                    }

                    $vehicleRequestApproval->update($updateData);

                    // Notify initiator for approve
                    if ($action === 'approve') {
                        $initiator = $vehicleRequestApproval->initiator;
                        if ($initiator && $initiator->id !== Auth::id()) {
                            Notification::create([
                                'user_id' => $initiator->id,
                                'title' => 'Request Approved',
                                'message' => "Your vehicle request {$vehicleRequestApproval->serial_number} has been approved.",
                                'type' => 'approved',
                                'request_id' => $vehicleRequestApproval->id,
                                'is_read' => false,
                            ]);
                        }

                        // Optionally notify current user if different and has permission
                        $currentUser = $vehicleRequestApproval->currentUser;
                        if ($currentUser && $currentUser->id !== $initiator->id && $currentUser->hasPermission('Request List (all / own)')) {
                            Notification::create([
                                'user_id' => $currentUser->id,
                                'title' => 'Request You Handled Approved',
                                'message' => "Vehicle request {$vehicleRequestApproval->serial_number} (initiated by {$initiator->name}) has been approved.",
                                'type' => 'approved',
                                'request_id' => $vehicleRequestApproval->id,
                                'is_read' => false,
                            ]);
                        }
                    } elseif ($action === 'reject') {
                        // Notify initiator for reject
                        $initiator = $vehicleRequestApproval->initiator;
                        if ($initiator && $initiator->id !== Auth::id()) {
                            Notification::create([
                                'user_id' => $initiator->id,
                                'title' => 'Request Rejected',
                                'message' => "Your vehicle request {$vehicleRequestApproval->serial_number} has been rejected. Reason: {$remark}.",
                                'type' => 'rejected',
                                'request_id' => $vehicleRequestApproval->id,
                                'is_read' => false,
                            ]);
                        }

                        // Optionally notify current user if has permission
                        if (Auth::id() !== $initiator->id && Auth::user()->hasPermission('Request List (all / own)')) {
                            Notification::create([
                                'user_id' => Auth::id(),
                                'title' => 'Request You Forwarded Rejected',
                                'message' => "Vehicle request {$vehicleRequestApproval->serial_number} has been rejected.",
                                'type' => 'rejected',
                                'request_id' => $vehicleRequestApproval->id,
                                'is_read' => false,
                            ]);
                        }
                    }

                    return redirect()->route('vehicle-forwarded.index')
                        ->with('success', "Request {$newStatus} and forwarded to the initiating establishment's Fleet Operator!");
                } else {
                    if (!in_array($vehicleRequestApproval->status, ['forwarded', 'sent']) || $vehicleRequestApproval->current_establishment_id != $user->establishment_id) {
                        abort(403, 'Unauthorized to forward this request.');
                    }

                    $targetEstablishmentId = $request->forward_to_establishment;
                    $forwardToUser = User::findOrFail($request->forward_to_user);
                    $forwardToEstablishmentId = $targetEstablishmentId;
                }
            } else {
                if ($vehicleRequestApproval->current_user_id != $user->id || !in_array($vehicleRequestApproval->status, ['pending', 'forwarded', 'rejected', 'sent'])) {
                    abort(403, 'Unauthorized to forward this request.');
                }

                $forwardToUser = User::findOrFail($request->forward_to);
                $forwardToEstablishmentId = $forwardToUser->establishment_id;
            }

            RequestProcess::create([
                'req_id' => $req_id,
                'from_user_id' => Auth::id(),
                'from_establishment_id' => Auth::user()->establishment_id,
                'to_user_id' => $forwardToUser->id,
                'to_establishment_id' => $forwardToEstablishmentId,
                'remark' => $request->remark,
                'status' => 'forwarded',
                'processed_at' => now(),
            ]);

            $newStatus = $isHead ? 'sent' : 'forwarded';

            $vehicleRequestApproval->update([
                'status' => $newStatus,
                'forward_reason' => $request->remark,
                'forwarded_at' => now(),
                'forwarded_by' => Auth::id(),
                'current_user_id' => $forwardToUser->id,
                'current_establishment_id' => $forwardToEstablishmentId,
            ]);

            // Notify forwarded-to user (only if they have relevant permissions like 'Approve Request' or 'Request List (all / own)')
            if ($forwardToUser->hasAnyPermission(['Approve Request', 'Request List (all / own)'])) {
                Notification::create([
                    'user_id' => $forwardToUser->id,
                    'title' => 'New Request Forwarded to You',
                    'message' => "Vehicle request {$vehicleRequestApproval->serial_number} has been forwarded to you by " . Auth::user()->name . ". Remark: {$request->remark}.",
                    'type' => 'forwarded',
                    'request_id' => $vehicleRequestApproval->id,
                    'is_read' => false,
                ]);
            }

            // Optionally notify initiator if forwarded back or across
            $initiator = $vehicleRequestApproval->initiator;
            if ($initiator && ($isHead || true)) { // Adjust condition based on your forward logic (e.g., if back-to-initiate)
                Notification::create([
                    'user_id' => $initiator->id,
                    'title' => 'Request Forwarded',
                    'message' => "Your vehicle request {$vehicleRequestApproval->serial_number} has been forwarded to {$forwardToUser->name}.",
                    'type' => 'forwarded',
                    'request_id' => $vehicleRequestApproval->id,
                    'is_read' => false,
                ]);
            }

            return redirect()->route('vehicle-forwarded.index')
                ->with('success', 'Request forwarded successfully to ' . $forwardToUser->name . ' at target establishment!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to forward request: ' . $e->getMessage())->withInput();
        }
    }

    public function showForwardView($req_id)
    {
        if (!$req_id) {
            return redirect()->back()->with('error', 'Request ID is required to forward.');
        }

        $currentUser = Auth::user();
        
        if ($currentUser->role && $currentUser->role->name === 'Establishment Head') {
            $establishments = Establishment::where('e_id', '!=', $currentUser->establishment_id)->get();
            return view('forward', compact('establishments', 'req_id'));
        } else {
            $users = User::with('role')
                        ->where('establishment_id', $currentUser->establishment_id)
                        ->where('id', '!=', $currentUser->id)
                        ->orderBy('name')
                        ->get();
            return view('forward', compact('users', 'req_id'));
        }
    }

    /**
     * API endpoint to fetch vehicle army numbers for dropdown.
     */
    public function getVehicleArmyNos()
    {
        try {
            $vehicles = Vehicle::whereNotNull('vehicle_army_no')
                ->orderBy('vehicle_army_no')
                ->get()
                ->unique('vehicle_army_no')
                ->values()
                ->map(function ($vehicle) {
                    return [
                        'id' => $vehicle->id,
                        'text' => $vehicle->vehicle_army_no
                    ];
                });

            Log::info('Fetched ' . $vehicles->count() . ' unique vehicle army numbers.');

            return response()->json($vehicles);

        } catch (\Exception $e) {
            Log::error('getVehicleArmyNos error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load army numbers: ' . $e->getMessage()], 500);
        }
    }
}