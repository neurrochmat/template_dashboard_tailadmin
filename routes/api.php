<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\MenusController;

Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Resourceful CRUD
    Route::apiResource('users', UsersController::class)->parameters(['users' => 'id']);
    Route::apiResource('roles', RolesController::class)->parameters(['roles' => 'id']);
    Route::apiResource('menus', MenusController::class)->parameters(['menus' => 'id']);
    });
});
