<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AuthController;
use Modules\Admin\App\Http\Controllers\ChildMenuController;
use Modules\Admin\App\Http\Controllers\MenuController;
use Modules\Admin\App\Http\Controllers\ModuleController;
use Modules\Admin\App\Http\Controllers\PermissionController;
use Modules\Admin\App\Http\Controllers\RoleController;
use Modules\Admin\App\Http\Controllers\UserAccessController;
use Modules\Admin\App\Http\Controllers\UserController;
use Modules\Admin\App\Http\Controllers\UserPermissionController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('modules', ModuleController::class);
    Route::apiResource('menus', MenuController::class);
    Route::apiResource('child-menus', ChildMenuController::class);

    Route::apiResource('users', UserController::class);
    Route::get('/users-list', [UserController::class, 'userList']);
    Route::get('/users/{user}/access', [UserAccessController::class, 'show']);
    Route::put('/users/{user}/access', [UserAccessController::class, 'update']);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/assign-permission', [
        UserPermissionController::class,
        'assignPermission',
    ]);

    Route::post('user/remove-permission', [
        UserPermissionController::class,
        'removePermission',
    ]);
});