<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\ProductController;

Route::prefix('products/')->controller(ProductController::class)->name('api.')->group(function () {
    Route::get('all', 'index')->name('products');
});
