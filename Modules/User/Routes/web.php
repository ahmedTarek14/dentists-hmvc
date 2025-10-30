<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Product\Http\Controllers\Dashboard\ProductController;
use Modules\User\Http\Controllers\Dashboard\TypeController;
use Modules\User\Http\Controllers\Dashboard\UserController;

Route::group([
    'as' => 'admin.',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:web']
], function () {
    Route::get('user/{type}', [UserController::class, 'index'])->name('user.index');
    Route::resource('user', UserController::class)->except(['index', 'destroy']);
    Route::post('user/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('city.toggleStatus');

    Route::resource('types', TypeController::class)->except(['destroy', 'show']);
    Route::post('types/toggle-status/{type}', [TypeController::class, 'toggleStatus'])->name('types.toggleStatus');
});
