<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\City\Http\Controllers\Dashboard\CityController;
use Modules\City\Http\Controllers\Dashboard\DistrictController;

Route::group([
    'as' => 'admin.',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:web']
], function () {
    Route::resource('city', CityController::class)->except(['show', 'destroy']);
    Route::post('city/toggle-status/{city}', [CityController::class, 'toggleStatus'])->name('city.toggleStatus');


    Route::prefix('city/{city}/district')->name('district.')->group(function () {
        Route::get('/', [DistrictController::class, 'index'])->name('index');
        Route::post('/', [DistrictController::class, 'store'])->name('store');
        Route::get('/{district}/edit', [DistrictController::class, 'edit'])->name('edit');
        Route::put('/{district}', [DistrictController::class, 'update'])->name('update');
    });

    Route::post('district/toggle-status/{district}', [DistrictController::class, 'toggleStatus'])->name('district.toggleStatus');
});
