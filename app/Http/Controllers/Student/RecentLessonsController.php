<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\PageViews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RecentLesson;
use Illuminate\Support\Facades\Auth;

class RecentLessonsController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;
    // $categories = Category::whereHas('page_views', function ($query) use ($user_id) {
    //   $query->where('user_id', $user_id);
    // })->orderBy('updated_at', 'desc')->get();
    // $categories->load('page_views');
    // $categories->load('lessons');

    $recent_lessons = RecentLesson::with('category', 'category.lessons', 'page_views')->where('user_id', $user_id)->latest()->get();

    return Inertia::render('Student/RecentLessons', [
      'recent_lessons' => $recent_lessons
    ]);
  }
}
