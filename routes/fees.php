<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Fees\FeesTypeController;
use App\Http\Controllers\Fees\FeesGroupController;
use App\Http\Controllers\Fees\FeesAssignController;
use App\Http\Controllers\Fees\FeesMasterController;
use App\Http\Controllers\Fees\FeesCollectController;
use App\Http\Controllers\Fees\AdditionalFees\AdditionalFees;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:fees']], function () {
            // auth routes
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                // Route::controller(FeesGroupController::class)->prefix('fees-group')->group(function () {
                //     Route::get('/', 'index')->name('fees-group.index')->middleware('PermissionCheck:fees_group_read');
                //     Route::get('/create', action: 'create')->name('fees-group.create')->middleware('PermissionCheck:fees_group_create');
                //     Route::post('/store', 'store')->name('fees-group.store')->middleware('PermissionCheck:fees_group_create', 'DemoCheck');
                //     Route::get('/edit/{id}', 'edit')->name('fees-group.edit')->middleware('PermissionCheck:fees_group_update');
                //     Route::put('/update/{id}', 'update')->name('fees-group.update')->middleware('PermissionCheck:fees_group_update', 'DemoCheck');
                //     Route::delete('/delete/{id}', 'delete')->name('fees-group.delete')->middleware('PermissionCheck:fees_group_delete', 'DemoCheck');
                // });

                // Route::controller(FeesTypeController::class)->prefix('fees-type')->group(function () {
                //     Route::get('/', 'index')->name('fees-type.index')->middleware('PermissionCheck:fees_type_read');
                //     Route::get('/create', 'create')->name('fees-type.create')->middleware('PermissionCheck:fees_type_create');
                //     Route::post('/store', 'store')->name('fees-type.store')->middleware('PermissionCheck:fees_type_create', 'DemoCheck');
                //     Route::get('/edit/{id}', 'edit')->name('fees-type.edit')->middleware('PermissionCheck:fees_type_update');
                //     Route::put('/update/{id}', 'update')->name('fees-type.update')->middleware('PermissionCheck:fees_type_update', 'DemoCheck');
                //     Route::delete('/delete/{id}', 'delete')->name('fees-type.delete')->middleware('PermissionCheck:fees_type_delete', 'DemoCheck');
                // });

                Route::controller(FeesMasterController::class)->prefix('fees-master')->group(function () {
                    Route::get('/', 'index')->name('fees-master.index')->middleware('PermissionCheck:fees_master_read');
                    Route::get('/create', 'create')->name('fees-master.create')->middleware('PermissionCheck:fees_master_create');
                    Route::post('/store', 'store')->name('fees-master.store')->middleware('PermissionCheck:fees_master_create', 'DemoCheck');
                    Route::get('/edit/{id}', 'edit')->name('fees-master.edit')->middleware('PermissionCheck:fees_master_update');
                    Route::put('/update/{id}', 'update')->name('fees-master.update')->middleware('PermissionCheck:fees_master_update', 'DemoCheck');
                    Route::delete('/delete/{id}', 'delete')->name('fees-master.delete')->middleware('PermissionCheck:fees_master_delete', 'DemoCheck');
                    Route::get('/get-all-type', 'getAllTypes');
                });

                Route::controller(FeesAssignController::class)->prefix('fees-assign')->group(function () {
                    Route::get('/', 'index')->name('fees-assign.index')->middleware('PermissionCheck:fees_assign_read');
                    Route::get('/create', 'create')->name('fees-assign.create')->middleware('PermissionCheck:fees_assign_create');
                    Route::post('/store', 'store')->name('fees-assign.store')->middleware('PermissionCheck:fees_assign_create', 'DemoCheck');
                    // Route::get('/edit/{id}', 'edit')->name('fees-assign.edit')->middleware('PermissionCheck:fees_assign_update');
                    // Route::put('/fees-group/update/{id}', [FeesGroupController::class, 'update'])->name('fees-group.update');

                    Route::put('/update/{id}', 'update')->name('fees-assign.update')->middleware('PermissionCheck:fees_assign_update', 'DemoCheck');
                    Route::delete('/delete/{id}', 'delete')->name('fees-assign.delete')->middleware('PermissionCheck:fees_assign_delete', 'DemoCheck');
                    Route::get('/show', 'show');

                    Route::get('/get-all-type', 'getAllTypes');

                    Route::get('/get-fees-assign-students', 'getFeesAssignStudents');
                    Route::get('/import', 'import')->name('fees-assign.import')->middleware('PermissionCheck:fees_assign_create');
                    Route::post('/import-submit', 'importSubmit')->name('fees-fees-type.importSubmit')->middleware('PermissionCheck:fees_assign_create');
                    Route::get('/sample-download', 'sampleDownload')->name('fees-assign.sampleDownload')->middleware('PermissionCheck:fees_assign_create');
                });

                Route::controller(FeesCollectController::class)->prefix('fees-collect')->group(function () {
                    Route::get('/', 'index')->name('fees-collect.index')->middleware('PermissionCheck:fees_collect_read');
                    Route::get('/create', 'create')->name('fees-collect.create')->middleware('PermissionCheck:fees_collect_create');
                    Route::post('/store', 'store')->name('fees-collect.store')->middleware('PermissionCheck:fees_collect_create', 'DemoCheck');
                    Route::get('/edit/{id}', 'edit')->name('fees-collect.edit')->middleware('PermissionCheck:fees_collect_update');
                    Route::put('/update/{id}', 'update')->name('fees-collect.update')->middleware('PermissionCheck:fees_collect_update', 'DemoCheck');
                    Route::delete('/delete/{id}', 'delete')->name('fees-collect.delete')->middleware('PermissionCheck:fees_collect_delete', 'DemoCheck');
                    Route::get('/collect/{id}', 'collect')->name('fees-collect.collect')->middleware('PermissionCheck:fees_collect_update');


                    Route::any('/search', 'getFeesCollectStudents')->name('fees-collect-search');
                    Route::get('/fees-show', 'feesShow');
                });
                Route::controller(AdditionalFees::class)->prefix('additonal-fees')->group(function () {
                    Route::get('/', 'index')->name('additonal-fees.index');
                    // Route::get('/fees-group', 'groupshow')->name('fees-group.index')->middleware('PermissionCheck:fees_group_read');
                    // Route::get('fees-group/create', 'groupcreate')->name('fees-group.create')->middleware('PermissionCheck:fees_group_create');
                    // Route::post('fees-group/store', 'groupstore')->name('fees-group.store')->middleware('PermissionCheck:fees_group_create', 'DemoCheck');
                    // Route::get('fees-group/edit/{id}', 'groupedit')->name('fees-group.edit')->middleware('PermissionCheck:fees_group_update');
                    // Route::put('fees-group/update/{id}',  'groupupdate')->name('fees-group.update');

                    // Route::put('fees-group/update/{id}', 'groupupdate')->name('fees-group.update')->middleware('PermissionCheck:fees_group_update', 'DemoCheck');
                    // Route::delete('fees-group/delete/{id}', 'groupdelete')->name('fees-group.delete')->middleware('PermissionCheck:fees_group_delete', 'DemoCheck');
                    //   Route::get('/fees-type', 'feestypeshow')->name('fees-type.index')->middleware('PermissionCheck:fees_type_read');
                    // Route::get('fees-type/create', 'create')->name('fees-type.create')->middleware('PermissionCheck:fees_type_create');
                    // Route::post('fees-type/store', 'store')->name('fees-type.store')->middleware('PermissionCheck:fees_type_create', 'DemoCheck');
                    // // Route::get('fees-type/edit/{id}', 'edit')->name('fees-type.edit')->middleware('PermissionCheck:fees_type_update');
                    // Route::put('fees-type/update/{id}', 'update')->name('fees-type.update')->middleware('PermissionCheck:fees_type_update', 'DemoCheck');
                    // Route::delete('fees-type/delete/{id}', 'delete')->name('fees-type.delete')->middleware('PermissionCheck:fees_type_delete', 'DemoCheck');
                    // Route::get('/fees-master', 'feesmastershow')->name('fees-master.index')->middleware('PermissionCheck:fees_master_read');
                    // Route::get('fees-master/create', 'create')->name('fees-master.create')->middleware('PermissionCheck:fees_master_create');
                    // Route::post('fees-master/store', 'store')->name('fees-master.store')->middleware('PermissionCheck:fees_master_create', 'DemoCheck');
                    // Route::get('fees-master/edit', 'feesmasteredit')->name('fees-master.edit')->middleware('PermissionCheck:fees_master_update');
                    // Route::put('fees-master/update/{id}', 'update')->name('fees-master.update')->middleware('PermissionCheck:fees_master_update', 'DemoCheck');
                    // Route::delete('fees-master/delete/{id}', 'delete')->name('fees-master.delete')->middleware('PermissionCheck:fees_master_delete', 'DemoCheck');
                    // Route::get('fees-master/get-all-type', 'getAllTypes');
                    //  Route::get('fees-master/installment', 'installment')->name('fees-master.installment')->middleware('PermissionCheck:fees_master_update', 'DemoCheck');
                     Route::get('/fees-assign', 'feesAssign')->name('fees-assign.show')->middleware('PermissionCheck:fees_assign_read');
                    Route::get('/create', 'create')->name('fees-assign.create')->middleware('PermissionCheck:fees_assign_create');
                    Route::post('fees-assign/store', 'store')->name('fees-assign.store')->middleware('PermissionCheck:fees_assign_create', 'DemoCheck');
                    Route::get('fees-assign/edit/{id}', 'edit')->name('fees-assign.edit')->middleware('PermissionCheck:fees_assign_update');
                    Route::put('fees-assign/update/{id}', 'update')->name('fees-assign.update')->middleware('PermissionCheck:fees_assign_update', 'DemoCheck');
                    Route::delete('fees-assign/delete/{id}', 'delete')->name('fees-assign.delete')->middleware('PermissionCheck:fees_assign_delete', 'DemoCheck');
                    Route::get('fees-assign/show', 'show');

                    Route::get('fees-assign/get-all-type', 'getAllTypes');

                    Route::get('fees-assign/get-fees-assign-students', 'getFeesAssignStudents');
                    Route::get('fees-assign/import', 'import')->name('fees-assign.import')->middleware('PermissionCheck:fees_assign_create');
                    Route::post('fees-assign/import-submit', 'importSubmit')->name('fees-fees-type.importSubmit')->middleware('PermissionCheck:fees_assign_create');
                    Route::get('fees-assign/sample-download', 'sampleDownload')->name('fees-assign.sampleDownload')->middleware('PermissionCheck:fees_assign_create');
                    Route::get('/fees-status', 'feesStatus')->name('fees-status.show')->middleware('PermissionCheck:fees_assign_read');

                });

                Route::get('/fees-group', [FeesGroupController::class, 'index']) ->name('fees-group.index');
                 Route::get('fees-group/create', action: [FeesGroupController::class, 'create'])->name('fees-group.create')->middleware('PermissionCheck:fees_group_create');
                    Route::post('fees-group/store', [FeesGroupController::class, 'store'])->name('fees-group.store')->middleware('PermissionCheck:fees_group_create', 'DemoCheck');
                    Route::get('fees-group/edit/{id}', [FeesGroupController::class, 'edit'])->name('fees-group.edit')->middleware('PermissionCheck:fees_group_update');
                    Route::put('fees-group/update/{id}', [FeesGroupController::class, 'update'])->name('fees-group.update')->middleware('PermissionCheck:fees_group_update', 'DemoCheck');
                    Route::delete('fees-group/delete/{id}', [FeesGroupController::class, 'delete'])->name('fees-group.delete')->middleware('PermissionCheck:fees_group_delete', 'DemoCheck');
                    Route::get('fees-group/search', [FeesGroupController::class, 'search']) ->name('fees-group.search')->middleware('PermissionCheck:fees_group_view');
                   Route::get('/fees-type', [FeesTypeController::class, 'index'])->name('fees-type.index')->middleware('PermissionCheck:fees_type_read');
                    Route::get('fees-type/create', [FeesTypeController::class, 'create'])->name('fees-type.create')->middleware('PermissionCheck:fees_type_create');
                    Route::post('fees-type/store', [FeesTypeController::class, 'store'])->name('fees-type.store')->middleware('PermissionCheck:fees_type_create', 'DemoCheck');
                    Route::get('fees-type/edit/{id}', [FeesTypeController::class, 'edit'])->name('fees-type.edit')->middleware('PermissionCheck:fees_type_update');
                    Route::post('fees-type/update', [FeesTypeController::class, 'update'])->name('fees-type.update')->middleware('PermissionCheck:fees_type_update', 'DemoCheck');
                    Route::delete('fees-type/delete/{id}', [FeesTypeController::class, 'delete'])->name('fees-type.delete')->middleware('PermissionCheck:fees_type_delete', 'DemoCheck');
                  
                   Route::get('fees-type/filter', [FeesTypeController::class, 'filter'])->name('fees-type.filter');
                   Route::get('/fees-types/search', [FeesTypeController::class, 'search'])->name('fees-types.search');

                     Route::get('/fees-master', [FeesMasterController::class, 'index'])->name('fees-master.index')->middleware('PermissionCheck:fees_master_read');
                    Route::get('fees-master/create', [FeesMasterController::class, 'create'])->name('fees-master.create')->middleware('PermissionCheck:fees_master_create');
                    Route::post('fees-master/store', [FeesMasterController::class, 'store'])->name('fees-master.store')->middleware('PermissionCheck:fees_master_create', 'DemoCheck');
                    Route::get('fees-master/edit/{id}', [FeesMasterController::class, 'edit'])->name('fees-master.edit')->middleware('PermissionCheck:fees_master_update');
                    Route::put('fees-master/update/{id}', [FeesMasterController::class, 'update'])->name('fees-master.update')->middleware('PermissionCheck:fees_master_update', 'DemoCheck');
                    Route::delete('fees-master/delete/{id}', [FeesMasterController::class, 'delete'])->name('fees-master.delete')->middleware('PermissionCheck:fees_master_delete', 'DemoCheck');
                    Route::get('fees-master/get-all-type', [FeesMasterController::class, 'getAllTypes']);
                    Route::get('/fees-masters/search', [FeesMasterController::class, 'search']) ->name('fees-master.search');
   





                    



    



                
            });
        });
    });
});


