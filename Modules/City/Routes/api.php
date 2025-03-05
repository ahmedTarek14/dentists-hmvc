<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\Api\CityController;

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

Route::prefix('cities/')->controller(CityController::class)->name('api.')->group(function () {
    Route::get('all', 'cities')->name('cities');
});