<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function index($id)
  { 
    $category = Category::with('lessons', 'lessons.choices')->findOrFail(1);
    $lessons_count = Category::withCount('lessons')->findOrFail(1)->lessons_count;
  
    $lesson = $category->lessons[$id - 1];
    return Inertia::render('Test', [
      'lesson' => $lesson,
      'current_page' => $id,
      'lessons_count' => $lessons_count,

    ]);
  }
}
