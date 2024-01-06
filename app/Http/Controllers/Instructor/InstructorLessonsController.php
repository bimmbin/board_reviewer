<?php

namespace App\Http\Controllers\Instructor;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class InstructorLessonsController extends Controller
{
  public function index($major_id, $status)
  {
    $categories = Category::getCategoriesByMajor($major_id, $status);

    return Inertia::render('Instructor/InstructorLessons', [
      'lessons' => $categories,
      'status' => $status
    ]);
  }

  public function show($category_id, $page)
  {
    $category = Category::with('lessons', 'lessons.choices', 'lessons.correct_answer')->findOrFail($category_id);
    $lesson = $category->lessons[$page - 1];
    $lesson->load('category');

    $lessons_count = $category->lessons->count();

    return Inertia::render('Instructor/LessonView', [
      'category_id' => $category_id,
      'lesson' => $lesson,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
    ]);
  }
}
