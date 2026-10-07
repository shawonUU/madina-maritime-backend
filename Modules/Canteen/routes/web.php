<?php

use Illuminate\Support\Facades\Route;
use Modules\Canteen\App\Http\Controllers\MealMenuController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('meals', MealMenuController::class)->names('meal');
});
