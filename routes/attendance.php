<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Attendance\AttendanceController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Attendance\AttendaceNotificationController;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:attendance']], function () {
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(AttendanceController::class)->prefix('attendance')->group(function () {

                    Route::get('/daily', 'dailyAttendance')->name('daily.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/daily/search','searchDaily')->name('daily.search')->middleware('PermissionCheck:attendance_read');
                    
                    Route::get('/monthly', 'monthlyAttendance')->name('monthly.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/monthly/search','searchMonthly')->name('monthly.search')->middleware('PermissionCheck:attendance_read');

                    Route::get('/total', 'totalAttendance')->name('total.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/total/search','searchTotal')->name('total.search')->middleware('PermissionCheck:attendance_read');

                    // Tracker
                    Route::get('/submission-tracker', 'submissionTracker')->name('submission-tracker.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/submission-tracker/search','submissionTrackerSearch')->name('submission-tracker.search')->middleware('PermissionCheck:attendance_read');

                    
                    // Student Report 
                    Route::get('/report/student', 'studentReport')->name('student-report.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/report/student-search','studentReportSearch')->name('student-report.search')->middleware('PermissionCheck:attendance_read');

                    // Class Report 
                    Route::get('/report/class', 'classReport')->name('class-report.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/report/class-search','classReportSearch')->name('class-report.search')->middleware('PermissionCheck:attendance_read');

                    // Student Attendance Summary
                    Route::get('/report/student-attendance-summary', 'studentAttendanceSummary')->name('student-attendance-summary.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/report/student-attendance-summary-search','studentAttendanceSummarySearch')->name('student-attendance-summary.search')->middleware('PermissionCheck:attendance_read');

                    //excessive absences report by student
                    Route::get('/report/excessive-student', 'excessiveAbsencesByStudent')->name('excessive.student.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/report/excessive-student/search', 'excessiveAbsencesByStudentSearch')->name('excessive.student.search')->middleware('PermissionCheck:attendance_read');

                    //excessive absences report by class
                    Route::get('/report/excessive-class', 'excessiveAbsencesByClass')->name('excessive.class.index')->middleware('PermissionCheck:attendance_read');
                    Route::post('/report/excessive-class/search', 'excessiveAbsencesByClassSearch')->name('excessive.class.search')->middleware('PermissionCheck:attendance_read');
        

                });

                Route::controller(AttendaceNotificationController::class)->prefix('attendance-notification')->group(function () {
                    Route::get('/', 'notification')->name('attendance.notification')->middleware('PermissionCheck:attendance_read');
                    Route::post('/update', 'settinngUpdate')->name('attendance.settinngUpdate')->middleware('PermissionCheck:attendance_read');

                });

            });
        });
    });
});


