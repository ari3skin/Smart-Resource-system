<?php

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

Route::prefix('admin/')->group(function () {

    //admin access to their default page
    Route::get('/', [Routing::class, 'admin']);
});
