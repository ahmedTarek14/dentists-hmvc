<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\DoctorController;
use Modules\User\Http\Controllers\Api\RateController;


Route::prefix('doctors/')->controller(DoctorController::class)->name('api.')->group(function () {
    Route::get('all', 'index')->name('doctors');
    Route::get('orders', 'orders')->name('orders');
});


Route::middleware(['auth:sanctum'])
    ->name('rate.')
    ->prefix('rate')
    ->group(function () {
        Route::post('/store', [RateController::class, 'store'])->name('store');
    });
