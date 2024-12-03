<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\Teacher\TeacherController;

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


});
