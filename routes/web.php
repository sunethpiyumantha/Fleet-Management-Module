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

Route::get('/vehicle', function () {
    return view('vehicle');
})->name('vehicle');

Route::get('/index.html', function () {
    return view('welcome');
});



