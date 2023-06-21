<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Routing;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Routing::class, 'showIndex'])->name('/');

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'accounts'])->name('login');
    Route::get('registration', [AuthController::class, 'accounts'])->name('registration');

    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);

    Route::get('/g-login', [GoogleController::class, 'loginWithGoogle']);
    Route::get('/g-callback', [GoogleController::class, 'callBackFromGoogle']);

    Route::get('logout', [AuthController::class, 'logout']);
});


Route::prefix('admin')->group(function () {

    //admin access to their default page
    Route::get('/', [Routing::class, 'dashboards']);

    Route::prefix('creation')->group(function () {
        Route::post('approved', [EmailController::class, 'approvedRegistration']);
        Route::post('rejected', [EmailController::class, '']);
    });
});
