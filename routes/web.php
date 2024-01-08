<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\DeanController;
use App\Http\Controllers\Student\ExamController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Dean\DeanMajorController;
use App\Http\Controllers\Student\LessonsController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Dean\DeanLessonsController;
use App\Http\Controllers\Student\CategoryController;
use App\Http\Controllers\Admin\AdminLessonController;
use App\Http\Controllers\Student\ExamResultController;
use App\Http\Controllers\Student\RecentExamController;
use App\Http\Controllers\Student\RecentLessonsController;
use App\Http\Controllers\Instructor\UploadHistoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dean\DeanHistoryController;
use App\Http\Controllers\Instructor\InstructorMajorController;
use App\Http\Controllers\Instructor\InstructorLessonsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/', function () {
//   return Inertia::render('Auth/Login');
// });
Route::middleware(['guest'])->group(function () {
  Route::get('/', [AuthenticatedSessionController::class, 'create']);
});
Route::get('/error/unauthorized', function () {
  return Inertia::render('Unauthorized');
})->name('unauthorized');
Route::fallback(function () {
  return Inertia::render('Unauthorized');
});

Route::middleware(['auth', 'role:student'])->group(function () {
  Route::get('/student/lessons', [CategoryController::class, 'index'])->name('category.index');

  //Lesson
  Route::get('/student/{recent_id}/lessons/{id}/page/{page}', [LessonsController::class, 'index'])->name('lesson.index');
  Route::get('/student/lessons/{id}/page/{page}/store', [LessonsController::class, 'store'])->name('lesson.store');

  //Lesson Attempts
  Route::get('/student/recents/lessons', [RecentLessonsController::class, 'index'])->name('recent.lesson.index');

  //Exam
  Route::get('/student/exam/categories', [ExamController::class, 'index'])->name('exam.index');
  Route::post('/student/exam/categories/take', [ExamController::class, 'store'])->name('exam.store');
  Route::get('/student/exam/{exam_id}/lesson/{lesson_id}/page/{page}', [ExamController::class, 'show'])->name('exam.show');

  //Exam result
  Route::post('/student/exam/store/answer', [ExamResultController::class, 'store'])->name('exam.answer.store');
  Route::get('/student/exam/{exam_id}/lesson/{lesson_id}/page/{page}/result', [ExamResultController::class, 'show'])->name('exam.result.show');
  Route::get('/student/exam/{exam_id}/result', [ExamResultController::class, 'index'])->name('exam.result.index');

  //Exam Attempts
  Route::get('/student/recents/exams', [RecentExamController::class, 'index'])->name('recent.exam.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
  Route::resource('/admin/majors', AdminLessonController::class);

  //Students
  Route::resource('/admin/majors/students', StudentController::class)->except([
    'update',
    'destroy',
    'create',
    'edit',
  ]);;
  Route::post('/student/store/excel', [StudentController::class, 'store_excel'])->name('students.store.excel');
  Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('students.update');
  Route::post('/student/destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy');


  //Instructors
  Route::resource('/instructors', InstructorController::class)->except([
    'update',
    'destroy',
    'create',
    'edit',
  ]);;
  Route::post('/instructors/update/{id}', [InstructorController::class, 'update'])->name('instructors.update');

  //Dean
  Route::resource('/dean', DeanController::class)->except([
    'update',
    'destroy',
    'create',
    'edit',
  ]);;
  Route::post('/dean/update/{id}', [DeanController::class, 'update'])->name('dean.update');
});
Route::middleware(['auth', 'role:instructor'])->group(function () {

  Route::get('/instructor/majors', [InstructorMajorController::class, 'index'])->name('instructor.majors.index');
  Route::post('/instructor/majors/upload', [InstructorMajorController::class, 'store'])->name('instructor.majors.store');

  // Uploaded lessons
  Route::get('/instructor/majors/{id}/status/{status}', [InstructorLessonsController::class, 'index'])->name('instructor.lessons.index');
  Route::get('/instructor/upload/history', [UploadHistoryController::class, 'index'])->name('instructor.history.index');

  //View lessons 
  Route::get('/instructor/lessons/{category_id}/page/{page}', [InstructorLessonsController::class, 'show'])->name('instructor.lessons.show');
  //Cancel lesson
  Route::post('/instructor/lessons/{category_id}/cancel', [InstructorLessonsController::class, 'destroy'])->name('instructor.lessons.destroy');
});

Route::middleware(['auth', 'role:dean'])->group(function () {
  Route::get('/majors/dean', [DeanMajorController::class, 'index'])->name('dean.majors.index');

  // Uploaded lessons
  Route::get('/dean/majors/{id}/status/{status}', [DeanLessonsController::class, 'index'])->name('dean.lessons.index');

  //View lessons 
  Route::get('/dean/lessons/{category_id}/page/{page}', [DeanLessonsController::class, 'show'])->name('dean.lessons.show');

  //Lesson Action
  Route::post('/dean/lessons/{category_id}/action/{action}', [DeanLessonsController::class, 'update'])->name('dean.lessons.update');

  //Dean action history
  Route::get('/history/dean', [DeanHistoryController::class, 'index'])->name('dean.history.index');
});




// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
