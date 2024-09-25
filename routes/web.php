<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\StageController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\ChapterController as ControllersChapterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherUnitController;
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
Route::get('/', function () {
    return view('landing'); // Displays the landing page
})->name('landing');



Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Admin Controller 
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('stage/{stageId}/material/create', [StageController::class, 'createMaterial'])->name('material.unit.chapter.create');

        Route::resource('material', MaterialController::class);
        Route::resource('units', UnitController::class);
        Route::resource('chapters', ChapterController::class);
        Route::resource('lessons', LessonController::class);
        Route::resource('stages', StageController::class);
        Route::resource('assignments', AssignmentController::class);
        Route::resource('ebooks', EbookController::class);
        Route::get('/lessons/{lesson}/view', [LessonController::class, 'viewEbook'])->name('lesson.view');

        Route::resource('students', StudentController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('admins', AdminController::class);

        Route::get('school/{schoolId}/curriculum', [AdminController::class, 'assignCurriculum'])->name('school.curriculum.assign');
        Route::post('school/{schoolId}/curriculum', [AdminController::class, 'storeCurriculum'])->name('school.curriculum.store');
        Route::get('school/{schoolId}/curriculum/view', [AdminController::class, 'viewCurriculum'])->name('school.curriculum.view');
        Route::delete('/schools/{schoolId}/stages/{stageId}', [AdminController::class, 'removeStage'])->name('school.removeStage');
        Route::delete('/schools/{schoolId}/materials/{materialId}', [AdminController::class, 'removeMaterial'])->name('school.removeMaterial');
        Route::delete('/schools/{schoolId}/units/{unitId}', [AdminController::class, 'removeUnit'])->name('school.removeUnit');
        Route::delete('/schools/{schoolId}/chapters/{chapterId}', [AdminController::class, 'removeChapter'])->name('school.removeChapter');
        Route::delete('/schools/{schoolId}/lessons/{lessonId}', [AdminController::class, 'removeLesson'])->name('school.removeLesson');

        // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/api/schools/{school}/stages', function (School $school) {
            return response()->json($school->stages);
        });

        Route::get('/api/stages/{stage}/students', function (Stage $stage) {
            return response()->json($stage->students);
        });
    });
});








Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Student dashboard route with 'auth:student' middleware
Route::get('/student/dashboard', [DashboardController::class, 'index'])->middleware('auth:student')->name('student.dashboard');



// Start student  dashboard routes

Route::get('/theme', [DashboardController::class, 'index'])->name('student.theme');
Route::get('/materials/{materialId}/units', [ControllersUnitController::class, 'index'])->name('student_units.index');
Route::get('/units/{unitId}/chapters', [ControllersChapterController::class, 'index'])->name('student_chapters.index');
Route::get('/chapters/{chapterId}/lessons', [ControllersChapterController::class, 'showLessons'])->name('student_lessons.index');
Route::get('/lessons/{lessonId}/ebooks', [ControllersChapterController::class, 'viewEbooks'])->name('student_lessons.ebooks');

// End student  dashboard routes



// Teacher dashboard route with 'auth:teacher' middleware
Route::get('/teacher/dashboard', function () {
    return 'Teacher Dashboard';
})->middleware('auth:teacher')->name('teacher.dashboard');






// Route::get('/unit', function () {
//     return view('pages.student.unit.index');
// })->name('student.unit');



// Route::get('/chapter', function () {
//     return view('pages.student.chapter.index');
// })->name('student.chapter');

// Route::get('/week', function () {
//     return view('pages.student.week.index');
// })->name('student.week');

// Route::get('/assignment', function () {
//     return view('pages.student.assignment.index');
// })->name('student.assignment');

// Route::get('/assignment_show', function () {
//     return view('pages.student.assignment.show');
// })->name('student.assignment.show');

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
    Route::get('assessments/student/{student_id}', [StudentAssessmentController::class, 'showStudentAssessments'])->name('teacher.assessments.student');

    // Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');

    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/stage/{stageId}/materials', [TeacherDashboardController::class, 'showMaterials'])->name('teacher.showMaterials');
    Route::get('/teacher/material/{materialId}/units', [TeacherDashboardController::class, 'showUnits'])->name('teacher.units');
    Route::get('/units/{unitId}/chapters', [TeacherDashboardController::class, 'showChapters'])->name('teacher.chapters.index');
    Route::get('/chapters/{chapterId}/lessons', [TeacherDashboardController::class, 'showLessons'])->name('teacher.lessons.index');

    // Example route to show units for a material (adapt as needed)


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

// });
