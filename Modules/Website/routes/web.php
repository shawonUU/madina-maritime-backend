<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\App\Http\Controllers\WebsiteController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('websites', WebsiteController::class)->names('website');
});
