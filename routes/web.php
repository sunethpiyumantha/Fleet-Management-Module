<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleEngineCapacityController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/test', function () {
    return 'Test route works!';
});

Route::get('/vehicle', function () {
    return view('vehicle');
})->name('vehicle');



Route::get('/vehicle-engine-capacity', [VehicleEngineCapacityController::class, 'index'])->name('vehicle-engine-capacity.index');
Route::post('/vehicle-engine-capacity/store', [VehicleEngineCapacityController::class, 'store'])->name('vehicle-engine-capacity.store');
Route::post('/vehicle-engine-capacity/update/{id}', [VehicleEngineCapacityController::class, 'update']);
Route::delete('/vehicle-engine-capacity/delete/{id}', [VehicleEngineCapacityController::class, 'destroy'])->name('vehicle-engine-capacity.destroy');


Route::get('/fuel-type', function () {
    return view('fuel-type');
})->name('fuel-type');

Route::get('/vehicle-color', function () {
    return view('vehicle-color');
})->name('vehicle-color');

Route::get('/vehicle-status', function () {
    return view('vehicle-status');
})->name('vehicle-status');

Route::get('/workshop', function () {
    return view('workshop');
})->name('workshop');

Route::get('/establishment', function () {
    return view('establishment');
})->name('establishment');

Route::get('/index.html', function () {
    return view('welcome');
});

Route::get('/vehicle-allocation', function () {
    return view('vehicle-allocation');
})->name('vehicle-allocation');

Route::get('/vehicle-sub-catogory', function () {
    return view('vehicle-sub-catogory');
})->name('vehicle-sub-catogory');

Route::get('/vehicle-tire-sizes', function () {
    return view('vehicle-tire-sizes');
})->name('vehicle-tire-sizes');

Route::get('/vehicle-make', function () {
    return view('vehicle-make');
})->name('vehicle-make');

Route::get('/vehicle-models', function () {
    return view('vehicle-models');
})->name('vehicle-models');

Route::get('/vehicle-catogory', function () {
    return view('vehicle-catogory');
})->name('vehicle-catogory');




