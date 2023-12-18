<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\PageViews;
use App\Models\RecentLesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LessonsController extends Controller
{
  public function index($recent_id, $id, $page)
  {
    // dd($recent_id, $id, $page);
    $user = Auth::user();
    if (!session()->has($recent_id . $user->username)) {
      return redirect()->route('unauthorized');
    }

    $lessons = Session::get($recent_id . $user->username)['lessons'];
    $session_expiry_date = Session::get($recent_id . $user->username)['expiry_date'];

    //remove session if it expires already
    if (now()->diff($session_expiry_date)->invert == 1) {
      Session::forget($recent_id . $user->username);
    }

    $lessons_count = count($lessons);

    if (!(($page >= 1) && ($page <= $lessons_count))) {

      return redirect()->route('unauthorized');
    }
    $lesson = $lessons->skip($page - 1)->first();
    $lesson->load('category');
    $lesson->load('correct_answer', 'correct_answer.choice');

    // creating page views when user visits specific lesson
    $page_view = PageViews::firstOrNew([
      'user_id' => $user->id,
      'recent_lesson_id' => $recent_id,
      'category_id' => $id,
      'lesson_id' => $lesson->id
    ], [
      'page_number' => $page,
    ]);

    if (!$page_view->exists) {
      $page_view->save();
      // $category->recent_lesson()->touch();
    }

    // dd($lesson);
    return Inertia::render('Student/Lesson', [
      'category_id' => $id,
      'lesson' => $lesson,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
      'recent_id' => $recent_id,
    ]);
  }

  public function store($id, $page)
  {
    $user = Auth::user();

    // creating recent lesson when user visits new lesson
    $recent_lesson = RecentLesson::create([
      'category_id' => $id,
      'user_id' => $user->id,
      'countdown' => now()->addMinutes(3),
    ]);

    $category = Category::with('recent_lessons', 'lessons', 'lessons.choices', 'lessons.correct_answer', 'lessons.correct_answer.choice')->findOrFail($id);
    $lesson = $category->lessons()->inRandomOrder()->get();

    session()->put($recent_lesson->id . $user->username, ['lessons' => $lesson, 'expiry_date' => now()->addMinutes(3)]);

    return redirect()->route('lesson.index', [$recent_lesson->id, $id, $page]);
  }
}
