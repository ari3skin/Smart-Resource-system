<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Routing;
use Illuminate\Support\Facades\Route;

Route::get('/', [Routing::class, 'showIndex'])->name('/');
Route::get('/about', [Routing::class, 'showabout'])->name('about');
Route::get('/employers', [Routing::class, 'showemployers'])->name('employers');
Route::get('/job_seekers', [Routing::class, 'showjobseekers'])->name('job_seekers');
Route::get('/book_online', [Routing::class, 'showbookonline'])->name('book_online');
Route::get('/program_list', [Routing::class, 'showprogramlist'])->name('program_list');

Route::middleware(['disable_back'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('login', [Routing::class, 'accounts'])->name('login');
        Route::get('registration', [Routing::class, 'accounts'])->name('registration');
        Route::get('reset', [Routing::class, 'accounts'])->name('reset');
        Route::get('create_reset/{user_id}', [Routing::class, 'fromEmailReset'])->name('create_reset');
        Route::get('form_reset/{user_token}', [Routing::class, 'fromEmailReset'])->name('form_reset');

        Route::prefix('google')->group(function () {
            Route::get('/', [GoogleController::class, 'redirectToGoogle']);
            Route::get('call-back', [GoogleController::class, 'handleGoogleCallback']);
        });

        Route::post('login', [AuthController::class, 'login']);
        Route::post('registration', [AuthController::class, 'registration']);
        Route::post('reset-password', [AuthController::class, 'passwordReset']);
        Route::post('save-reset', [AuthController::class, 'saveReset']);

        Route::get('logout', [AuthController::class, 'logout']);
    });

    Route::middleware(['session_timeout'])->group(function () {
        Route::prefix('admin')->group(function () {

            //admin access to their default page
            Route::get('/', [Routing::class, 'dashboards'])->name('admin');

            Route::prefix('creation')->group(function () {
                Route::post('approved', [EmailController::class, 'approved']);
            });
        });
    });
});
