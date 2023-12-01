<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\PageViews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LessonsController extends Controller
{
  public function index($id, $page)
  {
    $category = Category::with('lessons', 'lessons.choices', 'lessons.correct_answer', 'lessons.correct_answer.choice')->findOrFail($id);
    $lessons_count = Category::withCount('lessons')->findOrFail($id)->lessons_count;

    $lesson = $category->lessons[$page - 1];

    // creating page views when user visits specific lesson
    $page_view = PageViews::firstOrNew([
      'user_id' => Auth::user()->id,
      'category_id' => $id,
      'lesson_id' => $lesson->id
    ], [
      'page_number' => $page,
    ]);

    if (!$page_view->exists) {
      $page_view->save();
    }

    // dd($lesson);
    return Inertia::render('Student/Lesson', [
      'category_id' => $category->id,
      'lesson' => $lesson,
      'current_page' => $page,
      'lessons_count' => $lessons_count,

    ]);
  }
}
