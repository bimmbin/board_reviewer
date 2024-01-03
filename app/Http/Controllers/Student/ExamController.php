<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $categories = Category::withCount('lessons')->where('major_id', $user->student_profile->major_id)->get();

    return Inertia::render('Student/ExamCategories', [
      'categories' => $categories
    ]);
  }

  public function store(Request $request)
  {
    $user = Auth::user();
    $exam = Exam::create([
      'category_id' => $request->category_id,
      'student_profile_id' => $user->student_profile->id,
    ]);
    $category = Category::with('lessons')->findOrFail($request->category_id);
    $lesson = $category->lessons()->inRandomOrder()->get();

    session()->put($exam->id . $user->username, $lesson);

    return redirect()->route('exam.show', [$exam->id, $request->category_id, 1]);
  }

  public function show($exam_id, $id, $page)
  {
    $user = Auth::user();
    if (!session()->has($exam_id . $user->username)) {
      return redirect()->back();
    }  
    $lessons = Session::get($exam_id . $user->username);
    $lessons_count = count($lessons);

    if (!($page >= 1 && $page <= $lessons_count)) {
      return redirect()->route('unauthorized');
    }
    $lesson = $lessons->skip($page - 1)->first();
    $lesson->load('category');
    $lesson->load('choices');

    //set time for each lesson (1min)
    if (!$lesson->getAttribute('time_ends')) {
      $lesson->setAttribute('time_ends', now()->addSeconds(15));
    }
    $lesson->setAttribute('time_remaining', now()->diff($lesson->time_ends));

    $choices = $lesson->choices()->inRandomOrder()->get();

    return Inertia::render('Student/Exam', [
      'category_id' => $id,
      'lesson' => $lesson,
      'choices' => $choices,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
      'exam_id' => $exam_id
    ]);
  }
}
