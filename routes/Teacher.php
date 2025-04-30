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

        Route::get('/create', 'create')->name('create');

        Route::post('/store/step1', 'storeStep1')->name('store.step1');

        Route::get('/create/skills', 'createSkills')->name('create.skills');

        Route::post('/store/step2', 'storeStep2')->name('store.step2');

        Route::delete('/delete/{id}', 'delete')->name('delete');

        Route::put('/cancel/{id}', 'cancelCourse')->name('cancel');

        Route::get('/sub/category/{id}', 'getSubCategories')->name('sub.category');

        // Module management routes
        Route::get('/create/modules/{course_id}', 'createModules')->name('create.modules');

        Route::post('/store/modules', 'storeModules')->name('store.modules');
        
        // Video management routes
        Route::get('/module/{module_id}/videos', 'createModuleVideos')->name('module.videos');

        Route::post('/module/videos/store', 'storeModuleVideos')->name('module.videos.store');
        
        // Exam management routes
        Route::get('/module/{module_id}/exams', 'createModuleExams')->name('module.exams');

        Route::post('/module/exams/store', 'storeModuleExams')->name('module.exams.store');

        Route::get('/module/exam/{exam_id}/questions', 'showExamQuestions')->name('module.exam.questions');

        Route::post('/module/exam/questions/store', 'storeExamQuestions')->name('module.exam.questions.store');

        Route::get('/module/exam/question/{question_id}/edit', 'editExamQuestion')->name('module.exam.question.edit');

        Route::put('/module/exam/question/{question_id}', 'updateExamQuestion')->name('module.exam.question.update');

        Route::delete('/module/exam/question/{question_id}', 'deleteExamQuestion')->name('module.exam.question.delete');
        
        // Homework management routes

        Route::get('/module/{module_id}/homework', 'createModuleHomework')->name('module.homework');

        Route::post('/module/homework/store', 'storeModuleHomework')->name('module.homework.store');

        Route::get('/module/homework/{homework_id}/questions', 'showHomeworkQuestions')->name('module.homework.questions');
        
        Route::post('/module/homework/questions/store', 'storeHomeworkQuestions')->name('module.homework.questions.store');

        Route::get('/module/homework/question/{question_id}/edit', 'editHomeworkQuestion')->name('module.homework.question.edit');

        Route::put('/module/homework/question/{question_id}', 'updateHomeworkQuestion')->name('module.homework.question.update');

        Route::delete('/module/homework/question/{question_id}', 'deleteHomeworkQuestion')->name('module.homework.question.delete');

       // student course management routes
        Route::get('/students/list/{course_id}', 'studentsList')->name('students.list');
        
        Route::get('/students/search/{course_id}', 'studentsSearch')->name('students.search');

        Route::get('/student/chat/{course_id}/{student_id}', 'chat')->name('student.chat');
        
        Route::post('/student/chat/send', 'sendMessage')->name('student.chat.send');

        Route::get('/progress/course/{course_id}', 'progressCourse')->name('student.progress');

        Route::get('/broadcast/{course}', [App\Http\Controllers\CourseLiveBroadcastController::class, 'showBroadcastPage'])->name('broadcast');
        Route::post('/broadcast/{course}/schedule', [App\Http\Controllers\CourseLiveBroadcastController::class, 'scheduleBroadcast'])->name('broadcast.schedule');
        Route::post('/broadcast/{course}/start/{broadcast}', [App\Http\Controllers\CourseLiveBroadcastController::class, 'startBroadcast'])->name('broadcast.start');
        Route::post('/broadcast/{course}/end/{broadcast}', [App\Http\Controllers\CourseLiveBroadcastController::class, 'endBroadcast'])->name('broadcast.end');
        Route::post('/broadcast/{course}/save/{broadcast}', [App\Http\Controllers\CourseLiveBroadcastController::class, 'saveBroadcast'])->name('broadcast.save');
        Route::post('/broadcast/{course}/discard/{broadcast}', [App\Http\Controllers\CourseLiveBroadcastController::class, 'discardBroadcast'])->name('broadcast.discard');
    });
});
