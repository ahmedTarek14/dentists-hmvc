<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\AuthController;

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

Route::name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('auth/login', 'login')->name('login');
        Route::post('auth/register', 'register')->name('register');
        Route::post('auth/logout', 'logout')->name('logout')->middleware('auth:sanctum');
        Route::post('auth/change-password-logged', 'change_password_logged')->name('change_password_logged')->middleware('auth:sanctum');
        Route::get('profile/logged-user', 'logged_user')->name('logged_user')->middleware('auth:sanctum');
        Route::delete('profile/delete-account', 'delete_account')->name('delete_account')->middleware('auth:sanctum');
        Route::put('profile/update-image', 'updateAvatar')->name('updateAvatar')->middleware('auth:sanctum');
        Route::post('auth/forget-password', 'forget_password')->name('forget_password');
        Route::post('auth/change-password', 'change_password')->name('change_password');
    });
