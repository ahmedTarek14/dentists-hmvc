<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Auth\Http\Controllers\Dashboard\AuthController;

Route::middleware('web')
    ->name('admin.')
    ->prefix(LaravelLocalization::setLocale() . '/admin')
    ->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

// Route::middleware('auth:web')->name('admin.')->prefix('admin')->group(function () {
//     Route::resource('user', UserController::class)->only(['index', 'destroy']);
//     Route::get('user/update-status/{user}', [UserController::class, 'update_status'])->name('user.update_status');
// });