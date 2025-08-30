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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/test', function () {
    return 'Test route works!';
});

//Route::resource('vehicle-type', VehicleTypeController::class);
Route::get('/vehicle-types', [VehicleTypeController::class, 'index'])->name('vehicle-types.index');
Route::post('/vehicle-types', [VehicleTypeController::class, 'store'])->name('vehicle-types.store');
Route::post('/vehicle-types/{vehicleType}', [VehicleTypeController::class, 'update'])->name('vehicle-types.update');
Route::delete('/vehicle-types/{vehicleType}', [VehicleTypeController::class, 'destroy'])->name('vehicle-types.destroy');

Route::get('/vehicle-engine-capacity', [VehicleEngineCapacityController::class, 'index'])->name('vehicle-engine-capacity.index');
Route::post('/vehicle-engine-capacity', [VehicleEngineCapacityController::class, 'store'])->name('vehicle-engine-capacity.store');
Route::post('/vehicle-engine-capacity/update/{id}', [VehicleEngineCapacityController::class, 'update']);
Route::delete('/vehicle-engine-capacity/delete/{id}', [VehicleEngineCapacityController::class, 'destroy'])->name('vehicle-engine-capacity.destroy');

Route::get('/fuel-types', [FuelTypeController::class, 'index'])->name('fuel-types.index');
Route::post('/fuel-types', [FuelTypeController::class, 'store'])->name('fuel-types.store');
Route::post('/fuel-types/update/{id}', [FuelTypeController::class, 'update'])->name('fuel-types.update');
Route::delete('/fuel-types/{id}', [FuelTypeController::class, 'destroy'])->name('fuel-types.destroy');



Route::get('/vehicle-color', [VehicleColorController::class, 'index'])->name('vehicle-color.index');
Route::post('/vehicle-color', [VehicleColorController::class, 'store'])->name('vehicle-color.store');
Route::post('/vehicle-color/update/{id}', [VehicleColorController::class, 'update'])->name('vehicle-color.update');
Route::delete('/vehicle-color/{id}', [VehicleColorController::class, 'destroy'])->name('vehicle-color.destroy');

Route::get('/vehicle-status', [VehicleStatusController::class, 'index'])->name('vehicle-status.index');
Route::post('/vehicle-status', [VehicleStatusController::class, 'store'])->name('vehicle-status.store');
Route::post('/vehicle-status/update/{id}', [VehicleStatusController::class, 'update'])->name('vehicle-status.update');
Route::delete('/vehicle-status/{id}', [VehicleStatusController::class, 'destroy'])->name('vehicle-status.destroy');

Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::post('/workshops', [WorkshopController::class, 'store'])->name('workshops.store');
Route::post('/workshops/update/{id}', [WorkshopController::class, 'update'])->name('workshops.update');
Route::delete('/workshops/{id}', [WorkshopController::class, 'destroy'])->name('workshops.destroy');

Route::get('/establishments', [EstablishmentController::class, 'index'])->name('establishments.index');
Route::post('/establishments', [EstablishmentController::class, 'store'])->name('establishments.store');
Route::post('/establishments/{establishment}', [EstablishmentController::class, 'update'])->name('establishments.update');
Route::delete('/establishments/{id}', [EstablishmentController::class, 'destroy'])->name('establishments.destroy');

Route::get('/index.html', function () {
    return view('welcome');
});

/*Route::get('/vehicle-allocation', function () {
    return view('vehicle-allocation');
})->name('vehicle-allocation');

Route::get('/vehicle-sub-catogory', function () {
    return view('vehicle-sub-catogory');
})->name('vehicle-sub-catogory');*/

Route::get('/vehicle-tire-sizes', [VehicleTireSizeController::class, 'index'])->name('vehicle-tire-sizes.index');
Route::post('/vehicle-tire-sizes', [VehicleTireSizeController::class, 'store'])->name('vehicle-tire-sizes.store');
Route::post('/vehicle-tire-sizes/{id}', [VehicleTireSizeController::class, 'update'])->name('vehicle-tire-sizes.update');
Route::delete('/vehicle-tire-sizes/{id}', [VehicleTireSizeController::class, 'destroy'])->name('vehicle-tire-sizes.destroy');

Route::get('/vehicle-make', [VehicleMakeController::class, 'index'])->name('vehicle-make.index');
Route::post('/vehicle-make', [VehicleMakeController::class, 'store'])->name('vehicle-make.store');
Route::post('/vehicle-make/{id}', [VehicleMakeController::class, 'update'])->name('vehicle-make.update');
Route::delete('/vehicle-make/{id}', [VehicleMakeController::class, 'destroy'])->name('vehicle-make.destroy');

Route::get('/vehicle-models', [VehicleModelController::class, 'index'])->name('vehicle-models.index');
Route::post('/vehicle-models', [VehicleModelController::class, 'store'])->name('vehicle-models.store');
Route::post('/vehicle-models/{vehicleModel}', [VehicleModelController::class, 'update'])->name('vehicle-models.update');
Route::delete('/vehicle-models/{id}', [VehicleModelController::class, 'destroy'])->name('vehicle-models.destroy');

