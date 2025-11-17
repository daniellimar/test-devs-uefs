<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{PostController, TagController, UserController, AuthController};

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

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'store']);
    Route::get('/{post}', [PostController::class, 'show']);
    Route::put('/{post}', [PostController::class, 'update']);
    Route::delete('/{post}', [PostController::class, 'destroy']);
});

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/', [TagController::class, 'store']);
    Route::put('/{tag}', [TagController::class, 'update']);
    Route::delete('/{tag}', [TagController::class, 'destroy']);
});
