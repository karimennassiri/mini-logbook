<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

// Index route
Route::get('/', function () {
    return view('welcome');
});

// Location's routes group
Route::prefix('locations')->group(function () {
    Route::get('/', [LocationController::class, 'all']);
    Route::post('/import', [LocationController::class, 'import']);
    Route::get('/{id}', [LocationController::class, 'get']);
    Route::put('/{id}', [LocationController::class, 'update']);
});

