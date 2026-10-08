<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\App\Http\Controllers\CareerController;
use Modules\Website\App\Http\Controllers\ContactController;
use Modules\Website\App\Http\Controllers\ContactEnquiryController;
use Modules\Website\App\Http\Controllers\MarineServicesController;
use Modules\Website\App\Http\Controllers\SisterConcernController;
use Modules\Website\App\Http\Controllers\VendorPartnerController;
use Modules\Website\App\Http\Controllers\WebsiteAboutController;
use Modules\Website\App\Http\Controllers\WebsiteAboutStatController;
use Modules\Website\App\Http\Controllers\WebsiteAboutTeamController;
use Modules\Website\App\Http\Controllers\WebsiteCustomerController;
use Modules\Website\App\Http\Controllers\WebsiteHomePageController;
use Modules\Website\App\Http\Controllers\WebsiteHomeSettingController;

Route::prefix('website')->group(function () {

    Route::get(
        '/hero-slides',
        [WebsiteHomePageController::class, 'index']
    );

    Route::post(
        '/hero-slides',
        [WebsiteHomePageController::class, 'store']
    );

    Route::get(
        '/hero-slides/{id}',
        [WebsiteHomePageController::class, 'show']
    );

    Route::put(
        '/hero-slides/{id}',
        [WebsiteHomePageController::class, 'update']
    );

    Route::delete(
        '/hero-slides/{id}',
        [WebsiteHomePageController::class, 'destroy']
    );
});


Route::prefix('website')->group(function () {

    Route::get('/about', [
        WebsiteAboutController::class,
        'index'
    ]);

    Route::post('/about', [
        WebsiteAboutController::class,
        'store'
    ]);

    Route::get('/about/stats', [
        WebsiteAboutStatController::class,
        'index'
    ]);

    Route::post('/about/stats', [
        WebsiteAboutStatController::class,
        'store'
    ]);

    Route::put('/about/stats/{id}', [
        WebsiteAboutStatController::class,
        'update'
    ]);

    Route::delete('/about/stats/{id}', [
        WebsiteAboutStatController::class,
        'destroy'
    ]);

    Route::get('/about/team', [
        WebsiteAboutTeamController::class,
        'index'
    ]);

    Route::post('/about/team', [
        WebsiteAboutTeamController::class,
        'store'
    ]);

    Route::post('/about/team/{id}', [
        WebsiteAboutTeamController::class,
        'update'
    ]);

    Route::delete('/about/team/{id}', [
        WebsiteAboutTeamController::class,
        'destroy'
    ]);

    Route::post('/about/{id}', [
        WebsiteAboutController::class,
        'update'
    ]);
});


Route::get(
    '/website/sister-concerns',
    [SisterConcernController::class, 'index']
);

Route::middleware('auth:sanctum')->prefix('website/admin')->group(function () {

    Route::get(
        '/sister-concerns',
        [SisterConcernController::class, 'adminIndex']
    );

    Route::post(
        '/sister-concerns/page',
        [SisterConcernController::class, 'updatePage']
    );

    Route::post(
        '/sister-concerns/sectors',
        [SisterConcernController::class, 'storeSector']
    );

    Route::post(
        '/sister-concerns/sectors/{id}',
        [SisterConcernController::class, 'updateSector']
    );

    Route::delete(
        '/sister-concerns/sectors/{id}',
        [SisterConcernController::class, 'deleteSector']
    );

    Route::post(
        '/sister-concerns/concerns',
        [SisterConcernController::class, 'storeConcern']
    );

    Route::post(
        '/sister-concerns/concerns/{id}',
        [SisterConcernController::class, 'updateConcern']
    );

    Route::delete(
        '/sister-concerns/concerns/{id}',
        [SisterConcernController::class, 'deleteConcern']
    );

    Route::post(
        '/sister-concerns/organizations',
        [SisterConcernController::class, 'storeOrganization']
    );

    Route::post(
        '/sister-concerns/organizations/{id}',
        [SisterConcernController::class, 'updateOrganization']
    );

    Route::delete(
        '/sister-concerns/organizations/{id}',
        [SisterConcernController::class, 'deleteOrganization']
    );
});


Route::get(
    '/website/services',
    [MarineServicesController::class, 'index']
);

