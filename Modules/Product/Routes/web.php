<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Product\Http\Controllers\Dashboard\ProductController;
use Modules\Product\Http\Controllers\Dashboard\WorkController;

Route::group([
    'as' => 'admin.',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:web']
], function () {
    Route::resource('product', ProductController::class)->except(['show']);

    Route::resource('work', WorkController::class)->except(['show', 'store', 'create']);
});
