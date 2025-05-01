<?php

use App\Http\Controllers\admin\Course\CourseController;
use App\Http\Controllers\admin\Student\StudentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\Teacher\TeacherController;
use App\Http\Controllers\admin\Skill\SkillController;
use App\Http\Controllers\admin\Company\CompanyController;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/

//=================================== Login Route =============================

Route::get('admin/login' , [\App\Http\Controllers\admin\AdminAuthController::class , 'loginPage'])->name('admin.login.page');

Route::post('admin/login/check' , [\App\Http\Controllers\admin\AdminAuthController::class , 'login'])->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => ['admin.auth'], 'as' => 'admin.'], function () {

    Route::get('/logout', [\App\Http\Controllers\admin\AdminAuthController::class, 'logout'])->name('logout');

    //=================================== Dashboard Route =============================

    Route::get('/dashboard', [\App\Http\Controllers\admin\AdminController::class, 'index'])->name('dashboard');


    //=================================== Teacher Route =============================

    Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'controller' => TeacherController::class], function () {

        Route::get('/index', 'index')->name('index');

        Route::get('/create', 'create')->name('create');

        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{id}', 'edit')->name('edit');

        Route::put('/update/{id}', 'update')->name('update');

        Route::get('/archive', 'archive')->name('archive');

        Route::delete('/softDelete/{id}', 'softDelete')->name('soft.delete');

        Route::delete('/forceDelete/{id}', 'forceDelete')->name('force.delete');

        Route::post('/restore/{id}', 'restore')->name('restore');
    });


    //=================================== Category Route =============================

    Route::group(['prefix' => 'category', 'as' => 'category.', 'controller' => \App\Http\Controllers\admin\Category\CategoryController::class], function () {

        Route::get('/index', 'index')->name('index');

        Route::get('/sub-category/index', 'subCategoryIndex')->name('sub.category.index');

        Route::get('/create', 'create')->name('create');

        Route::get('sub-category/create', 'subCategoryCreate')->name('sub.category.create');

        Route::post('/store', 'store')->name('store');

        Route::post('/sub-category/store', 'subCategoryStore')->name('sub.category.store');

        Route::get('/edit/{id}', 'edit')->name('edit');

        Route::get('/sub-category/edit/{id}', 'subCategoryEdit')->name('sub.category.edit');

        Route::put('/update/{id}', 'update')->name('update');

        Route::put('/sub-category/update/{id}', 'subCategoryUpdate')->name('sub.category.update');

        Route::get('/archive', 'archive')->name('archive');

        Route::get('sub/category/archive', 'subCategoryArchive')->name('sub.category.archive');

        Route::delete('/softDelete/{id}', 'softDelete')->name('soft.delete');

        Route::delete('/forceDelete/{id}', 'forceDelete')->name('force.delete');

        Route::get('/restore/{id}', 'restore')->name('restore');
    });


    //=================================== Student Route =============================

    Route::group(['prefix' => 'student', 'as' => 'student.', 'controller' => StudentController::class], function () {

        Route::get('/index', 'index')->name('index');

        Route::get('/create', 'create')->name('create');

        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{id}', 'edit')->name('edit');

        Route::put('/update/{id}', 'update')->name('update');

        Route::get('/archive', 'archive')->name('archive');

        Route::delete('/softDelete/{id}', 'softDelete')->name('soft.delete');

        Route::delete('/forceDelete/{id}', 'forceDelete')->name('force.delete');

        Route::post('/restore/{id}', 'restore')->name('restore');
    });


    //=================================== Course Route =============================

    Route::group(['prefix' => 'course', 'as' => 'course.', 'controller' => CourseController::class], function () { 

        Route::get('/publishedCourse', 'publishedCourse')->name('publishedCourse');

        Route::get('/requestPublishCourse', 'requestPublishCourse')->name('requestPublishCourse');

        Route::put('/update_status/{id}','updateStatus')->name('update_status');

        Route::put('/change-published-status/{id}', 'changePublishedCourse')->name('change_published_status');

        Route::put('/reject/{id}','rejectCourse')->name('rejectCourse');

    });

     //=================================== Skills Route =============================

     Route::group(['prefix' => 'skill', 'as' => 'skill.', 'controller' => SkillController::class], function () { 

        Route::get('/index', 'index')->name('index');

        Route::get('/create', 'create')->name('create');

        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{id}', 'edit')->name('edit');

        Route::put('/update/{id}', 'update')->name('update');

        Route::delete('/delete/{id}' , 'delete')->name('delete'); 


    });

    //=================================== Company Route =============================

    Route::group(['prefix' => 'company', 'as' => 'company.', 'controller' => CompanyController::class], function () {

        Route::get('/index', 'index')->name('index');

        Route::get('/create', 'create')->name('create');

        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{id}', 'edit')->name('edit');

        Route::put('/update/{id}', 'update')->name('update');

        Route::delete('/delete/{id}' , 'delete')->name('delete'); 
        
    });
        

});
