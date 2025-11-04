<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\GmeetController;
use App\Http\Controllers\Admin\IdCardController;
use App\Http\Controllers\Admin\HomeworkController;
use App\Http\Controllers\Admin\SmsMailLogController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\NoticeBoardController;
use App\Http\Controllers\Admin\ModuleInstallController;
use App\Http\Controllers\Admin\SmsMailTemplateController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\{GradeController,AlumniController,TeacherController,ApplicantController,RoomManagementController};



Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:account']], function () {
            // auth routes
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(HomeworkController::class)->group(function () {
                    Route::get('homework/',                 'index')->name('homework.index')->middleware('PermissionCheck:homework_read');
                    Route::any('homework/search',           'search')->name('homework.search')->middleware('PermissionCheck:homework_read');
                    Route::get('homework/create',           'create')->name('homework.create')->middleware('PermissionCheck:homework_create');
                    Route::post('homework/store',           'store')->name('homework.store')->middleware('PermissionCheck:homework_create', 'DemoCheck');
                    Route::get('homework/edit/{id}',        'edit')->name('homework.edit')->middleware('PermissionCheck:homework_update');
                    Route::put('homework/update/{id}',      'update')->name('homework.update')->middleware('PermissionCheck:homework_update', 'DemoCheck');
                    Route::delete('homework/delete/{id}',   'delete')->name('homework.delete')->middleware('PermissionCheck:homework_delete', 'DemoCheck');

                    Route::POST('homework/students',   'students');
                    Route::POST('homework/evaluation/submit',   'evaluationSubmit')->name('homework.evaluation.submit');
                });

                Route::controller(IdCardController::class)->group(function () {
                    Route::get('idcard/',                 'index')->name('idcard.index')->middleware('PermissionCheck:id_card_read');
                    Route::get('idcard/create',           'create')->name('idcard.create')->middleware('PermissionCheck:id_card_create');
                    Route::post('idcard/store',           'store')->name('idcard.store')->middleware('PermissionCheck:id_card_create');
                    Route::get('idcard/edit/{id}',           'edit')->name('idcard.edit')->middleware('PermissionCheck:id_card_update');
                    Route::put('idcard/update/{id}',           'update')->name('idcard.update')->middleware('PermissionCheck:id_card_update');
                    Route::delete('idcard/delete/{id}',   'delete')->name('idcard.delete')->middleware('PermissionCheck:id_card_delete', 'DemoCheck');

                    Route::POST('idcard/preview',   'preview');

                    Route::get('idcard/generate',                 'generate')->name('idcard.generate')->middleware('PermissionCheck:id_card_generate_read');
                    Route::post('idcard/generate',                 'generateSearch')->name('idcard.generate.search')->middleware('PermissionCheck:id_card_generate_read');
                });

                Route::controller(CertificateController::class)->group(function () {
                    Route::get('certificate/',                 'index')->name('certificate.index')->middleware('PermissionCheck:certificate_read');
                    Route::get('certificate/create',           'create')->name('certificate.create')->middleware('PermissionCheck:certificate_create');
                    Route::post('certificate/store',           'store')->name('certificate.store')->middleware('PermissionCheck:certificate_create');
                    Route::get('certificate/edit/{id}',           'edit')->name('certificate.edit')->middleware('PermissionCheck:certificate_update');
                    Route::put('certificate/update/{id}',           'update')->name('certificate.update')->middleware('PermissionCheck:certificate_update');
                    Route::delete('certificate/delete/{id}',   'delete')->name('certificate.delete')->middleware('PermissionCheck:certificate_delete', 'DemoCheck');

                    Route::POST('certificate/preview',   'preview');

                    Route::get('certificate/generate',                 'generate')->name('certificate.generate')->middleware('PermissionCheck:certificate_read');
                    Route::post('certificate/generate',                 'generateSearch')->name('certificate.generate.search')->middleware('PermissionCheck:certificate_read');
                });

                Route::controller(GmeetController::class)->group(function () {
                    Route::get('liveclass/gmeet/',                 'index')->name('gmeet.index')->middleware('PermissionCheck:gmeet_read');
                    Route::get('liveclass/gmeet/create',           'create')->name('gmeet.create')->middleware('PermissionCheck:gmeet_create');
                    Route::post('liveclass/gmeet/store',           'store')->name('gmeet.store')->middleware('PermissionCheck:gmeet_create');
                    Route::get('liveclass/gmeet/edit/{id}',        'edit')->name('gmeet.edit')->middleware('PermissionCheck:gmeet_update');
                    Route::put('liveclass/gmeet/update/{id}',      'update')->name('gmeet.update')->middleware('PermissionCheck:gmeet_update');
                    Route::delete('liveclass/gmeet/delete/{id}',   'delete')->name('gmeet.delete')->middleware('PermissionCheck:gmeet_delete', 'DemoCheck');

                    Route::any('liveclass/gmeet/search',           'search')->name('gmeet.search')->middleware('PermissionCheck:gmeet_read');
                });

                Route::controller(NoticeBoardController::class)->group(function () {
                    Route::get('communication/notice-board/',                 'index')->name('notice-board.index')->middleware('PermissionCheck:notice_board_read');
                    Route::get('communication/notice-board/create',           'create')->name('notice-board.create')->middleware('PermissionCheck:notice_board_create');
                    Route::post('communication/notice-board/store',           'store')->name('notice-board.store')->middleware('PermissionCheck:notice_board_create');
                    Route::get('communication/notice-board/edit/{id}',        'edit')->name('notice-board.edit')->middleware('PermissionCheck:notice_board_update');
                    Route::put('communication/notice-board/update/{id}',      'update')->name('notice-board.update')->middleware('PermissionCheck:notice_board_update');
                    Route::delete('communication/notice-board/delete/{id}',   'delete')->name('notice-board.delete')->middleware('PermissionCheck:notice_board_delete', 'DemoCheck');
                    Route::get('/translate/{id}',                'translate')->name('notice-board.translate')->middleware('PermissionCheck:notice_board_update');
                    Route::put('/translate/update/{id}',                'translateUpdate')->name('notice-board.translate.update')->middleware('PermissionCheck:notice_board_update');
                });

                Route::controller(SmsMailTemplateController::class)->group(function () {
                    Route::get('communication/template/',                 'index')->name('template.index')->middleware('PermissionCheck:sms_mail_template_read');
                    Route::get('communication/template/create',           'create')->name('template.create')->middleware('PermissionCheck:sms_mail_template_create');
                    Route::post('communication/template/store',           'store')->name('template.store')->middleware('PermissionCheck:sms_mail_template_create');
                    Route::get('communication/template/edit/{id}',        'edit')->name('template.edit')->middleware('PermissionCheck:sms_mail_template_update');
                    Route::put('communication/template/update/{id}',      'update')->name('template.update')->middleware('PermissionCheck:sms_mail_template_update');
                    Route::delete('communication/template/delete/{id}',   'delete')->name('template.delete')->middleware('PermissionCheck:sms_mail_template_delete', 'DemoCheck');
                });

                Route::controller(SmsMailLogController::class)->group(function () {
                    Route::get('communication/smsmail/',                 'index')->name('smsmail.index')->middleware('PermissionCheck:sms_mail_read_read');
                    Route::get('communication/smsmail/create',           'create')->name('smsmail.create')->middleware('PermissionCheck:sms_mail_read_send');
                    Route::post('communication/smsmail/store',           'store')->name('smsmail.store')->middleware('PermissionCheck:sms_mail_read_send');
                    Route::get('communication/smsmail/edit/{id}',        'edit')->name('smsmail.edit')->middleware('PermissionCheck:sms_mail_read_update');
                    Route::put('communication/smsmail/update/{id}',      'update')->name('smsmail.update')->middleware('PermissionCheck:sms_mail_read_update');
                    Route::delete('communication/smsmail/delete/{id}',   'delete')->name('smsmail.delete')->middleware('PermissionCheck:sms_mail_read_delete', 'DemoCheck');

                    Route::get('communication/smsmail/users',        'users')->name('smsmail.users')->middleware('PermissionCheck:sms_mail_read_read');
                    Route::get('communication/smsmail/template',        'template')->name('smsmail.template')->middleware('PermissionCheck:sms_mail_read_read');
                });

                Route::controller(ModuleInstallController::class)->group(function () {
                    Route::get('admin/module/install/{moduleName}', 'moduleInstall');
                });


                Route::controller(LeaveController::class)->group(function () {
                    // Student Leave
                    Route::get('leave/student', 'studentIndex')->name('leave.student.index')->middleware('PermissionCheck:student_leave_read');
                    Route::get('/leave/student/data', 'studentData')->name('leave.student.data')->middleware('PermissionCheck:student_leave_read');

                    // Teacher Leave
                    Route::get('leave/teacher', 'teacherIndex')->name('leave.teacher.index')->middleware('PermissionCheck:teacher_leave_read');
                    Route::get('/leave/teacher/data', 'teacherData')->name('leave.teacher.data')->middleware('PermissionCheck:teacher_leave_read');
                    Route::post('/admin/leave/teacher/update', 'updateTeacherLeave')->name('leave.teacher.update');

                    // Transcript
                    Route::get('transcript', 'transcriptIndex')->name('transcript.index')->middleware('PermissionCheck:transcript_read');
                    Route::get('transcript/data', 'transcriptData')->name('transcript.data')->middleware('PermissionCheck:transcript_read');
                    Route::post('transcript/update', 'updateTranscriptStatus')->name('transcript.update')->middleware('PermissionCheck:transcript_update');

                    // College
                    Route::get('college', 'collegeIndex')->name('transcript.college.index')->middleware('PermissionCheck:college_read');
                    Route::get('/transcript/college/data',  'collegeData')->name('transcript.college.data');
                    Route::post('/transcript/college/store', 'storeCollege')->name('transcript.college.store');
                });



                Route::controller(SubjectController::class)->group(function () {
                    Route::get('superadmin/subject', 'index')->name('superadmin.subject.index')->middleware('PermissionCheck:subject_read');
                    Route::get('superadmin/subject/view-details/{id}', 'viewSubjectDetails')->name('admin.subject.viewSubjectDetails')->middleware('PermissionCheck:subject_read');
                    Route::get('superadmin/subject/add', 'add')->name('superadmin.subject.add')->middleware('PermissionCheck:subject_read');
                    Route::post('superadmin/subject/store', 'store')->name('superadmin.subject.store')->middleware('PermissionCheck:subject_read');
                    Route::get('superadmin/subject/edit/{id}', 'edit')->name('superadmin.subject.edit')->middleware('PermissionCheck:subject_read');
                    Route::put('superadmin/subject/{id}', 'update')->name('superadmin.subject.update')->middleware('PermissionCheck:subject_read');
                });

                //Grade flow routes
                Route::controller(GradeController::class)->group(function () { // grade routes
                    Route::match(['GET','POST'],'grade_flow/', 'index')->name('grade_flow.index')->middleware('PermissionCheck:grade_read');
                    Route::get('grade_flow/assign_grade/', 'assign_grade')->name('grade_flow.assign_grade')->middleware('PermissionCheck:grade_read');
                    Route::post('grade_flow/assign_grade/', 'assign_grade_submit')->name('grade_flow.assign_grade')->middleware('PermissionCheck:grade_read');
 
 
                    Route::get('grade_flow/failing_grades/', 'failing_grades')->name('grade_flow.failing_grades')->middleware('PermissionCheck:grade_read');
                    Route::get('grade_flow/missing_grades/', 'missing_grades')->name('grade_flow.missing_grades')->middleware('PermissionCheck:grade_read');
                });

                //Alumni flow routes
                Route::controller(AlumniController::class)->group(function () { // alumni routes 
                    Route::get('alumni_flow/', 'index')->name('alumni_flow.index')->middleware('PermissionCheck:alumni_read');
                    Route::get('alumni_flow/alumni_info/{id}', 'alumni_list_info')->name('alumni_flow.alumni_list_info')->middleware('PermissionCheck:alumni_read');
                    Route::get('alumni_flow/gallery', 'gallery')->name('alumni_flow.alumni_gallery')->middleware('PermissionCheck:alumni_read');
                    Route::post('alumni_flow/alumni-gallery', 'store')->name('alumni_flow.gallery.store');
                    Route::get('alumni_flow/alumni-gallery/{id}/edit', 'edit')->name('alumni_flow.gallery.edit');
                    Route::post('alumni_flow/alumni-gallery/{id}/update', 'update')->name('alumni_flow.gallery.update');
                    Route::delete('alumni_flow/alumni-gallery/{id}', 'destroy')->name('alumni_flow.gallery.destroy');
                    Route::get('alumni_flow/alumni-gallery/download-all', 'downloadAll')->name('alumni_flow.gallery.download_all');
                    Route::get('alumni_flow/recorded-class', 'recorded_class')->name('alumni_flow.recorded_class')->middleware('PermissionCheck:alumni_read');
                    Route::get('alumni_flow/recorded-classes/{type}', 'getByType')->name('admin.recorded-classes.type');
                    Route::post('alumni_flow/recorded-classes/store', 'storeRecord')->name('admin.recorded-classes.store');
                    Route::post('alumni_flow/recorded-classes/{id}/update', 'update_record')->name('admin.recorded-classes.update');
                    Route::delete('alumni_flow/recorded-classes/{id}', 'destroy_record')->name('admin.recorded-classes.destroy');
                });

                //teacher  routes
                Route::controller(TeacherController::class)->prefix('teacher')->group(function () {
                    Route::get('/', 'index')->name('teacher.index')->middleware('PermissionCheck:teacher_read');
                    Route::get('/teacher-info/{id}', 'teacher_info')->name('teacher.teacher_info')->middleware('PermissionCheck:teacher_read');
                    Route::get('/create', 'create')->name('teacher.create')->middleware('PermissionCheck:teacher_read');
                    Route::post('/store', 'store')->name('teacher.store')->middleware('PermissionCheck:teacher_read');
                    Route::get('/edit/{id}', 'edit')->name('teacher.edit')->middleware('PermissionCheck:teacher_read');
                    Route::put('/update/{id}', 'update')->name('teacher.update')->middleware('PermissionCheck:teacher_read');
                    Route::delete('/delete/{id}', 'delete')->name('teacher.delete')->middleware('PermissionCheck:teacher_read');
                    Route::post('/teachers/{teacher}/inactive', 'toggleInactive')->name('teachers.toggleInactive')->middleware('PermissionCheck:teacher_read');
                    Route::get('/teachers/filter', 'filter')->name('teachers.filter')->middleware('PermissionCheck:teacher_read');
                });

                //room management routes
                Route::prefix('room-management')->controller(RoomManagementController::class)->group(function () {
                    Route::get('/', 'index')->name('room_management.index')->middleware('PermissionCheck:room_management_read');
                    Route::get('/room_availability', 'room_availability')->name('room_management.room_availability')->middleware('PermissionCheck:room_management_read');
                    Route::post('/', 'storeRoom')->name('room_management.store')->middleware('PermissionCheck:room_management_create');
                    Route::get('/{id}', 'show')->name('room_management.show')->middleware('PermissionCheck:room_management_read');
                    Route::put('/{id}', 'update')->name('room_management.update')->middleware('PermissionCheck:room_management_update');
                    Route::delete('/{id}', 'destroy')->name('room_management.destroy')->middleware('PermissionCheck:room_management_delete');
                });

                Route::controller(AssignmentController::class)->prefix('assignment')->group(function () {   //assignment routes
                    Route::get('assignment', 'index')->name('assignment.index')->middleware('PermissionCheck:assignment_read');
                    Route::get('assignment/{id}/details', 'assignment_details')->name('assignment.details')->middleware('PermissionCheck:assignment_read');
                    Route::get('assignment/{id}/evaluation_details', 'evaluation_details')->name('assignment.evalulation_details')->middleware('PermissionCheck:assignment_read');
                    Route::post('assignment/{id}/approve',  'approve_assignment')->name('assignment.approve_assignment')->middleware('PermissionCheck:assignment_read');
                    Route::post('assignment/{id}/reject',  'reject_assignment')->name('assignment.reject_assignment')->middleware('PermissionCheck:assignment_read');
                    Route::get('/assignment/filter', 'filter')->name('assignments.filter')->middleware('PermissionCheck:assignment_read');
                });

              //Applicant routes
                Route::controller(ApplicantController::class)->prefix('applicant')->group(function(){
                    Route::get('/student_application_form', 'student_application_form')->name('applicant.student_application_form')->middleware('PermissionCheck:applicant_read');
                    Route::get('/dashboard', 'dashboard')->name('applicant.dashboard')->middleware('PermissionCheck:applicant_read');
                    Route::get('/calender', 'calender')->name('applicant.calender')->middleware('PermissionCheck:applicant_read');
                    Route::get('/schedule-interview', 'schedule_interview')->name('applicant.schedule_interview')->middleware('PermissionCheck:applicant_read');
                    Route::get('/profile', 'profile')->name('applicant.profile')->middleware('PermissionCheck:applicant_read');
                    Route::get('/add-new-applicant', 'add_new_applicant')->name('applicant.add_new_applicant')->middleware('PermissionCheck:applicant_read');
                    Route::post('/store-applicant', 'store_applicant')->name('applicant.store_applicant')->middleware('PermissionCheck:applicant_read');
                    Route::get('/view-applicant-info/{id}', 'view_applicant_info')->name('applicant.view_applicant_info')->middleware('PermissionCheck:applicant_read');
                    Route::get('/edit-applicant', 'edit_applicant')->name('applicant.edit_applicant')->middleware('PermissionCheck:applicant_read');
                    Route::get('/custom-applicant-chart', 'custom_applicant_chart')->name('applicant.custom_applicant_chart')->middleware('PermissionCheck:applicant_read');
                    Route::get('/contacts', 'contacts')->name('applicant.contacts')->middleware('PermissionCheck:applicant_read');
                    Route::get('/contact-info', 'contact_info')->name('applicant.contact_info')->middleware('PermissionCheck:applicant_read');
                    Route::get('/application-form', 'application_form')->name('applicant.application_form')->middleware('PermissionCheck:applicant_read');
                    Route::get('/parent-contract', 'parent_contract')->name('applicant.parent_contract')->middleware('PermissionCheck:applicant_read');
                });

            });
        });
    });
});


Route::get('/storage-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    if (!file_exists($target)) {
        mkdir($target, 0777, true); // Auto create folder if missing
    }

    if (file_exists($link)) {
        return "Symlink already exists at $link";
    }

    symlink($target, $link);

    return "Storage link created successfully!";
});
