<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $categories = Category::withCount('lessons')->where('major_id', $user->major_id)->get();
    return Inertia::render('Student/ExamCategories', [
      'categories' => $categories
    ]);
  }

  public function store(Request $request)
  {
    $exam = Exam::create([
      'category_id' => $request->category_id,
      'user_id' => Auth::user()->id,
    ]);

    return redirect()->route('exam.show', [$exam->id, $request->category_id, 1]);
  }

  public function show($exam_id, $id, $page)
  {
    $category = Category::with('recent_lesson', 'lessons')->findOrFail($id);
    $lessons_count = Category::withCount('lessons')->findOrFail($id)->lessons_count;

    $lesson = $category->lessons()->skip($page - 1)->first();

    // $lesson = $category->lessons[$page - 1];
    $lesson->load('category');

    $choices = $lesson->choices()->inRandomOrder()->get();
    // dd($lesson);
    return Inertia::render('Student/Exam', [
      'category_id' => $category->id,
      'lesson' => $lesson,
      'choices' => $choices,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
      'exam_id' => $exam_id
    ]);
  }
}
