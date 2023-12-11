<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'choice_id' => 'required',
  ]);

    $lesson = Lesson::with('correct_answer')->findOrFail($request->lesson_id);

    //check if user choice is correct
    if ($lesson->correct_answer->choice->id == $request->choice_id) {
      $is_correct = true;
    } else {
      $is_correct = false;
    }

    ExamAnswer::create([
      'exam_id' => $request->exam_id,
      'lesson_id' => $request->lesson_id,
      'choice_id' => $request->choice_id,
      'user_id' => Auth::user()->id,
      'is_correct' => $is_correct,
    ]);

    return redirect()->route('exam.result.show', [$request->exam_id, $request->category_id, $request->current_page]);
  }

  public function show($exam_id, $id, $page)
  {
    $category = Category::with('recent_lesson', 'lessons')->findOrFail($id);
    $lessons_count = Category::withCount('lessons')->findOrFail($id)->lessons_count;

    $lesson = $category->lessons[$page - 1];
    $lesson->load('category');
    $lesson->load('correct_answer', 'correct_answer.choice');

    $exam_answer = ExamAnswer::where('exam_id', $exam_id)->where('lesson_id', $lesson->id)->first();
    $exam_answer->load('choice');
    
    return Inertia::render('Student/ExamResult', [
      'category_id' => $category->id,
      'lesson' => $lesson,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
      'exam_answer' => $exam_answer,
      'exam_id' => $exam_id
    ]);
  }
}
