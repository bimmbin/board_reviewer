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

    $recent_exams = Exam::with('category', 'lessons')->withCount(['exam_answers' => function (Builder $query) {
      $query->where('is_correct', '1');
    }])->where('user_id', $user_id)->latest()->get();

    
    dd($recent_exams);
    return Inertia::render('Student/RecentExams', [
      'recent_exams' => $recent_exams
    ]);
  }
}
