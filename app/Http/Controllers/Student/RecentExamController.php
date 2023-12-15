<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class RecentExamController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;

    $recent_exams = Exam::with(['category' => function ($query) {
      $query->withCount('lessons'); //this counts the grandchild relation
    }])->withCount(['exam_answers' => function (Builder $query) {
      $query->where('is_correct', '1');
    }])->where('user_id', $user_id)->latest()->get();

    //added time_taken
    $filtered_recent_exams  = $recent_exams->map(function ($exam) {
      $time = $exam->created_at->diff($exam->updated_at);
      if ($time->h > 0) {
        if ($time->h == 1) {
          $hour = $time->h . ' hour, ';
        } else {
          $hour = $time->h . ' hours, ';
        }
      } else {
        $hour = '';
      }
      if ($time->i > 0) {
        if ($time->i == 1) {
          $minute = $time->i . ' minute, and ';
        } else {
          $minute = $time->i . ' minutes, and ';
        }
      } else {
        $minute = '';
      }
       if ($time->s > 0) {
        if ($time->s == 1) {
          $second = $time->s . ' second ';
        } else {
          $second = $time->s . ' seconds ';
        }
      } else {
        $second = '';
      }
      $exam->time_taken = $hour.$minute.$second;

      return $exam;
    });
    // dd($filtered_recent_exams);

    return Inertia::render('Student/RecentExams', [
      'recent_exams' => $filtered_recent_exams
    ]);
  }
}
