<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/', function () {
    return response()->json([
        'message' => 'API funcionando corretamente',
    ]);
});

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
