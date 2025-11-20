<?php

use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\DepartmentController;
use App\Http\Controllers\Staff\DesignationController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Staff / Tenant Routes
|--------------------------------------------------------------------------
*/
Route::middleware([ 'web',])->group(function () {

    // Apply these to ALL staff panel routes
    Route::middleware(saasMiddleware()) // your custom SAAS middleware stack
        ->middleware('XssSanitizer')
        ->group(function () {

            // All staff management features (departments, designations, etc.)
            Route::middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage'])
                ->group(function () {

                    // Authenticated admin routes (your custom guard/middleware)
                    Route::middleware(['auth.routes', 'AdminPanel'])->group(function () {

                        // Departments
                        Route::prefix('department')->name('department.')->controller(DepartmentController::class)->group(function () {
                            Route::get('/', 'index')->name('index')->middleware('PermissionCheck:department_read');
                            Route::get('/create', 'create')->name('create')->middleware('PermissionCheck:department_create');
                            Route::post('/store', 'store')->name('store')->middleware(['PermissionCheck:department_create', 'DemoCheck']);
                            Route::get('/edit/{id}', 'edit')->name('edit')->middleware('PermissionCheck:department_update');
                            Route::put('/update/{id}', 'update')->name('update')->middleware(['PermissionCheck:department_update', 'DemoCheck']);
                            Route::delete('/delete/{id}', 'delete')->name('delete')->middleware(['PermissionCheck:department_delete', 'DemoCheck']);
                        });

                        // Designations
                        Route::prefix('designation')->name('designation.')->controller(DesignationController::class)->group(function () {
                            Route::get('/', 'index')->name('index')->middleware('PermissionCheck:designation_read');
                            Route::get('/create', 'create')->name('create')->middleware('PermissionCheck:designation_create');
                            Route::post('/store', 'store')->name('store')->middleware(['PermissionCheck:designation_create', 'DemoCheck']);
                            Route::get('/edit/{id}', 'edit')->name('edit')->middleware('PermissionCheck:designation_update');
                            Route::put('/update/{id}', 'update')->name('update')->middleware(['PermissionCheck:designation_update', 'DemoCheck']);
                            Route::delete('/delete/{id}', 'delete')->name('delete')->middleware(['PermissionCheck:designation_delete', 'DemoCheck']);
                        });

                        
                    });
                });

                
            Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
            
            Route::get('/staff/attendance', [AttendanceController::class, 'index'])->name('staff.attendance.index')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
            Route::post('/staff/attendance/load', [AttendanceController::class, 'loadAttendance'])->name('staff.attendance.load');
            Route::post('/staff/attendance/save', [AttendanceController::class, 'saveAttendance'])->name('staff.attendance.save');


        });
});