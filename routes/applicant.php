<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ApplicantController;

Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:student_info']], function () {

            Route::controller(ApplicantController::class)->prefix('applicant')->group(function () {
                Route::get('/register', [ApplicantController::class, 'register'])->name('applicant.register');
                Route::get('/login', [ApplicantController::class, 'login'])->name('applicant.login');
                Route::group(['middleware' => ['auth.routes']], function () {
                    Route::get('/process', [ApplicantController::class, 'process'])->name('applicant.process');
                    Route::get('/application', [ApplicantController::class, 'application'])->name('applicant.application');
                    Route::get('/interview', [ApplicantController::class, 'interview'])->name('applicant.interview');
                    Route::get('/registration', [ApplicantController::class, 'registration'])->name('applicant.registration');
                });
            });
        });
    });
});
