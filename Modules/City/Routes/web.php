<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\City\Http\Controllers\Dashboard\CityController;

Route::group([
    'as' => 'admin.',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:web']
], function () {
    Route::resource('city', CityController::class)->except(['show', 'destroy']);
    Route::post('city/toggle-status/{city}', [CityController::class, 'toggleStatus'])->name('city.toggleStatus');
});