<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\DoctorController;


Route::prefix('doctors/')->controller(DoctorController::class)->name('api.')->group(function () {
    Route::get('all', 'index')->name('doctors');
    Route::get('orders', 'orders')->name('orders');
});
