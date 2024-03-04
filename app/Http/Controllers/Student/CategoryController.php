<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Major;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
  public function index()
  {
    // $categories = Category::with('page_views', 'lessons')->get();
    $user = Auth::user();

    $majors = Major::whereHas('student_majors', function (Builder $query) use ($user) {
      $query->where('student_major_id', $user->student_profile->student_major->id);
    })->with(['categories' => function ($query) {
      $query->where('status', 'approved')->latest();
    }], 'categories.lessons', 'categories.lessons.correct_answer', 'categories.lessons.choices', 'categories.recent_lessons', 'categories.recent_lessons.page_views')->get();


    //filtering categories if the user already has a finished recent lesson
    // $filtered_majors  = $majors->map(function ($major) {
    //   foreach ($major->categories as $category) {
    //     foreach ($category->recent_lessons as $recent_lesson) {
    //       // if (count($recent_lesson->page_views) == count($category->lessons)) {
    //         $category->is_finished = true;
    //       // }
    //     }
    //   }
    //   return $major;
    // });
    $filtered_majors = $majors->map(function ($major) {
      foreach ($major->categories as $category) {
          $finished = false;
          foreach ($category->recent_lessons as $recent_lesson) {
              if (count($recent_lesson->page_views) == count($category->lessons)) {
                  $finished = true;
              }
          }
          $category->is_finished = $finished;
      }
      return $major;
  });

    // dd($filtered_majors);
    return Inertia::render('Student/Category', [
      'majors' => $filtered_majors
    ]);
  }
}
