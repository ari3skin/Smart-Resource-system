<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['disable_back'])->group(function () {

    Route::middleware(['session_timeout'])->group(function () {

        Route::prefix('projects')->group(function () {
            Route::get('/{user_id}', [ProjectController::class, 'index'])->name('projectInfo');
            Route::get('user/{projectManagerId}', [ProjectController::class, 'index'])->name('getUserInfo');
            Route::get('employer/{employerId}', [ProjectController::class, 'getEmployer']);

            //posts
            Route::post('create', [ProjectController::class, 'store']);
        });

        Route::prefix('tasks')->group(function () {
            Route::get('managers/{user_id}', [TaskController::class, 'index'])->name('managers_tasks');
            Route::get('employees/{user_id}', [TaskController::class, 'index'])->name('employees_tasks');

            //posts
            Route::post('create', [TaskController::class, 'store']);
        });
    });
});



