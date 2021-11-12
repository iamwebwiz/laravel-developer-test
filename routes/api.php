<?php

use App\Http\Controllers\PersonController;
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

Route::prefix('people')->group(function () {
    Route::get('/', [PersonController::class, 'list']);
    Route::get('{id}', [PersonController::class, 'get']);
    Route::get('{id}/tree', [PersonController::class, 'getTree']);
    Route::post('create', [PersonController::class, 'create']);
    Route::put('{id}/update', [PersonController::class, 'update']);
    Route::post('{id}/add', [PersonController::class, 'add']);
    Route::delete('{id}/remove', [PersonController::class, 'remove']);
});
