<?php

use App\Http\Controllers\ObjectController;
use App\Http\Controllers\RoutesController;
use Illuminate\Support\Facades\Route;

Route::get('/routes', [RoutesController::class, 'index']);
Route::get('/routes/{routeId}', [RoutesController::class, 'route']);
Route::get('/objects', [ObjectController::class, 'index']);
