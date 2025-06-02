<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/test', function () {
    return 'Test route works!';
});


Route::get('/vehicle-engine-capacity', function () {
    return view('vehicle-engine-capacity');
})->name('vehicle-engine-capacity');

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

Route::get('/vehicle', function () {
    return view('vehicle');
})->name('vehicle');

Route::get('/vehicle-allocation', function () {
    return view('vehicle-allocation');
})->name('vehicle-allocation');



