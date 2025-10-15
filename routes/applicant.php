<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ApplicantController;

Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:student_info']], function () {
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(ApplicantController::class)->prefix('applicant')->group(function () {
                    Route::post('/store',           'store')->name('applicant.store');
                });
            });
        });
    });
});


