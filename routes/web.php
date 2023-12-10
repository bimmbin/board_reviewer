<?php

use App\Http\Controllers\Admin\AdminLessonController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Student\LessonsController;
use App\Http\Controllers\Student\CategoryController;
use App\Http\Controllers\Student\RecentLessonsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Student\ExamController;

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
Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/error/unauthorized', function () {
  return Inertia::render('Unauthorized');
})->name('unauthorized');


Route::middleware(['auth', 'student'])->group(function () {
  Route::get('/student/lessons', [CategoryController::class, 'index'])->name('category.index');

  Route::get('/student/lessons/{id}/page/{page}', [LessonsController::class, 'index'])->name('test.index');

  Route::get('/student/recents/lessons', [RecentLessonsController::class, 'index'])->name('recent.lesson.index');

  //Exam
  Route::get('/student/exam/categories', [ExamController::class, 'index'])->name('exam.index');
  Route::post('/student/exam/categories/take', [ExamController::class, 'store'])->name('exam.store');
  Route::get('/student/exam/{id}/page/{page}', [ExamController::class, 'show'])->name('exam.show');

});

Route::resource('/admin/majors', AdminLessonController::class);
// Route::get('/student/lessons', [LessonsController::class, 'index'])->name('lessons.index');







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
