<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/student/dashboard', function() {
    return 'Student Dashboard'; // Replace with actual view
})->middleware('auth:student')->name('student.dashboard');

Route::get('/teacher/dashboard', function() {
    return 'Teacher Dashboard'; // Replace with actual view
})->middleware('auth:teacher')->name('teacher.dashboard');


Route::get('/theme',function () {
    return view('pages.student.theme.index');
}) -> name('student.theme');

Route::get('/unit',function () {
    return view('pages.student.unit.index');
}) -> name('student.unit');

Route::get('/chapter',function () {
    return view('pages.student.chapter.index');
}) -> name('student.chapter');

Route::get('/week',function () {
    return view('pages.student.week.index');
}) -> name('student.week');

Route::get('/create_theme', function () {
    return view('pages.teacher.theme.create');
});

Route::get('/create_unit', function () {
    return view('pages.teacher.unit.create');
});

Route::get('/create_material', function () {
    return view('pages.teacher.material.create');
});

Route::get('/create_chapter', function () {
    return view('pages.teacher.chapter.create');
});

Route::get('/create_lesson', function () {
    return view('pages.teacher.lesson.create');
});


Route::get('/create_assignment', function () {
    return view('pages.teacher.Assignment.create');
});

