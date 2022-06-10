<?php

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

Route::post('login', \App\Http\Controllers\Api\LoginController::class);

Route::group(['prefix' => 'order', 'middleware' => 'auth:sanctum'], function () {
    Route::post('submit', [\App\Http\Controllers\Api\OrderController::class, 'submit']);
    Route::post('details/{order}', [\App\Http\Controllers\Api\OrderController::class, 'details']);
    Route::post('{order}/delivered', [\App\Http\Controllers\Api\OrderController::class, 'delivered']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
