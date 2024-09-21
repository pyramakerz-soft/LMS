<?php

use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\StageController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\ChapterController as ControllersChapterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UnitController as ControllersUnitController;
use App\Models\School;
use App\Models\Stage;
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

// Student dashboard route with 'auth:student' middleware
Route::get('/student/dashboard', [DashboardController::class, 'index'])->middleware('auth:student')->name('student.dashboard');

// Admin Controller 
Route::resource('material', MaterialController::class);
Route::resource('units', UnitController::class);
Route::resource('chapters', ChapterController::class);
Route::resource('lessons', LessonController::class);
Route::resource('stages', StageController::class);
Route::resource('assignments', AssignmentController::class);


Route::get('/api/schools/{school}/stages', function (School $school) {
    return response()->json($school->stages);
});

Route::get('/api/stages/{stage}/students', function (Stage $stage) {
    return response()->json($stage->students);
});
// Teacher dashboard route with 'auth:teacher' middleware
Route::get('/teacher/dashboard', function () {
    return 'Teacher Dashboard';
})->middleware('auth:teacher')->name('teacher.dashboard');

Route::get('/theme', [DashboardController::class, 'index'])->name('student.theme');


// Route::get('/unit', function () {
//     return view('pages.student.unit.index');
// })->name('student.unit');

Route::get('/materials/{materialId}/units', [ControllersUnitController::class, 'index'])->name('student_units.index');
Route::get('/units/{unitId}/chapters', [ControllersChapterController::class, 'index'])->name('student_chapters.index');


Route::get('/chapter', function () {
    return view('pages.student.chapter.index');
})->name('student.chapter');

Route::get('/week', function () {
    return view('pages.student.week.index');
})->name('student.week');

Route::get('/assignment', function () {
    return view('pages.student.assignment.index');
})->name('student.assignment');

Route::get('/assignment_show', function () {
    return view('pages.student.assignment.show');
})->name('student.assignment.show');

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

Route::prefix('teacher')->middleware('auth:teacher')->group(function () {
    Route::resource('assessments', StudentAssessmentController::class);
});
Route::get('/create_assignment', function () {
    return view('pages.teacher.Assignment.create');
})->name('teacher.Assignment.create');

Route::get('/view_assignment', function () {
    return view('pages.teacher.Assignment.index');
})->name('teacher.Assignment');

Route::get('/view_class', function () {
    return view('pages.teacher.Class.index');
})->name('teacher.class');

Route::get('/view_student_grade', function () {
    return view('pages.teacher.StudentGrades.index');
})->name('teacher.student.grade');

Route::get('/Show_Assignment', function () {
    return view('pages.teacher.Assignment.details');
})->name('teacher.assignment.show');

Route::get('/Edit_Assignment', function () {
    return view('pages.teacher.Assignment.Edit');
})->name('teacher.assignment.edit');

Route::get('/view_grades', function () {
    return view('pages.teacher.Grade.index');
})->name('teacher.grade');


Route::get('/view_material_in_grade', function () {
    return view('pages.teacher.material.index');
})->name('teacher.material');

Route::get('/view_teacher_theme', function () {
    return view('pages.teacher.theme.index');
})->name('teacher.theme');

Route::get('/view_teacher_unit', function () {
    return view('pages.teacher.unit.index');
})->name('teacher.unit');

Route::get('/view_chapter', function () {
    return view('pages.teacher.chapter.index');
})->name('teacher.chapter');

Route::get('/view_lesson', function () {
    return view('pages.teacher.lesson.index');
})->name('teacher.lesson');

Route::get('/view_assignments_cards', function () {
    return view('pages.teacher.AssignmentsCards.index');
})->name('teacher.assignments_cards');
// Route::group(['middleware' => ['admin:super_admin,school_admin']], function () {
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
// });
