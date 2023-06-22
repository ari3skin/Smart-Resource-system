<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Routing;
use Illuminate\Support\Facades\Route;

Route::get('/', [Routing::class, 'showIndex'])->name('/');

Route::prefix('auth')->group(function () {
    Route::get('login', [Routing::class, 'accounts'])->name('login');
    Route::get('registration', [Routing::class, 'accounts'])->name('registration');
    Route::get('reset-password/{user_id}', [Routing::class, 'passwordReset']);

    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::get('logout', [AuthController::class, 'logout']);
});

Route::prefix('admin')->group(function () {

    //admin access to their default page
    Route::get('/', [Routing::class, 'dashboards']);

    Route::prefix('creation')->group(function () {
        Route::post('approved', [EmailController::class, 'approved']);
        Route::post('rejected', [EmailController::class, '']);
    });
});
