<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\FetchController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\FrontPoiCategoriesController;
use App\Http\Controllers\LastModifiedController;
use App\Http\Controllers\MiscInfoController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\PoiCategoriesController;
use App\Http\Controllers\RoutesCategoriesController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\PoisController;
use App\Http\Controllers\TextPagesController;
use Illuminate\Support\Facades\Route;

Route::get('/fetch', [FetchController::class, 'index']);

Route::get('/routes', [RoutesController::class, 'index']);
Route::get('/route/{resourceId}', [RoutesController::class, 'show']);

Route::get('/objects', [ObjectController::class, 'index']);
Route::get('/object/{resourceId}', [ObjectController::class, 'show']);

Route::get('/pois', [PoisController::class, 'index']);
Route::get('/poi/{resourceId}', [PoisController::class, 'show']);

Route::get('/front-poi-categories', [FrontPoiCategoriesController::class, 'index']);
Route::get('/route-categories', [RoutesCategoriesController::class, 'index']);
Route::get('/poi-categories', [PoiCategoriesController::class, 'index']);

Route::get('/about', [AboutController::class, 'index']);
Route::get('/text-pages', [TextPagesController::class, 'index']);
Route::get('/contacts', [ContactsController::class, 'index']);
Route::get('/misc-info', [MiscInfoController::class, 'index']);
Route::get('/last-modified', [LastModifiedController::class, 'index']);


Route::prefix('{version}')->group(static function (): void{
    Route::get('/routes', [RoutesController::class, 'index']);
    Route::get('/route/{resourceId}', [RoutesController::class, 'show']);

    Route::get('/objects', [ObjectController::class, 'index']);
    Route::get('/object/{resourceId}', [ObjectController::class, 'show']);

    Route::get('/pois', [PoisController::class, 'index']);
    Route::get('/poi/{resourceId}', [PoisController::class, 'show']);

    Route::get('/front-poi-categories', [FrontPoiCategoriesController::class, 'index']);
    Route::get('/route-categories', [RoutesCategoriesController::class, 'index']);
    Route::get('/poi-categories', [PoiCategoriesController::class, 'index']);

    Route::get('/about', [AboutController::class, 'index']);
    Route::get('/text-pages', [TextPagesController::class, 'index']);
    Route::get('/contacts', [ContactsController::class, 'index']);
    Route::get('/misc-info', [MiscInfoController::class, 'index']);
    Route::get('/last-modified', [LastModifiedController::class, 'index']);

});

