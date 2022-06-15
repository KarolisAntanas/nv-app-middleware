<?php

use App\Http\Controllers\EndpointsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/routes', [EndpointsController::class, 'routes']);
Route::get('/routes/{routeId}', [EndpointsController::class, 'route']);
Route::get('/objects', [EndpointsController::class, 'objects']);
Route::get('/api', [EndpointsController::class, 'api']);
