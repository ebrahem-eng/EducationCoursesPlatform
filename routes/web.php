<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\teacher\Course\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\Course\CourseController as StudentCourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::get('/', [StudentCourseController::class, 'search'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Course search route
Route::get('/courses/search', [StudentCourseController::class, 'search'])->name('course.search');

// Course progress routes
Route::middleware(['auth:student'])->group(function () {
    Route::post('/courses/videos/{id}/complete', [StudentCourseController::class, 'markVideoComplete'])->name('course.video.complete');
    Route::post('/courses/homework/{id}/submit', [StudentCourseController::class, 'submitAssignment'])->name('course.homework.submit');
    Route::post('/courses/exams/{id}/submit', [StudentCourseController::class, 'submitExam'])->name('course.exam.submit');
});

require __DIR__.'/auth.php';
