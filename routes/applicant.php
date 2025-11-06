<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Applicant\ApplicantbhanuController;

Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:student_info']], function () {

            Route::controller(ApplicantController::class)->prefix('applicant')->group(function () {
                Route::get('/register', [ApplicantController::class, 'register'])->name('applicant.register');
                Route::get('/login', [ApplicantController::class, 'login'])->name('applicant.login');
                Route::get('applicant-forgot-password', [ApplicantController::class, 'forgot_password'])->name('applicant-forgot-password');
                Route::post('applicant-send-otp', [ApplicantController::class, 'send_otp'])->name('applicant-send-otp');
                Route::post('applicant-resend-otp', [ApplicantController::class, 'resend_otp'])->name('applicant-resend-otp');

                Route::get('applicant-verify-otp', [ApplicantController::class, 'verify_otp'])->name('applicant-verify-otp');
                Route::post('applicant-otp-verification', [ApplicantController::class, 'otp_verification'])->name('applicant-otp-verification');
                Route::get('applicant-update-password', [ApplicantController::class, 'applicant_update_password'])->name('applicant-update-password');


                Route::group(['middleware' => ['auth.routes']], function () {
                    Route::get('/process', [ApplicantController::class, 'process'])->name('applicant.process');
                    Route::get('/application', [ApplicantController::class, 'application'])->name('applicant.application');
                    Route::post('/application/form/save', [ApplicantController::class, 'applicationFormSave'])->name('applicant.application.form.save');
                    Route::post('/application/form/draft', [ApplicantController::class, 'applicationFormDraft'])->name('applicant.application.form.draft');
                    Route::get('/interview', [ApplicantController::class, 'interview'])->name('applicant.interview');
                    Route::get('/registration', [ApplicantController::class, 'registration'])->name('applicant.registration');
                    Route::get('/agreement', [ApplicantController::class, 'agreement'])->name('applicant.agreement');

                    Route::get('/applicant_profile', [ApplicantController::class, 'applicantProfile'])->name('applicant.profile');

                    Route::get('/application-bhanu', [ApplicantbhanuController::class, 'application'])->name('applicant.application.bhanu');
                    Route::post('/application/form/save-bhanu', [ApplicantbhanuController::class, 'applicationFormSave'])->name('applicant.application.form.save.bhanu');
                });
            });
        });
    });
});
