<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\PageViews;
use Carbon\CarbonInterval;
use App\Models\RecentLesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecentLessonsController extends Controller
{
  public function index()
  {
    // $recent_lesson12321 = RecentLesson::findOrFail(1)->countdown;
    // dd();
    $user_id = Auth::user()->id;


    $recent_lessons = RecentLesson::with('category', 'category.lessons', 'page_views')->where('user_id', $user_id)->latest()->get();

    //filtering to determine if countdown is ended
    $filtered_recent_lessons  = $recent_lessons->map(function ($recent_lesson) {

      $recent_lesson->time_remaining = now()->diffForHumans($recent_lesson->countdown, true);
      $recent_lesson->time_ended = now()->diff($recent_lesson->countdown)->invert;
      return $recent_lesson;
    });
    
    dd(session()->all());

    return Inertia::render('Student/RecentLessons', [
      'recent_lessons' => $filtered_recent_lessons
    ]);
  }
}
