<?php
 
 use App\Http\Controllers\Staff\AttendanceReportController;
use App\Http\Controllers\Staff\CommunicateController;
use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\AssignmentController;
use App\Http\Controllers\Staff\ApplyLeaveController;
use App\Http\Controllers\Staff\ProfileController;
use App\Http\Controllers\Staff\DepartmentController;
use App\Http\Controllers\Staff\DesignationController;
use App\Http\Controllers\Staff\{StudentController,ExamScheduleController};  
 
use App\Http\Controllers\Staff\GradeController;
use App\Http\Controllers\Staff\StaffSessionController;
use App\Models\Academic\Semester;
use App\Models\Academic\YearStatus;
use App\Models\Session;

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
 
            // Assignment Module
            Route::prefix('assignment')->name('assignment.')->controller(AssignmentController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:assignment_read');
                Route::post('/store_assignment',  'store_assignment')->name('store_assignment')->middleware('PermissionCheck:assignment_create');
                Route::post('/upload-assignment-media',  'uploadAssignmentMedia')->name('uploadAssignmentMedia');
                Route::get('/get-assignment-media/{id}',  'getAssignementMedia')->name('getAssignementMedia');
                Route::get('/assignment-evaluation/{id}',  'assignmentEvaluation')->name('evaluateAssignment')->middleware('PermissionCheck:assignment_read');
                Route::post('/evaluate-assignment-save/{id}',  'saveAssignmentEvaluation')->name('evaluateAssignmentSave')->middleware('PermissionCheck:assignment_update');
                Route::get('/edit-assignment/{id}',  'editAssignment')->name('editAssignment')->middleware('PermissionCheck:assignment_update');
                Route::post('/update-assignment',  'updateAssignment')->name('updateAssignment')->middleware('PermissionCheck:assignment_update');
                Route::delete('/delete-assignment/{id}',  'deleteAssignment')->name('destroyAssignment')->middleware('PermissionCheck:assignment_delete');
    

            });

 
            Route::prefix('apply-leave')->name('apply-leave.')->controller(ApplyLeaveController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:apply_leave_read');
                Route::post('/', 'applyForLeave')->name('apply')->middleware('PermissionCheck:apply_leave_update');
                Route::get('/get-leave/{id}', 'showLeave')->name('get-leave')->middleware('PermissionCheck:apply_leave_read');
                Route::put('/update/{id}', 'updateLeave')->name('update')->middleware(['PermissionCheck:apply_leave_update']);
                Route::delete('/delete/{id}', 'deleteLeave')->name('delete')->middleware(['PermissionCheck:apply_leave_delete']);
            });
 
            Route::prefix('students')->name('students.')->controller(StudentController::class)->group(function () {
                Route::get('/', 'index')->name('index')->middleware('PermissionCheck:student_read');
                Route::get('/filter',  'Filter')->name('filter')->middleware('PermissionCheck:student_filter');
 
            });
 
            // Class & Exam Schedule
            Route::prefix('my-classes')->name('my-classes.')->controller(ExamScheduleController::class)->group(function () {
                Route::get('/exam-schedule', 'examSchedule')->name('exam-schedule')->middleware('PermissionCheck:exam_schedule_read');
                Route::get('/available-rooms', 'getAvailableRooms')->name('available-rooms')->middleware('PermissionCheck:exam_schedule_read');
                Route::post('/exam-request-store', 'store_exam_request')->name('store_exam_request')->middleware('PermissionCheck:exam_schedule_create');
 
                Route::get('/class-schedule', 'classSchedule')->name('class-schedule')->middleware('PermissionCheck:exam_schedule_read');
            });
        });

            
        Route::get('/staff/attendance', [AttendanceController::class, 'index'])->name('staff.attendance.index')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
        Route::post('/staff/attendance/load', [AttendanceController::class, 'loadAttendance'])->name('staff.attendance.load');
        Route::post('/staff/attendance/save', [AttendanceController::class, 'saveAttendance'])->name('staff.attendance.save');


        Route::get('/staff/report/attendance', [AttendanceReportController::class, 'index'])->name('staff.report.attendance.index')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
        Route::post('/staff/report/attendance/search', [AttendanceReportController::class, 'search'])->name('staff.report.attendance.search');
        Route::post('/staff/report/attendance/save-comment', [AttendanceController::class, 'saveComment'])->name('staff.report.attendance.save-comment');

        Route::get('/staff/grade/index', [GradeController::class, 'index'])->name('staff.grade.index')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
        Route::post('/staff/grade/assign-grades/filter', [GradeController::class, 'filterAssignGrades'])->name('staff.grade.assign-grades.filter');
        Route::post('/staff/grade/save-marks', [GradeController::class, 'saveMarks'])->name('staff.grade.save-marks');


        Route::get('/staff/communicate/index', [CommunicateController::class, 'index'])->name('staff.communicate.index')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
        Route::get('/staff/communicate/message/add', [CommunicateController::class, 'addMessage'])->name('staff.communicate.message.add')->middleware(['lang', 'CheckSubscription', 'FeatureCheck:staff_manage']);
        Route::post('/staff/communicate/messages/store', [CommunicateController::class, 'store'])->name('staff.communicate.messages.store');


        // For Global Session
        Route::get('/staff/session-data', function () {
            return response()->json([
                'years'     => Session::where('status', 1)
                                ->orderByDesc('end_date')
                                ->get(['id', 'name']),

                'semesters' => Semester::where('status', 1)
                                ->orderBy('id')
                                ->get(['id', 'name']),

                'statuses'  => YearStatus::select('id', 'name')
                                ->get(),

                'defaults'  => [
                    'session_id'       => currentSession()->session_id,
                    'session_name'     => currentSession()->session_name,
                    'semester_id'      => currentSession()->semester_id,
                    'semester_name'    => currentSession()->semester_name,
                    'year_status_id'   => currentSession()->year_status_id,
                    'year_status_name' => currentSession()->year_status_name,
                ]
            ]);
        })->name('staff.session.data');

        // 2. Auto-save selected session (called on every change)
        Route::post('/staff/set-session', [StaffSessionController::class, 'set'])->name('staff.set-session');
        

    });
});