use App\Http\Controllers\VehicleCategoryController;

Route::get('/vehicle-category', [VehicleCategoryController::class, 'index'])->name('vehicle-category.index');
Route::post('/vehicle-category', [VehicleCategoryController::class, 'store'])->name('vehicle-category.store');
Route::post('/vehicle-category/{id}', [VehicleCategoryController::class, 'update'])->name('vehicle-category.update');
Route::delete('/vehicle-category/{id}', [VehicleCategoryController::class, 'destroy'])->name('vehicle-category.destroy');

use App\Http\Controllers\VehicleAllocationTypeController;

Route::get('/vehicle-allocation-type', [VehicleAllocationTypeController::class, 'index'])->name('vehicle-allocation-type.index');
Route::post('/vehicle-allocation-type', [VehicleAllocationTypeController::class, 'store'])->name('vehicle-allocation-type.store');
Route::post('/vehicle-allocation-type/{id}', [VehicleAllocationTypeController::class, 'update'])->name('vehicle-allocation-type.update');
Route::delete('/vehicle-allocation-type/{id}', [VehicleAllocationTypeController::class, 'destroy'])->name('vehicle-allocation-type.destroy');

use App\Http\Controllers\VehicleSubCategoryController;

Route::resource('vehicle-sub-categories', VehicleSubCategoryController::class)->only([
    'index', 'store', 'update', 'destroy'
])->names('vehicle-sub-category');


use App\Http\Controllers\VehicleRequestController;
use App\Http\Controllers\VehicleDeclarationFormController;

// routes/web.php
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Vehicle Request Routes
Route::prefix('vehicle-request')->name('vehicle.request.')->group(function () {
    Route::get('/', [VehicleRequestController::class, 'index'])->name('index');
    Route::get('/create', [VehicleRequestController::class, 'create'])->name('create');
    Route::post('/', [VehicleRequestController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [VehicleRequestController::class, 'edit'])->name('edit');
    Route::put('/{id}', [VehicleRequestController::class, 'update'])->name('update');
    Route::delete('/{id}', [VehicleRequestController::class, 'destroy'])->name('destroy');
    Route::get('/all', [VehicleRequestController::class, 'allRequests'])->name('all');
});

// Vehicle Declaration Routes
Route::prefix('vehicle-declaration')->name('vehicle.declaration.')->group(function () {
    Route::get('/', [VehicleDeclarationFormController::class, 'create'])->name('create');
    Route::post('/', [VehicleDeclarationFormController::class, 'store'])->name('store');
    Route::get('/edit/{serial_number}', [VehicleDeclarationFormController::class, 'edit'])->name('edit');
    Route::put('/{id}', [VehicleDeclarationFormController::class, 'update'])->name('update');
});

// Vehicle Inspection Routes
Route::prefix('vehicle-inspection')->name('vehicle.inspection.')->group(function () {
    Route::get('/', [VehicleRequestController::class, 'vehicleInspection'])->name('index');
    Route::get('/create/{serial_number}/{request_type}', [VehicleRequestController::class, 'createInspection'])->name('create');
    Route::post('/store', [VehicleRequestController::class, 'storeInspection'])->name('store');
});

// AJAX for Subcategories
Route::get('/get-sub-categories/{catId}', [VehicleRequestController::class, 'getSubCategories'])->name('vehicle.request.subcategories');

use App\Http\Controllers\VehicleTechnicalDescriptionController;


Route::get('/vehicle-technical-description/{serial_number}/{request_type}', [VehicleTechnicalDescriptionController::class, 'create'])->name('vehicle.technical.create');
Route::post('/vehicle-technical-description/{serial_number}', [VehicleTechnicalDescriptionController::class, 'store'])->name('vehicle.technical.store');


Route::get('/vehicle-registration', function () {
    return view('vehicle-technical-description');
});
Route::get('/vehicle-inspection-request', function () {
    return view('vehicle-inspection');
});


Route::get('/vehicle-inspection-form2', [VehicleRequestController::class, 'vehicleInspectionForm2'])->name('vehicle.inspection.form2');
Route::get('/vehicle/certificate/create', [VehicleRequestController::class, 'certificateCreate'])->name('vehicle.certificate.create');
Route::post('/vehicle/certificate/store', [VehicleRequestController::class, 'certificateStore'])->name('vehicle.certificate.store');

Route::get('/all-drivers', function () {
    return view('all-drivers');
})->name('all-drivers');

Route::get('/driver-amendment', function () {
    return view('driver-amendment');
})->name('driver-amendment');

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/user-roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/user-roles', [RoleController::class, 'store'])->name('roles.store');
Route::put('/user-roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/user-roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::patch('/user-roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');

Route::get('/user-creation', [UserController::class, 'index'])->name('users.index');
Route::post('/user-creation', [UserController::class, 'store'])->name('users.store');
Route::put('/user-creation/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/user-creation/{id}', [UserController::class, 'destroy'])->name('users.destroy');