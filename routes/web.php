<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Routing;
use Illuminate\Support\Facades\Route;

Route::get('/', [Routing::class, 'showIndex'])->name('/');

Route::group(['middleware' => 'disable_back'], function () {

    Route::prefix('auth')->group(function () {
        Route::get('login', [Routing::class, 'accounts'])->name('login');
        Route::get('registration', [Routing::class, 'accounts'])->name('registration');
        Route::get('reset', [Routing::class, 'accounts'])->name('reset');
        Route::get('create_reset/{user_id}', [Routing::class, 'fromEmailReset'])->name('create_reset');
        Route::get('form_reset/{user_token}', [Routing::class, 'fromEmailReset'])->name('form_reset');

        Route::get('google', [GoogleController::class, 'redirectToGoogle']);

        Route::post('login', [AuthController::class, 'login']);
        Route::post('registration', [AuthController::class, 'registration']);
        Route::post('reset-password', [AuthController::class, 'passwordReset']);
        Route::post('save-reset', [AuthController::class, 'saveReset']);

        Route::get('logout', [AuthController::class, 'logout']);
    });

    Route::prefix('admin')->group(function () {

        //admin access to their default page
        Route::get('/', [Routing::class, 'dashboards'])->name('admin');

        Route::prefix('creation')->group(function () {
            Route::post('approved', [EmailController::class, 'approved']);
            Route::post('rejected', [EmailController::class, '']);
        });
    });

});
