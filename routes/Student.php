<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\student\StudentAuthController;
use App\Http\Controllers\Student\Course\CourseController;

Route::get('student/login' , action: [StudentAuthController::class , 'loginPage'])->name('student.login.page');

Route::post('student/login/check' , action: [StudentAuthController::class , 'login'])->name('student.login');

Route::get('student/register' , action: [StudentAuthController::class , 'registerPage'])->name('student.register.page');

Route::post('student/register/check' , action: [StudentAuthController::class , 'register'])->name('student.register');

Route::group(['prefix' => 'student', 'middleware' => ['student.auth'], 'as' => 'student.'], function () {

    Route::get('/logout', [StudentAuthController::class, 'logout'])->name('logout');

    //============================== Course Route ==========================
    Route::group(['prefix' => 'course', 'as' => 'course.'], function () {

        Route::get('/details/{id}', [CourseController::class, 'courseDetails'])->name('details')->withoutMiddleware('student.auth');

        Route::post('/register/{id}', [CourseController::class, 'register'])->name('register');

        Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('myCourses');

        route::get('my-courses/vedio/{id}', [CourseController::class , 'CourseVedio'])->name('myCourse.vedio');

    });
});
