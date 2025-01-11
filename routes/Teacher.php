<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\teacher\TeacherAuthController;

use App\Http\Controllers\teacher\TeacherController;


Route::get('teacher/login' , action: [TeacherAuthController::class , 'loginPage'])->name('teacher.login.page');

Route::post('teacher/login/check' , action: [TeacherAuthController::class , 'login'])->name('teacher.login');

Route::group(['prefix' => 'teacher', 'middleware' => ['teacher.auth'], 'as' => 'teacher.'], function () {

    Route::get('/logout', [TeacherAuthController::class, 'logout'])->name('logout');

    //=================================== Dashboard Route =============================

    Route::get('/dashboard', [TeacherController::class, 'index'])->name('dashboard');

    //=================================== Courses Route =============================

    Route::group(['prefix' => 'course', 'as' => 'course.', 'controller' => \App\Http\Controllers\teacher\Course\CourseController::class], function () {

        Route::get('/index', 'index')->name('index');

    });
});
