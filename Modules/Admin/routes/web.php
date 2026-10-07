<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AuthController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('auths', AuthController::class)->names('auth');
});
