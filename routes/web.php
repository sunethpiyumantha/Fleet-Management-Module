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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/test', function () {
    return 'Test route works!';
});

Route::resource('vehicle-type', VehicleTypeController::class);

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
Route::delete('/establishments/{establishment}', [EstablishmentController::class, 'destroy'])->name('establishments.destroy');

Route::get('/index.html', function () {
    return view('welcome');
});

Route::get('/vehicle-allocation', function () {
    return view('vehicle-allocation');
})->name('vehicle-allocation');

Route::get('/vehicle-sub-catogory', function () {
    return view('vehicle-sub-catogory');
})->name('vehicle-sub-catogory');

Route::get('/vehicle-tire-sizes', [VehicleTireSizeController::class, 'index'])->name('vehicle-tire-sizes.index');
Route::post('/vehicle-tire-sizes', [VehicleTireSizeController::class, 'store'])->name('vehicle-tire-sizes.store');
Route::post('/vehicle-tire-sizes/{id}', [VehicleTireSizeController::class, 'update'])->name('vehicle-tire-sizes.update');
Route::delete('/vehicle-tire-sizes/{id}', [VehicleTireSizeController::class, 'destroy'])->name('vehicle-tire-sizes.destroy');

Route::get('/vehicle-make', function () {
    return view('vehicle-make');
})->name('vehicle-make');

Route::get('/vehicle-models', [VehicleModelController::class, 'index'])->name('vehicle-models.index');
Route::post('/vehicle-models', [VehicleModelController::class, 'store'])->name('vehicle-models.store');
Route::post('/vehicle-models/{vehicleModel}', [VehicleModelController::class, 'update'])->name('vehicle-models.update');
Route::delete('/vehicle-models/{vehicleModel}', [VehicleModelController::class, 'destroy'])->name('vehicle-models.destroy');

Route::get('/vehicle-catogory', function () {
    return view('vehicle-catogory');
})->name('vehicle-catogory');
