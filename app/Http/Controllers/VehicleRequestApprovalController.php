<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequestApproval;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\Establishment;
use App\Models\Vehicle;
use App\Models\RequestProcess;
use App\Models\User;
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
        $query = VehicleRequestApproval::with(['category', 'subCategory', 'currentUser', 'initiator', 'initiateEstablishment', 'currentEstablishment'])
            ->whereIn('status', ['forwarded', 'sent'])
            ->where('forwarded_by', $user->id)
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
        $vehicleRequestApproval->load([
            'category', 
            'subCategory', 
            'currentUser', 
            'initiator', 
            'initiateEstablishment', 
            'currentEstablishment'
        ]);

        $userRole = Auth::user()->role->name ?? '';

        return view('vehicle-request-approvals.show', compact('vehicleRequestApproval', 'userRole'));
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
                'category_id' => 'required|exists:vehicle_categories,id',
                'sub_category_id' => 'required|exists:vehicle_sub_categories,id',
                'quantity' => 'required|integer|min:1',
                'vehicle_letter' => 'nullable|file|mimes:pdf,jpg|max:5120',
            ]);

            $updateData = $request->only(['request_type', 'category_id', 'sub_category_id', 'quantity']);

            if ($request->hasFile('vehicle_letter')) {
                if ($vehicleRequestApproval->vehicle_letter) {
                    Storage::disk('public')->delete($vehicleRequestApproval->vehicle_letter);
                }
                $file = $request->file('vehicle_letter');
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
        $this->authorize('Request Reject', $vehicleRequestApproval);

        return view('vehicle-request-approvals.reject-form', compact('vehicleRequestApproval'));
    }

    public function reject(Request $request, VehicleRequestApproval $vehicleRequestApproval)
    {
        $this->authorize('Request Reject', $vehicleRequestApproval);

        $request->validate([
            'remark' => 'required|string|max:1000',
        ]);

        try {
            RequestProcess::create([
                'req_id' => $vehicleRequestApproval->serial_number,
                'from_user_id' => Auth::id(),
                'from_establishment_id' => Auth::user()->establishment_id,
                'to_user_id' => $vehicleRequestApproval->current_user_id,
                'to_establishment_id' => $vehicleRequestApproval->current_establishment_id,
                'remark' => $request->remark,
                'status' => 'rejected',
                'processed_at' => now(),
            ]);

            $vehicleRequestApproval->update([
                'status' => 'rejected',
                'forward_reason' => $request->remark,
                'forwarded_at' => now(),
                'forwarded_by' => Auth::id(),
            ]);

            return redirect()->route('vehicle-requests.approvals.index', ['page' => 1])
                ->with('success', 'Request rejected successfully!');
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