<?php

use Illuminate\Support\Facades\Route;
use Modules\HRM\App\Http\Controllers\CareerController;
use Modules\HRM\App\Http\Controllers\JobApplicationController;
use Modules\HRM\App\Http\Controllers\JobPostController;
use Modules\HRM\App\Http\Controllers\EmployeeController;
use Modules\HRM\App\Http\Controllers\RecruitmentEmailController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('employees', EmployeeController::class)->names('employee');
});


Route::prefix('careers')->group(function () {

    Route::get(
        '/jobs',
        [CareerController::class, 'jobs']
    );

    Route::get(
        '/jobs/{slug}',
        [CareerController::class, 'show']
    );

    Route::post(
        '/jobs/{jobPost}/apply',
        [CareerController::class, 'apply']
    );
});


    Route::middleware('auth:sanctum')->prefix('hrm/recruitment')->group(function () {
        Route::apiResource( 'job-posts', JobPostController::class );
        Route::get( 'applications', [JobApplicationController::class, 'index'] );
        Route::get( 'applications/{jobApplication}', [JobApplicationController::class, 'show'] );

        Route::put('applications/{jobApplication}/status',[JobApplicationController::class, 'updateStatus']);

        Route::get(
            'applications/{jobApplication}/cv',
            [JobApplicationController::class, 'downloadCv']
        );
    });


    Route::middleware('auth:sanctum')
    ->prefix('hrm/recruitment')
    ->group(function () {

        Route::apiResource(
            'job-posts',
            JobPostController::class
        );

        Route::get(
            'applications',
            [JobApplicationController::class, 'index']
        );

        Route::get(
            'applications/{jobApplication}',
            [JobApplicationController::class, 'show']
        );

        Route::put(
            'applications/{jobApplication}/status',
            [JobApplicationController::class, 'updateStatus']
        );

        Route::get(
            'applications/{jobApplication}/cv',
            [JobApplicationController::class, 'downloadCv']
        );

        Route::get(
            'email/templates',
            [RecruitmentEmailController::class, 'templates']
        );

        Route::post(
            'email/preview',
            [RecruitmentEmailController::class, 'preview']
        );

        Route::post(
            'email/send',
            [RecruitmentEmailController::class, 'send']
        );

        Route::get(
            'email/logs',
            [RecruitmentEmailController::class, 'logs']
        );
    });
