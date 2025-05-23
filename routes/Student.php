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

        route::get('/module/{id}', [CourseController::class , 'CourseModule'])->name('module');

        Route::get('/content/{id}', [CourseController::class, 'courseContent'])->name('content');

        //========================== Live Broadcast ==========================
        Route::get('/{course_id}/broadcast/{broadcast}', [CourseController::class, 'watchBroadcast'])->name('broadcast.watch');
        Route::get('/{course_id}/broadcast/{broadcast}/status', [CourseController::class, 'getBroadcastStatus'])->name('broadcast.status');

        //========================== chat with teacher ==========================
        Route::get('/chat/{course_id}/{teacher_id}',[CourseController::class,'chat'])->name('chat');

        Route::post('/chat/send', [CourseController::class,'sendMessage'])->name('chat.send');


        //========================== show Video ===================================


        Route::get('/{course_id}/videos/{id}', [CourseController::class, 'videoShow'])->name('video.show');
        Route::post('/{course_id}/videos/{id}/complete', [CourseController::class, 'markVideoComplete'])->name('video.complete');

        //========================= Show Exam =========================================

        Route::get('/{course_id}/exam/{id}',[CourseController::class , 'examShow'])->name('exam.show');

        Route::post('/exam/{id}/submit', [CourseController::class, 'submitExam'])->name('exam.submit');

        //========================= Show Homework =========================================

        Route::get('/{course_id}/homework/{id}', [CourseController::class, 'homeworkShow'])->name('homework.show');
        Route::post('/homework/{id}/submit', [CourseController::class, 'submitHomework'])->name('homework.submit');
    });
});
