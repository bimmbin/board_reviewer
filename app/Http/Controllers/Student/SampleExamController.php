<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Major;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SampleExamController extends Controller
{

  public function store(Request $request)
  {

  }

  public function show($exam_id, $page)
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

    return Inertia::render('Student/SampleExam', [
      'lesson' => $lesson,
      'choices' => $choices,
      'current_page' => $page,
      'lessons_count' => $lessons_count,
      'exam_id' => $exam_id
    ]);
  }
}
