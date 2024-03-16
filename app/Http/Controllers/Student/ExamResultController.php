<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExamResultController extends Controller
{
  public function index($exam_id)
  {
    $user = Auth::user();

    $exam = Exam::findOrFail($exam_id);
    $exam->touch();
    $exam->load('exam_answers');
    $exam->load('major');
    $correct_count = $exam->exam_answers()->where('is_correct', 1)->count();

    $lessons_count = count(Session::get($exam_id . $user->username));

    $lessons = Session::get($exam_id . $user->username);
    $lessons->load('correct_answer', 'correct_answer.choice', 'exam_answer', 'exam_answer.choice');

    // dd($lessons);

    // Session::forget($exam_id . $user->username);

    return Inertia::render('Student/ExamFinalResult', [
      'exam' => $exam,
      'correct_count' => $correct_count,
      'lesson_count' => $lessons_count,
      'lessons' => $lessons,
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'choice_id' => 'required',
    ]);

    $user = Auth::user();
    $lessons = Session::get($request->exam_id . $user->username);
    $lessons_count = count($lessons);
    $lesson = $lessons->skip($request->current_page - 1)->first();
    $lesson->load('correct_answer');

    //check if user choice is correct
    if ($request->not_answered == 1) {
      $is_correct = false;
    } elseif ($lesson->correct_answer->choice->id == $request->choice_id) {
      $is_correct = true;
    } else {
      $is_correct = false;
    }
    $e_answer = ExamAnswer::firstOrNew([
      'exam_id' => $request->exam_id,
      'lesson_id' => $request->lesson_id,
    ], [
      'choice_id' => $request->choice_id,
      'is_correct' => $is_correct,
      'not_answered' => $request->not_answered,
    ]);
    if (!$e_answer->exists) {
      $e_answer->save();
    }
    

    return redirect()->route('exam.result.show', [$request->exam_id, $request->current_page]);
  }

  public function show($exam_id, $page)
  {

    $user = Auth::user();
    $lessons = Session::get($exam_id . $user->username);
    $lessons_count = count($lessons);
    $lesson = $lessons->skip($page - 1)->first();
    $lesson->load('correct_answer', 'correct_answer.choice');


    $exam_answer = ExamAnswer::where('exam_id', $exam_id)->where('lesson_id', $lesson->id)->first();

    //this prevents the user to go in results page without answering
    if (!$exam_answer) {
      return redirect()->back();
    }
    $exam_answer->load('choice');

    return Inertia::render('Student/ExamResult', [
      'lesson' => $lesson,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
      'exam_answer' => $exam_answer,
      'exam_id' => $exam_id
    ]);
  }
}
