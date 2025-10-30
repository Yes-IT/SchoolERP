<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\AccountController;
use App\Http\Controllers\Report\DueFeesController;
use App\Http\Controllers\Report\MarksheetController;
use App\Http\Controllers\Report\MeritListController;
use App\Http\Controllers\Report\ExamRoutineController;
use App\Http\Controllers\Report\ClassRoutineController;
use App\Http\Controllers\Report\ProgressCardController;
use App\Http\Controllers\Report\ProgressListController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Report\FeesCollectionController;
use App\Http\Controllers\Report\ReportManagementController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Report\AttendanceReportController;
use App\Http\Controllers\Report\StudentReportController;
use App\Http\Controllers\Report\TeacherReportController;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:report']], function () {
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {

                Route::controller(MarksheetController::class)->prefix('report-marksheet')->group(function () {
                    Route::get('/', 'index')->name('report-marksheet.index')->middleware('PermissionCheck:report_marksheet_read');
                    Route::post('/search', 'search')->name('marksheet.search')->middleware('PermissionCheck:report_marksheet_read');
                    Route::get('/get-students', 'getStudents');
                    Route::get('/pdf-generate/{id}/{type}/{class}/{section}', 'generatePDF')->name('report-marksheet.pdf-generate');
                });

                Route::controller(MeritListController::class)->prefix('report-merit-list')->group(function () {
                    Route::get('/', 'index')->name('report-merit-list.index')->middleware('PermissionCheck:report_merit_list_read');
                    Route::any('/search', 'search')->name('merit-list.search')->middleware('PermissionCheck:report_merit_list_read');
                    Route::get('/pdf-generate/{type}/{class}/{section}', 'generatePDF')->name('report-merit-list.pdf-generate');
                });

                Route::controller(ProgressCardController::class)->prefix('report-progress-card')->group(function () {
                    Route::get('/', 'index')->name('report-progress-card.index')->middleware('PermissionCheck:report_progress_card_read');
                    Route::post('/search', 'search')->name('report-progress-card.search');
                    Route::get('/get-students', 'getStudents');
                    Route::get('/pdf-generate/{class}/{section}/{student}', 'generatePDF')->name('report-progress-card.pdf-generate');
                });

                Route::controller(DueFeesController::class)->prefix('report-due-fees')->group(function () {
                    Route::get('/', 'index')->name('report-due-fees.index')->middleware('PermissionCheck:report_due_fees_read');
                    Route::any('/search', 'search')->name('due-fees.search')->middleware('PermissionCheck:report_due_fees_read');
                    Route::post('/pdf-generate', 'generatePDF')->name('report-due-fees.pdf-generate');
                });

                Route::controller(FeesCollectionController::class)->prefix('report-fees-collection')->group(function () {
                    Route::get('/', 'index')->name('report-fees-collection.index')->middleware('PermissionCheck:report_fees_collection_read');
                    Route::any('/search', 'search')->name('fees-collection.search')->middleware('PermissionCheck:report_fees_collection_read');
                    Route::get('/pdf-generate/{class}/{section}/{dates}', 'generatePDF')->name('report-fees-collection.pdf-generate');
                });

                Route::controller(AccountController::class)->prefix('report-account')->group(function () {
                    Route::get('/', 'index')->name('report-account.index')->middleware('PermissionCheck:report_account_read');
                    Route::any('/search', 'search')->name('account.search')->middleware('PermissionCheck:report_account_read');
                    Route::get('/get-account-types', 'getAccountTypes');
                    Route::post('/pdf-generate', 'generatePDF')->name('report-account.pdf-generate');
                });

                Route::controller(AttendanceController::class)->prefix('report-attendance')->group(function () {
                    Route::get('/report', 'report')->name('report-attendance.report')->middleware('PermissionCheck:report_attendance_read');
                    Route::any('/report-search', 'reportSearch')->name('report-attendance.report-search')->middleware('PermissionCheck:report_attendance_read');
                    Route::post('/pdf-generate', 'generatePDF')->name('report-attendance.pdf-generate');
                });

                Route::controller(ClassRoutineController::class)->prefix('report-class-routine')->group(function () {
                    Route::get('/', 'index')->name('report-class-routine.index')->middleware('PermissionCheck:report_class_routine_read');
                    Route::post('/search', 'search')->name('report-class-routine.search')->middleware('PermissionCheck:report_class_routine_read');
                    Route::get('/pdf-generate/{class}/{section}', 'generatePDF')->name('report-class-routine.pdf-generate');
                });

                Route::controller(ExamRoutineController::class)->prefix('report-exam-routine')->group(function () {
                    Route::get('/', 'index')->name('report-exam-routine.index')->middleware('PermissionCheck:report_exam_routine_read');
                    Route::post('/search', 'search')->name('report-exam-routine.search')->middleware('PermissionCheck:report_exam_routine_read');
                    Route::get('/pdf-generate/{class}/{section}/{type}', 'generatePDF')->name('report-exam-routine.pdf-generate');
                });

                Route::prefix('report-management')->group(function () {
                    Route::controller(ReportManagementController::class)->group(function () {
                        Route::get('/', 'index')->name('report-management.index');
                        Route::get('/general-student-report', 'generalStudentReport')->name('report-management.general-student-report');
                        Route::get('/teacher-report', 'teacherReport')->name('report-management.teacher-report');
                        Route::get('/alumni-report', 'alumniReport')->name('report-management.alumni-report');
                        Route::get('/attendance-report', 'attendanceReport')->name('report-management.attendance-report');
                        Route::get('/school-grade-report', 'schoolGradeReport')->name('report-management.attendance-grade-report');
                        Route::get('/class-report', 'classReport')->name('report-management.class-report');
                        Route::get('/applicant-report', 'applicantReport')->name('report-management.applicant-report');
                        Route::get('/tuition-report', 'tuitionReport')->name('report-management.tuition-report');
                    });
 
                    Route::controller(StudentReportController::class)->group(function () {
                        Route::post('/generate-student-pdf', 'generatePDF')->name('report-management.generate-student-pdf');
                        Route::post('/preview-student-report', 'previewReport')->name('report-management.preview-student-report');
                    });

                    Route::controller(TeacherReportController::class)->group(function () {
                        Route::post('/generate-teacher-pdf', 'generatePDF')->name('report-management.generate-teacher-pdf');
                        Route::post('/preview-teacher-report', 'previewReport')->name('report-management.preview-teacher-report');
                    });

                    Route::post('/attendance/reports/generate', [AttendanceReportController::class, 'generate'])->name('attendance.reports.generate');

 
                });

            });
        });
    });
});