Route::prefix('/website/admin/services')->group(function () {

    Route::get(
        '/',
        [MarineServicesController::class, 'adminIndex']
    );

    Route::post(
        '/page',
        [MarineServicesController::class, 'updatePage']
    );

    Route::post(
        '/stats',
        [MarineServicesController::class, 'storeStat']
    );

    Route::post(
        '/stats/{id}/update',
        [MarineServicesController::class, 'updateStat']
    );

    Route::delete(
        '/stats/{id}',
        [MarineServicesController::class, 'deleteStat']
    );

    Route::post(
        '/services',
        [MarineServicesController::class, 'storeService']
    );

    Route::post(
        '/services/{id}/update',
        [MarineServicesController::class, 'updateService']
    );

    Route::delete(
        '/services/{id}',
        [MarineServicesController::class, 'deleteService']
    );

    Route::post(
        '/equipments',
        [MarineServicesController::class, 'storeEquipment']
    );

    Route::post(
        '/equipments/{id}/update',
        [MarineServicesController::class, 'updateEquipment']
    );

    Route::delete(
        '/equipments/{id}',
        [MarineServicesController::class, 'deleteEquipment']
    );
});

Route::get('/website/customers', [WebsiteCustomerController::class, 'index']);

Route::prefix('website/admin/customers')->group(function () {
    Route::get('/', [WebsiteCustomerController::class, 'adminIndex']);

    Route::post('/page/update', [WebsiteCustomerController::class, 'updatePage']);

    Route::post('/stats', [WebsiteCustomerController::class, 'storeStat']);
    Route::post('/stats/{id}/update', [WebsiteCustomerController::class, 'updateStat']);
    Route::delete('/stats/{id}', [WebsiteCustomerController::class, 'destroyStat']);

    Route::post('/', [WebsiteCustomerController::class, 'storeCustomer']);
    Route::post('/{id}/update', [WebsiteCustomerController::class, 'updateCustomer']);
    Route::delete('/{id}', [WebsiteCustomerController::class, 'destroyCustomer']);
});


Route::get('/website/vendors-partners', [VendorPartnerController::class, 'index']);

Route::prefix('website/admin/vendors-partners')->group(function () {
    Route::get('/', [VendorPartnerController::class, 'adminIndex']);

    Route::post('/page/update', [VendorPartnerController::class, 'updatePage']);

    Route::post('/stats', [VendorPartnerController::class, 'storeStat']);
    Route::post('/stats/{id}/update', [VendorPartnerController::class, 'updateStat']);
    Route::delete('/stats/{id}', [VendorPartnerController::class, 'destroyStat']);

    Route::post('/', [VendorPartnerController::class, 'storePartner']);
    Route::post('/{id}/update', [VendorPartnerController::class, 'updatePartner']);
    Route::delete('/{id}', [VendorPartnerController::class, 'destroyPartner']);
});


Route::get('/website/contact', [ContactController::class, 'show']);

Route::prefix('website/admin')->group(function () {
    Route::get('/contact', [ContactController::class, 'adminIndex']);
    Route::post('/contact/update', [ContactController::class, 'update']);
});

Route::prefix('website')->group(function () {
    Route::post(
        '/contact-enquiries',
        [ContactEnquiryController::class, 'store']
    )->middleware('throttle:5,1');
});


Route::prefix('website/admin')->group(function () {
    Route::get(
        '/contact-enquiries',
        [ContactEnquiryController::class, 'index']
    );

    Route::get(
        '/contact-enquiries/{id}',
        [ContactEnquiryController::class, 'show']
    );

    Route::post(
        '/contact-enquiries/{id}/reply',
        [ContactEnquiryController::class, 'reply']
    );

    Route::delete(
        '/contact-enquiries/{id}',
        [ContactEnquiryController::class, 'destroy']
    );
});

Route::prefix('career')->group(function () {
    Route::get('/', [CareerController::class, 'show']);
});

Route::prefix('website/admin/career')->group(function () {
    Route::get('/', [CareerController::class, 'adminShow']);
    Route::post('/update', [CareerController::class, 'update']);
});



Route::prefix('home')->group(function () {
    Route::get('/', [
        WebsiteHomeSettingController::class,
        'index'
    ]);
});

Route::prefix('website/admin/home')->group(function () {
    Route::get('/', [
        WebsiteHomeSettingController::class,
        'adminShow'
    ]);

    Route::post('/update', [
        WebsiteHomeSettingController::class,
        'update'
    ]);
});