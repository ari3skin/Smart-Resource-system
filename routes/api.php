<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SqlStorage;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
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
            //posts
            Route::post('create', [ProjectController::class, 'store']);
            Route::post('status', [ProjectController::class, 'update']);
        });

        Route::prefix('tasks')->group(function () {
            Route::get('managers/{user_id}', [TaskController::class, 'index'])->name('managers_tasks');
            Route::get('employees/{user_id}', [TaskController::class, 'index'])->name('employees_tasks');

            //posts
            Route::post('create', [TaskController::class, 'store']);
        });

        Route::prefix('teams')->group(function () {
            Route::get('managers/{user_id}', [TeamController::class, 'index'])->name('managers_teams');
            Route::get('employees/{user_id}', [TeamController::class, 'index'])->name('employee_teams');

            //posts
            Route::post('create', [TeamController::class, 'store']);
            Route::post('status', [TeamController::class, 'update']);
        });

        Route::prefix('reports')->group(function () {
            Route::get('managers/{user_id}', [ReportController::class, 'index'])->name('managers_reports');
            Route::get('employees/{user_id}',[ReportController::class,'index'])->name('employee_reports');

            //posts
            Route::post('create', [ReportController::class, 'store']);
        });

        Route::get('sqlTests', [SqlStorage::class, 'randomQueries']);
    });
});



