<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

// Index route
Route::get('/', function () {
    return view('welcome');
});

