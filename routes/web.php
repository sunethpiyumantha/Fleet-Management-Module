<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleEngineCapacityController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\VehicleColorController;
use App\Http\Controllers\VehicleStatusController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\VehicleTireSizeController;
use App\Http\Controllers\VehicleMakeController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleAllocationTypeController;
use App\Http\Controllers\VehicleSubCategoryController;
use App\Http\Controllers\VehicleRequestController;
use App\Http\Controllers\VehicleDeclarationFormController;
use App\Http\Controllers\VehicleTechnicalDescriptionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VehicleRequestApprovalController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DropdownController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Public routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Welcome route (protected)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome')->middleware('auth');

Route::get('/index.html', function () {
    return view('welcome');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Vehicle Request Approvals Routes
    Route::get('/request-vehicle-2', [VehicleRequestApprovalController::class, 'index'])
        ->name('vehicle-requests.approvals.index');
    Route::post('/request-vehicle-2', [VehicleRequestApprovalController::class, 'store'])
        ->middleware('can:Request Create')
        ->name('vehicle-requests.approvals.store');
    Route::get('/request-vehicle-2/{vehicleRequestApproval}/edit', [VehicleRequestApprovalController::class, 'edit'])
        ->name('vehicle-requests.approvals.edit');
    Route::put('/request-vehicle-2/{vehicleRequestApproval}', [VehicleRequestApprovalController::class, 'update'])
        ->name('vehicle-requests.approvals.update');
    Route::delete('/request-vehicle-2/{vehicleRequestApproval}', [VehicleRequestApprovalController::class, 'destroy'])
        ->name('vehicle-requests.approvals.destroy');
    Route::get('/request-vehicle-2/{vehicleRequestApproval}', [VehicleRequestApprovalController::class, 'show'])
        ->name('vehicle-requests.approvals.show');
    Route::post('/request-vehicle-2/{vehicleRequestApproval}/forward', [VehicleRequestApprovalController::class, 'forward'])
        ->middleware('can:Forward Request')
        ->name('vehicle-requests.approvals.forward');

    // Reject routes
    Route::get('/request-vehicle-2/{vehicleRequestApproval}/reject-form', [VehicleRequestApprovalController::class, 'rejectForm'])
        ->name('vehicle-requests.approvals.reject-form');
    Route::post('/request-vehicle-2/{vehicleRequestApproval}/reject', [VehicleRequestApprovalController::class, 'reject'])
        ->name('vehicle-requests.approvals.reject');

    // Approved vehicles route
    Route::get('/vehicle-approved', [VehicleRequestApprovalController::class, 'approvedIndex'])
        ->name('vehicle-approved.index');

    // Rejected vehicles route
    Route::get('/vehicle-rejected', [VehicleRequestApprovalController::class, 'rejectedIndex'])
    ->name('vehicle-rejected.index');

    // Forwarded vehicles route
    Route::get('/vehicle-forwarded', [VehicleRequestApprovalController::class, 'forwardedIndex'])
    ->name('vehicle-forwarded.index');

    // Vehicle Types
    Route::get('/vehicle-types', [VehicleTypeController::class, 'index'])->name('vehicle-types.index');
    Route::post('/vehicle-types', [VehicleTypeController::class, 'store'])->name('vehicle-types.store');
    Route::post('/vehicle-types/{vehicleType}', [VehicleTypeController::class, 'update'])->name('vehicle-types.update');
    Route::delete('/vehicle-types/{vehicleType}', [VehicleTypeController::class, 'destroy'])->name('vehicle-types.destroy');

    // Vehicle Engine Capacity
    Route::get('/vehicle-engine-capacity', [VehicleEngineCapacityController::class, 'index'])->name('vehicle-engine-capacity.index');
    Route::post('/vehicle-engine-capacity', [VehicleEngineCapacityController::class, 'store'])->name('vehicle-engine-capacity.store');
    Route::post('/vehicle-engine-capacity/update/{id}', [VehicleEngineCapacityController::class, 'update']);
    Route::delete('/vehicle-engine-capacity/delete/{id}', [VehicleEngineCapacityController::class, 'destroy'])->name('vehicle-engine-capacity.destroy');

    // Fuel Types
    Route::get('/fuel-types', [FuelTypeController::class, 'index'])->name('fuel-types.index');
    Route::post('/fuel-types', [FuelTypeController::class, 'store'])->name('fuel-types.store');
    Route::post('/fuel-types/update/{id}', [FuelTypeController::class, 'update'])->name('fuel-types.update');
    Route::delete('/fuel-types/{id}', [FuelTypeController::class, 'destroy'])->name('fuel-types.destroy');

    // Vehicle Color
    Route::get('/vehicle-color', [VehicleColorController::class, 'index'])->name('vehicle-color.index');
    Route::post('/vehicle-color', [VehicleColorController::class, 'store'])->name('vehicle-color.store');
    Route::post('/vehicle-color/update/{id}', [VehicleColorController::class, 'update'])->name('vehicle-color.update');
    Route::delete('/vehicle-color/{id}', [VehicleColorController::class, 'destroy'])->name('vehicle-color.destroy');

    // Vehicle Status
    Route::get('/vehicle-status', [VehicleStatusController::class, 'index'])->name('vehicle-status.index');
    Route::post('/vehicle-status', [VehicleStatusController::class, 'store'])->name('vehicle-status.store');
    Route::post('/vehicle-status/update/{id}', [VehicleStatusController::class, 'update'])->name('vehicle-status.update');
    Route::delete('/vehicle-status/{id}', [VehicleStatusController::class, 'destroy'])->name('vehicle-status.destroy');

    // Workshops
    Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
    Route::post('/workshops', [WorkshopController::class, 'store'])->name('workshops.store');
    Route::post('/workshops/update/{id}', [WorkshopController::class, 'update'])->name('workshops.update');
    Route::delete('/workshops/{id}', [WorkshopController::class, 'destroy'])->name('workshops.destroy');

    // Establishments
    Route::get('/establishments', [EstablishmentController::class, 'index'])->name('establishments.index');
    Route::post('/establishments', [EstablishmentController::class, 'store'])->name('establishments.store');
    Route::post('/establishments/{establishment}', [EstablishmentController::class, 'update'])->name('establishments.update');
    Route::delete('/establishments/{id}', [EstablishmentController::class, 'destroy'])->name('establishments.destroy');

    // Vehicle Tire Sizes
    Route::get('/vehicle-tire-sizes', [VehicleTireSizeController::class, 'index'])->name('vehicle-tire-sizes.index');
    Route::post('/vehicle-tire-sizes', [VehicleTireSizeController::class, 'store'])->name('vehicle-tire-sizes.store');
    Route::post('/vehicle-tire-sizes/{id}', [VehicleTireSizeController::class, 'update'])->name('vehicle-tire-sizes.update');
    Route::delete('/vehicle-tire-sizes/{id}', [VehicleTireSizeController::class, 'destroy'])->name('vehicle-tire-sizes.destroy');

    // Vehicle Make
    Route::get('/vehicle-make', [VehicleMakeController::class, 'index'])->name('vehicle-make.index');
    Route::post('/vehicle-make', [VehicleMakeController::class, 'store'])->name('vehicle-make.store');
    Route::post('/vehicle-make/{id}', [VehicleMakeController::class, 'update'])->name('vehicle-make.update');
    Route::delete('/vehicle-make/{id}', [VehicleMakeController::class, 'destroy'])->name('vehicle-make.destroy');

    // Vehicle Models
    Route::get('/vehicle-models', [VehicleModelController::class, 'index'])->name('vehicle-models.index');
    Route::post('/vehicle-models', [VehicleModelController::class, 'store'])->name('vehicle-models.store');
    Route::post('/vehicle-models/{vehicleModel}', [VehicleModelController::class, 'update'])->name('vehicle-models.update');
    Route::delete('/vehicle-models/{id}', [VehicleModelController::class, 'destroy'])->name('vehicle-models.destroy');

    // Vehicle Category
    Route::get('/vehicle-category', [VehicleCategoryController::class, 'index'])->name('vehicle-category.index');
    Route::post('/vehicle-category', [VehicleCategoryController::class, 'store'])->name('vehicle-category.store');
    Route::post('/vehicle-category/{id}', [VehicleCategoryController::class, 'update'])->name('vehicle-category.update');
    Route::delete('/vehicle-category/{id}', [VehicleCategoryController::class, 'destroy'])->name('vehicle-category.destroy');

    // Vehicle Allocation Type
    Route::get('/vehicle-allocation-type', [VehicleAllocationTypeController::class, 'index'])->name('vehicle-allocation-type.index');
    Route::post('/vehicle-allocation-type', [VehicleAllocationTypeController::class, 'store'])->name('vehicle-allocation-type.store');
    Route::post('/vehicle-allocation-type/{id}', [VehicleAllocationTypeController::class, 'update'])->name('vehicle-allocation-type.update');
    Route::delete('/vehicle-allocation-type/{id}', [VehicleAllocationTypeController::class, 'destroy'])->name('vehicle-allocation-type.destroy');

    // Vehicle Sub Categories (resource)
    Route::resource('vehicle-sub-categories', VehicleSubCategoryController::class)->only(['index', 'store', 'update', 'destroy'])->names('vehicle-sub-category');

    // Vehicle Request
    Route::prefix('vehicle-request')->name('vehicle.request.')->group(function () {
        Route::get('/', [VehicleRequestController::class, 'index'])->name('index');
        Route::get('/create', [VehicleRequestController::class, 'create'])->name('create');
        Route::post('/', [VehicleRequestController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [VehicleRequestController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VehicleRequestController::class, 'update'])->name('update');
        Route::delete('/{id}', [VehicleRequestController::class, 'destroy'])->name('destroy');
        Route::get('/all', [VehicleRequestController::class, 'allRequests'])->name('all');
    });

    // Vehicle Declaration
    Route::prefix('vehicle-declaration')->name('vehicle.declaration.')->group(function () {
        Route::get('/', [VehicleDeclarationFormController::class, 'create'])->name('create');
        Route::post('/', [VehicleDeclarationFormController::class, 'store'])->name('store');
        Route::get('/edit/{serial_number}', [VehicleDeclarationFormController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VehicleDeclarationFormController::class, 'update'])->name('update');
    });

    // Vehicle Inspection
    Route::prefix('vehicle-inspection')->name('vehicle.inspection.')->group(function () {
        Route::get('/', [VehicleRequestController::class, 'vehicleInspection'])->name('index');
        Route::get('/create/{serial_number}/{request_type}', [VehicleRequestController::class, 'createInspection'])->name('create');
        Route::post('/store', [VehicleRequestController::class, 'storeInspection'])->name('store');
    });

    // AJAX for Subcategories
    Route::get('/get-sub-categories/{catId}', [VehicleRequestController::class, 'getSubCategories'])->name('vehicle.request.subcategories');

    // Vehicle Technical Description
    Route::get('/vehicle-technical-description/{serial_number}/{request_type}', [VehicleTechnicalDescriptionController::class, 'create'])->name('vehicle.technical.create');
    Route::post('/vehicle-technical-description/{serial_number}', [VehicleTechnicalDescriptionController::class, 'store'])->name('vehicle.technical.store');

    // Other views/routes
    Route::get('/vehicle-registration', function () { return view('vehicle-technical-description'); })->name('vehicle.registration');
    Route::get('/vehicle-inspection-request', function () { return view('vehicle-inspection'); })->name('vehicle.inspection.request');
    Route::get('/vehicle-inspection-form2', [VehicleRequestController::class, 'vehicleInspectionForm2'])->name('vehicle.inspection.form2');
    Route::get('/vehicle/certificate/create', [VehicleRequestController::class, 'certificateCreate'])->name('vehicle.certificate.create');
    Route::post('/vehicle/certificate/store', [VehicleRequestController::class, 'certificateStore'])->name('vehicle.certificate.store');

    Route::get('/all-drivers', function () { return view('all-drivers'); })->name('all-drivers');
    Route::get('/driver-amendment', function () { return view('driver-amendment'); })->name('driver-amendment');
    Route::get('/vehicles-basic-info', function () { return view('vehicles-basic-info'); })->name('vehicles.basic-info');

    // Roles
    Route::get('/user-roles', [RoleController::class, 'index'])->middleware('can:Role List')->name('roles.index');
    Route::post('/user-roles', [RoleController::class, 'store'])->middleware('can:Role Create')->name('roles.store');
    Route::put('/user-roles/{id}', [RoleController::class, 'update'])->middleware('can:Role Edit')->name('roles.update');
    Route::delete('/user-roles/{id}', [RoleController::class, 'destroy'])->middleware('can:Role Delete')->name('roles.destroy');
    Route::patch('/user-roles/{id}/restore', [RoleController::class, 'restore'])->middleware('can:Role Delete')->name('roles.restore');
    Route::patch('/user-roles/{id}/permissions', [RoleController::class, 'updatePermissions'])->middleware('can:Role Edit')->name('roles.permissions.update');
    Route::get('/user-roles/{id}/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions.get');
    Route::get('/roles/{id}/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions.get');
    Route::put('/user-roles/{id}', [RoleController::class, 'update'])->middleware('can:Role Update')->name('roles.update');
    
    // Users
    Route::get('/user-creation', [UserController::class, 'index'])->middleware('can:User List')->name('users.index');
    Route::post('/user-creation', [UserController::class, 'store'])->name('users.store');
    Route::get('/user-creation/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/user-creation/{id}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/user-creation/{id}/restore', [UserController::class, 'restore'])->middleware('can:User Delete')->name('users.restore');
    Route::delete('/user-creation/{id}', [UserController::class, 'destroy'])->middleware('can:User Delete')->name('users.destroy');
    
    // All vehicle info
    Route::get('/vehicle-basic-info/{serial_number}', [VehicleRequestController::class, 'showBasicInfo'])->name('vehicle.basic.info');
    Route::get('/all-vehicle-info', [VehicleRequestController::class, 'allVehicleInfo'])->name('vehicle.all.info');

    // Vehicle management routes
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::get('/vehicles/{serialNumber}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::post('/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::put('/vehicles/{serialNumber}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');

    // Forward routes
    Route::get('/forward', function (Request $request) {
        $req_id = $request->query('req_id');
        if (!$req_id) {
            return redirect()->back()->with('error', 'Request ID is required to forward.');
        }

        $currentUser = Auth::user();
        
        // For Establishment Head, load establishments
        if ($currentUser->role && $currentUser->role->name === 'Establishment Head') {
            $establishments = \App\Models\Establishment::where('e_id', '!=', $currentUser->establishment_id)->get();
            return view('forward', compact('establishments', 'req_id'));
        } else {
            // For other roles, load users in the same establishment only
            $users = \App\Models\User::with('role')
                                     ->where('establishment_id', $currentUser->establishment_id)
                                     ->where('id', '!=', $currentUser->id)
                                     ->orderBy('name')
                                     ->get();
            return view('forward', compact('users', 'req_id'));
        }
    })->name('forward');

    // Establishment Head specific forward form
    Route::get('/forward-establishment/{req_id}', [VehicleRequestApprovalController::class, 'showForwardForm'])
        ->name('forward.form');

    // Generic forward action route
    Route::post('/forward', [VehicleRequestApprovalController::class, 'genericForward'])->middleware('can:Forward Request')->name('forward.generic');

    // API route for loading establishment users (protected)
    Route::get('/api/establishment-users/{establishmentId}', function($establishmentId) {
        $users = \App\Models\User::where('establishment_id', $establishmentId)
            ->with('role')
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role_name' => $user->role->name ?? 'No Role',
                    'email' => $user->email
                ];
            });
        
        return response()->json($users);
    })->middleware('auth');
});

// Dropdown data API routes (public for AJAX calls)
Route::get('/get-vehicle-types', [DropdownController::class, 'getVehicleTypes']);
Route::get('/get-allocation-types', [DropdownController::class, 'getAllocationTypes']);
Route::get('/get-makes', [DropdownController::class, 'getMakes']);
Route::get('/get-models', [DropdownController::class, 'getModels']);
Route::get('/get-categories', [DropdownController::class, 'getCategories']);
Route::get('/get-sub-categories/{categoryId}', [DropdownController::class, 'getSubCategories']);
Route::get('/get-colors', [DropdownController::class, 'getColors']);
Route::get('/get-tire-sizes', [DropdownController::class, 'getTireSizes']);
Route::get('/get-engine-capacities', [DropdownController::class, 'getEngineCapacities']);
Route::get('/get-fuel-types', [DropdownController::class, 'getFuelTypes']);
Route::get('/get-workshops', [DropdownController::class, 'getWorkshops']);
Route::get('/get-statuses', [DropdownController::class, 'getStatuses']);
Route::get('/get-locations', [DropdownController::class, 'getLocations']);
Route::get('/get-drivers', [DropdownController::class, 'getDrivers']);
Route::get('/get-faults', [DropdownController::class, 'getFaults']);

