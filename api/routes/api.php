<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('users')->group(function () {

        Route::get(
            '/',
            [UserController::class, 'index']
        )->middleware('can:viewAny,App\Models\User');

        Route::post(
            '/',
            [UserController::class, 'store']
        )->middleware('can:create,App\Models\User');

        Route::put(
            '/{user}',
            [UserController::class, 'update']
        )->middleware('can:update,user');

        Route::delete(
            '/{user}',
            [UserController::class, 'destroy']
        )->middleware('can:delete,user');

    });
});
