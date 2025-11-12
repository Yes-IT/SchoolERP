<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CounterController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Settings\GenderController;
use App\Http\Controllers\Academic\ClassesController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Settings\SessionController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MyProfileController;
use App\Http\Controllers\Settings\ReligionController;
use App\Http\Controllers\WebsiteSetup\AboutController;
use App\Http\Controllers\Settings\BloodGroupController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Backend\AuthenticationController;
use App\Http\Controllers\Backend\GeneralSettingController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Settings\NotificaticaSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(saasMiddleware())->group(function () {


    // Route::get('/', function () {
    //     return 'Landing Page';
    // });

    Route::get('generate-pdf', [PDFController::class, 'generatePDF']);

    Route::get('/mail-send', [App\Http\Controllers\HomeController::class, 'mail'])->name('mail');

    // Auth::routes();

    Route::get('/i-am-sure-to-reset-my-database', [ManagerController::class, 'index'])->name('i-am-sure-to-reset-my-database');




    Route::get('/i-am-sure-to-reset-my-database', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['XssSanitizer', 'lang']], function () {


        // Non-auth routes
        Route::group(['middleware' => ['not.auth.routes']], function () {
            // controller namespace
            Route::controller(AuthenticationController::class)->group(function () {

                // if (Config::get('app.APP_DEMO')) {
                //     Route::get('/', function () {
                //         return view('welcome');
                //     });
                // } else {
                //     Route::get('/','loginPage')->name('login');
                // }

                Route::get('login',                        'loginPage')->name('login')->middleware('throttle:web');
                // Route::get('login',                        'loginPage')->name('login.page');
                Route::post('login',                       'login')->name('login.auth');
                Route::get('register',                     'registerPage')->name('register.page');
                Route::post('register',                    'register')->name('register');
                Route::get('verify-email/{email}/{token}', 'verifyEmail')->name('verify-email');

                // reset password
                Route::get('forgot-password',               'forgotPasswordPage')->name('forgot-password');
                Route::post('forgot-password',              'forgotPassword')->name('forgot.password');

                Route::get('reset-password/{email}/{token}', 'resetPasswordPage')->name('reset-password');
                Route::post('reset-password',                'resetPassword')->name('reset.password');
            });
        });

        Route::group(['middleware' => ['CheckSubscription']], function () {

            Route::get('/migrate-seed', function () {
                \Artisan::call('migrate:fresh --seed');
                dd('success');
            });

            Route::get('/optimize', function () {
                \Artisan::call('optimize:clear');
                dd('success');
            });

            Route::controller(LanguageController::class)->prefix('languages')->group(function () {
                Route::get('/change',                   'changeLanguage')->name('languages.change');
            });

            //landing page
            Route::get('/landing', function () {
                return view('frontend-landing.school_landing');
            });


            // auth routes
            Route::group(['middleware' => ['auth.routes']], function () {
                Route::get('view-notification/{id}', [NotificaticaSettingController::class, 'viewNotification'])->name('viewNotification');



                // Route::post('logout',         [AuthenticationController::class, 'logout'])->name('logout');

                Route::group(['middleware' => 'AdminPanel'], function () {

                    // subscription routes
                    // Route::get('subscription',    [SubscriptionController::class, 'index'])->name('subscription');

                    // dashboard routes
                    Route::get('dashboard',                    [DashboardController::class, 'index'])->name('dashboard');
                    Route::get('fees-collection-monthly',      [DashboardController::class, 'feesCollectionMonthly']);
                    Route::get('revenue',                      [DashboardController::class, 'revenueYearly']);
                    Route::get('fees-collection-current-month',[DashboardController::class, 'feesCollectionCurrentMonth']);
                    Route::get('income-expense-current-month', [DashboardController::class, 'incomeExpenseCurrentMonth']);
                    Route::get('today-attendance',             [DashboardController::class, 'todayAttendance']);
                    Route::get('events-current-month',         [DashboardController::class, 'eventsCurrentMonth']);

                    Route::get('dashboard/school',[DashboardController::class, 'schoolDashboard'])->name('school_dashboard');
                    Route::get('dashboard/lms',   [DashboardController::class, 'lmsDashboard'])->name('lms_dashboard');
                    Route::get('dashboard/crm',   [DashboardController::class, 'crmDashboard'])->name('crm_dashboard');
                    Route::post('searchMenuData', [DashboardController::class, 'searchMenuData'])->name('searchMenuData');

                    Route::controller(RoleController::class)->middleware('FeatureCheck:staff_manage')->prefix('roles')->group(function () {
                        Route::get('/',                 'index')->name('roles.index')->middleware('PermissionCheck:role_read');
                        Route::get('/create',           'create')->name('roles.create')->middleware('PermissionCheck:role_create');
                        Route::post('/store',           'store')->name('roles.store')->middleware('PermissionCheck:role_create', 'DemoCheck');
                        Route::get('/edit/{id}',        'edit')->name('roles.edit')->middleware('PermissionCheck:role_update');
                        Route::put('/update/{id}',      'update')->name('roles.update')->middleware('PermissionCheck:role_update', 'DemoCheck');
                        Route::delete('/delete/{id}',   'delete')->name('roles.delete')->middleware('PermissionCheck:role_delete', 'DemoCheck');
                    });

                    Route::controller(GenderController::class)->prefix('genders')->group(function () {
                        Route::get('/',                 'index')->name('genders.index')->middleware('PermissionCheck:gender_read');
                        Route::get('/create',           'create')->name('genders.create')->middleware('PermissionCheck:gender_create');
                        Route::post('/store',           'store')->name('genders.store')->middleware('PermissionCheck:gender_create', 'DemoCheck');
                        Route::get('/edit/{id}',        'edit')->name('genders.edit')->middleware('PermissionCheck:gender_update');
                        Route::get('/translate/{id}',        'translate')->name('genders.translate')->middleware('PermissionCheck:gender_update');
                        Route::post('/translate_update/{id}',        'translateUpdate')->name('genders.translateUpdate')->middleware('PermissionCheck:gender_update');
                        Route::put('/update/{id}',      'update')->name('genders.update')->middleware('PermissionCheck:gender_update', 'DemoCheck');
                        Route::delete('/delete/{id}',   'delete')->name('genders.delete')->middleware('PermissionCheck:gender_delete', 'DemoCheck');
                    });

                    Route::controller(ReligionController::class)->prefix('religions')->group(function () {
                        Route::get('/',                 'index')->name('religions.index')->middleware('PermissionCheck:religion_read');
                        Route::get('/create',           'create')->name('religions.create')->middleware('PermissionCheck:religion_create');
                        Route::post('/store',           'store')->name('religions.store')->middleware('PermissionCheck:religion_create', 'DemoCheck');
                        Route::get('/edit/{id}',        'edit')->name('religions.edit')->middleware('PermissionCheck:religion_update');
                        Route::get('/translate/{id}',        'translate')->name('religions.translate')->middleware('PermissionCheck:gender_update');
                        Route::post('/translate_update/{id}',        'translateUpdate')->name('religions.translateUpdate')->middleware('PermissionCheck:gender_update');
                        Route::put('/update/{id}',      'update')->name('religions.update')->middleware('PermissionCheck:religion_update', 'DemoCheck');
                        Route::delete('/delete/{id}',   'delete')->name('religions.delete')->middleware('PermissionCheck:religion_delete', 'DemoCheck');
                    });

                    Route::controller(BloodGroupController::class)->prefix('blood-groups')->group(function () {
                        Route::get('/',                 'index')->name('blood-groups.index')->middleware('PermissionCheck:blood_group_read');
                        Route::get('/create',           'create')->name('blood-groups.create')->middleware('PermissionCheck:blood_group_create');
                        Route::post('/store',           'store')->name('blood-groups.store')->middleware('PermissionCheck:blood_group_create', 'DemoCheck');
                        Route::get('/edit/{id}',        'edit')->name('blood-groups.edit')->middleware('PermissionCheck:blood_group_update');
                        Route::put('/update/{id}',      'update')->name('blood-groups.update')->middleware('PermissionCheck:blood_group_update', 'DemoCheck');
                        Route::delete('/delete/{id}',   'delete')->name('blood-groups.delete')->middleware('PermissionCheck:blood_group_delete', 'DemoCheck');
                    });

                    Route::controller(SessionController::class)->prefix('sessions')->group(function () {
                        Route::get('/',                 'index')->name('sessions.index')->middleware('PermissionCheck:session_read');
                        Route::get('/create',           'create')->name('sessions.create')->middleware('PermissionCheck:session_create');
                        Route::post('/store',           'store')->name('sessions.store')->middleware('PermissionCheck:session_create', 'DemoCheck');
                        Route::get('/edit/{id}',        'edit')->name('sessions.edit')->middleware('PermissionCheck:session_update');
                        Route::get('/translate/{id}',        'translate')->name('sessions.translate')->middleware('PermissionCheck:session_update');
                        Route::post('/translateUpdate/{id}',        'translateUpdate')->name('sessions.translateUpdate')->middleware('PermissionCheck:session_update');
                        Route::put('/update/{id}',      'update')->name('sessions.update')->middleware('PermissionCheck:session_update', 'DemoCheck');
                        Route::delete('/delete/{id}',   'delete')->name('sessions.delete')->middleware('PermissionCheck:session_delete', 'DemoCheck');

                        Route::get('/change',           'changeSession')->name('sessions.change');
                    });

                    Route::controller(UserController::class)->middleware('FeatureCheck:staff_manage')->prefix('users')->group(function () {
                        Route::get('/',                 'index')->name('users.index')->middleware('PermissionCheck:user_read');
                        Route::get('/show/{id}',        'show')->name('users.show')->middleware('PermissionCheck:user_read');
                        Route::get('/create',           'create')->name('users.create')->middleware('PermissionCheck:user_create');
                        Route::post('/store',           'store')->name('users.store')->middleware('PermissionCheck:user_create', 'DemoCheck');
                        Route::get('/edit/{id}',        'edit')->name('users.edit')->middleware('PermissionCheck:user_update');
                        Route::put('/update/{id}',      'update')->name('users.update')->middleware('PermissionCheck:user_update', 'DemoCheck');
                        Route::delete('/delete/{id}',   'delete')->name('users.delete')->middleware('PermissionCheck:user_delete', 'DemoCheck');

                        Route::get('/change-role',      'changeRole')->name('change.role');
                        Route::post('/status',      'status')->name('users.status');
                        Route::delete('/{id}',      'deletes')->name('users.deletes');
                    });

                    Route::controller(MyProfileController::class)->prefix('my')->group(function () {
                        Route::get('/profile',              'profile')->name('my.profile');
                        Route::get('/profile/edit',         'edit')->name('my.profile.edit');
                        Route::put('/profile/update',       'update')->name('my.profile.update')->middleware('DemoCheck');

                        Route::get('/password/update',      'passwordUpdate')->name('passwordUpdate');
                        Route::put('/password/update/store', 'passwordUpdateStore')->name('passwordUpdateStore')->middleware('DemoCheck');
                    });

                    Route::controller(LanguageController::class)->middleware('FeatureCheck:language')->prefix('languages')->group(function () {
                        Route::get('/',                         'index')->name('languages.index')->middleware('PermissionCheck:language_read');
                        Route::get('/create',                   'create')->name('languages.create')->middleware('PermissionCheck:language_create');
                        Route::post('/store',                   'store')->name('languages.store')->middleware('PermissionCheck:language_create', 'DemoCheck');
                        Route::get('/edit/{id}',                'edit')->name('languages.edit')->middleware('PermissionCheck:language_update');
                        Route::put('/update/{id}',              'update')->name('languages.update')->middleware('PermissionCheck:language_update', 'DemoCheck');
                        Route::delete('/delete/{id}',           'delete')->name('languages.delete')->middleware('PermissionCheck:language_delete', 'DemoCheck');

                        Route::get('/terms/{id}',               'terms')->name('languages.edit.terms')->middleware('PermissionCheck:language_update_terms');
                        Route::put('/update/terms/{code}',      'termsUpdate')->name('languages.update.terms')->middleware('PermissionCheck:language_update_terms');
                        Route::get('/change-module',            'changeModule')->name('languages.change.module');
                    });


                    Route::controller(SettingController::class)->middleware('FeatureCheck:setting')->prefix('/')->group(function () {

                        Route::get('/general-settings',             'generalSettings')->name('settings.general-settings')->middleware('PermissionCheck:general_settings_read');
                        Route::post('/general-settings',            'updateGeneralSetting')->name('settings.general-settings.update')->middleware('PermissionCheck:general_settings_update', 'DemoCheck');

                        Route::get('/storage-setting',              'storagesetting')->name('settings.storagesetting')->middleware('PermissionCheck:storage_settings_read');
                        Route::put('/storage-setting-update',       'storageSettingUpdate')->name('settings.storageSettingUpdate')->middleware("PermissionCheck:storage_settings_update", 'DemoCheck');

                        Route::get('/recaptcha-setting',            'recaptchaSetting')->name('settings.recaptcha-setting')->middleware('PermissionCheck:recaptcha_settings_read');
                        Route::post('/recaptcha-setting',           'updateRecaptchaSetting')->name('settings.recaptcha-setting.update')->middleware('PermissionCheck:recaptcha_settings_update', 'DemoCheck');

                        Route::get('/sms-setting',            'smsSetting')->name('settings.sms-setting')->middleware('PermissionCheck:sms_settings_read');
                        Route::post('/sms-setting',           'updateSmsSetting')->name('settings.sms-setting.update')->middleware('PermissionCheck:sms_settings_update', 'DemoCheck');

                        Route::get('/payment-gateway-setting',      'paymentGatewaySetting')->name('settings.payment-gateway-setting')->middleware('PermissionCheck:payment_gateway_settings_read');
                        Route::post('/payment-gateway-setting',     'updatePaymentGatewaySetting')->name('settings.payment-gateway-setting')->middleware('PermissionCheck:payment_gateway_settings_update', 'DemoCheck');


                        Route::get('/email-setting',                 'mailSetting')->name('settings.mail-setting')->middleware('PermissionCheck:email_settings_read');
                        Route::post('/email-setting',                'updateMailSetting')->name('settings.mail-setting.update')->middleware('PermissionCheck:email_settings_update', 'DemoCheck');

                        //Theme Change
                        Route::post('/change-theme',                 'changeTheme')->name('changeTheme');

                        // task schedulers
                        Route::get('/task-schedulers',                'taskSchedulers')->name('settings.task-schedulers')->middleware('PermissionCheck:email_settings_update');
                        Route::get('/result-generate',                'resultGenerate')->name('settings.result-generate')->middleware('PermissionCheck:email_settings_update', 'DemoCheck');

                        // software update
                        Route::get('/software-update',                'softwareUpdate')->name('settings.software-update')->middleware('PermissionCheck:software_update_read');
                        Route::get('/install-update',                 'installUpdate')->name('settings.install-update')->middleware('PermissionCheck:software_update_update', 'DemoCheck');

                        Route::get('/general-settings/translate',                'translate')->name('settings.general-settings.translate')->middleware('PermissionCheck:general_settings_update');
                        Route::put('/general-settings/translate/update',                'translateUpdate')->name('settings.general-settings.translate.update')->middleware('PermissionCheck:general_settings_update');

                    });



                    Route::controller(NotificaticaSettingController::class)->middleware('FeatureCheck:setting')->prefix('/')->group(function () {

                        Route::get('/notification-settings',             'notificationSettings')->name('settings.notification-settings');
                        Route::post('/notification-settings',            'updateNotificationSetting')->name('settings.notification-settings.update')->middleware('PermissionCheck:general_settings_update', 'DemoCheck');
                        Route::get('/notification_event_modal/{id}/{key}',             'notificationEventModal')->name('settings.notification_event_modal');
                    });
                });
            });
        });
    });
});


Route::view('id_card/create', 'backend/id_card/create');
Route::view('id_card/list', 'backend/id_card/list');
Route::view('id_card/generate', 'backend/id_card/generate');

Route::view('certificate/create', 'backend/certificate/create');
Route::view('certificate/generate', 'backend/certificate/generate');
Route::view('certificate/list', 'backend/certificate/list');


Route::prefix('applicant')->group(function () {
    Route::view('/dashboard', 'backend.applicants.dashboard')->name('applicant.dashboard');
    Route::view('/profile', 'backend.applicants.profile')->name('applicant.profile');
    Route::view('/add', 'backend.applicants.add')->name('applicant.add');
    Route::view('/schedule_interview', 'backend.applicants.schedule-interview')->name('applicant.schedule-interview');
});

Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['lang', 'XssSanitizer', 'auth.routes']], function () {

        Route::post('logout',         [AuthenticationController::class, 'logout'])->name('logout');

        Route::group(['middleware' => 'AdminPanel'], function () {
            Route::get('subscription',    [SubscriptionController::class, 'index'])->name('subscription');
        });
    });
});


