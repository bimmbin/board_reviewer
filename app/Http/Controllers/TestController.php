<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function index($id, $page)
  { 
    $category = Category::with('lessons', 'lessons.choices', 'lessons.correct_answer', 'lessons.correct_answer.choice')->findOrFail($id);
    $lessons_count = Category::withCount('lessons')->findOrFail($id)->lessons_count;
  
    $lesson = $category->lessons[$page - 1];

    // dd($lesson);
    return Inertia::render('Student/Lesson', [
      'category_id' => $category->id,
      'lesson' => $lesson,
      'current_page' => $page,
      'lessons_count' => $lessons_count,

    ]);
  }
}
