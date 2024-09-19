<?php

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

Route::get('/', function () {
    return view('pages.student.DashboardTheme');
});

Route::get('/login', function () {
    return view('pages.login.index');
});

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


// Route::group(['middleware' => ['admin:super_admin,school_admin']], function () {
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
// });
require __DIR__ . '/auth.php';
