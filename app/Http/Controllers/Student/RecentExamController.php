<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class RecentExamController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->student_profile->id;

    $assessments = Assessment::with(['exams' => function ($query) {
      $query->withCount(['exam_answers' => function (Builder $query) {
        $query->where('is_correct', '1');
      }]);
    }])->where('student_profile_id', $user_id)->latest()->get();

    $exam_coverage = Auth::user()->student_profile->student_major->majors;

    $filtered_assessments = $assessments->map(function ($assessment) use ($exam_coverage) {
      $total_score = 0;
      foreach ($exam_coverage as $exam_cover) {
        foreach ($assessment->exams as $exam) {
          if ($exam_cover->id == $exam->major_id) {
            // $exam->newshit = floatval('0.'.$exam_cover->major_coverage[0]->percent);
            $total_score += ($exam->exam_answers_count / 10) * floatval('0.' . $exam_cover->major_coverage[0]->percent);
          }
        }
      }
      if ($total_score != 0) {
        $assessment->total_score = intval(substr(explode('.', $total_score)[1], 0, 2));
      } else {
        $assessment->total_score = intval(explode('.', $total_score)[0]);
      }
      return $assessment;
    });


    return Inertia::render('Student/RecentExams', [
      'assessments' => $filtered_assessments,
      'exam_coverage' => $exam_coverage
    ]);
  }
}
