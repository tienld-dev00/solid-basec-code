<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Payment\PaymentController;
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

Route::POST('payment', [PaymentController::class, 'payment']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('user-info', [AuthController::class, 'userInfo'])->middleware('auth:api');
});

Route::middleware(['auth:api'])->group(function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('', [UserController::class, 'index']);
        Route::post('', [UserController::class, 'store']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::patch('/{user}', [UserController::class, 'update'])->can('update', 'user');
    });
});