<?php
 

use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\AssignmentController;
use App\Http\Controllers\Staff\ApplyLeaveController;
use App\Http\Controllers\Staff\ProfileController;
use App\Http\Controllers\Staff\DepartmentController;
use App\Http\Controllers\Staff\DesignationController;
use App\Http\Controllers\Staff\{StudentController,ExamScheduleController};   

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
        Route::middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage'])->group(function () {

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
                
            Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
            
            Route::get('/staff/attendance', [AttendanceController::class, 'index'])->name('staff.attendance.index')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
            Route::post('/staff/attendance/load', [AttendanceController::class, 'loadAttendance'])->name('staff.attendance.load');
            Route::post('/staff/attendance/save', [AttendanceController::class, 'saveAttendance'])->name('staff.attendance.save');

            });

        });

        Route::prefix('staff')->name('staff.')->middleware(['lang', 'CheckSubscription'])->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('FeatureCheck:staff_manage');

            // Profile Module
            Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:profile_read');
            });

            Route::prefix('assignment')->name('assignment.')->controller(AssignmentController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:assignment_read');
            });

            Route::prefix('apply-leave')->name('apply-leave.')->controller(ApplyLeaveController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:apply_leave_read');
            });

            Route::prefix('students')->name('students.')->controller(StudentController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:student_read');
                Route::get('/filter',  'Filter')->name('filter')->middleware('PermissionCheck:student_filter');

            });

            Route::prefix('my-classes')->name('my-classes.')->controller(ExamScheduleController::class)->group(function () {
                Route::get('/exam-schedule', 'examSchedule')->name('exam-schedule')->middleware('PermissionCheck:exam_schedule_read');
                Route::get('/available-rooms', 'getAvailableRooms')->name('available-rooms')->middleware('PermissionCheck:exam_schedule_read');
                Route::post('/exam-request-store', 'store_exam_request')->name('store_exam_request')->middleware('PermissionCheck:exam_schedule_create');

                Route::get('/class-schedule', 'classSchedule')->name('class-schedule')->middleware('PermissionCheck:exam_schedule_read');
            });
        });
    });
});