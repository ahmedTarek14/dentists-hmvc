<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\ProductController;
use Modules\Product\Http\Controllers\Api\WorkController;

Route::prefix('products/')->controller(ProductController::class)->name('api.')->group(function () {
    Route::get('all', 'index')->name('products');
});

Route::prefix('works/')->controller(WorkController::class)->name('api.')->group(function () {
    Route::get('all', 'index')->name('works');
    Route::post('add', 'store')->name('store')->middleware('auth:sanctum');
    Route::get('my-works', 'myWorks')->name('myWorks');
});
