<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
  public function index()
  {
    // $categories = Category::with('page_views', 'lessons')->get();
    $user = Auth::user();
    $user_id = Auth::user()->id;

    $categories = Category::with(['recent_lessons' => function ($query) use ($user_id) {
      $query->where('user_id', $user_id)->latest();
    }])->where('major_id', $user->major->id)->get();
    $categories->loadCount('lessons');

    dd(Carbon::now());
    //filtering categories if the user already has a finished recent lesson
    $filtered_categories  = $categories->map(function ($category) {
      foreach ($category->recent_lessons as $recent_lesson) {
        if (count($recent_lesson->page_views) == count($category->lessons)) {
          $category->is_finished = true;
        }
      }
      if (count($category->recent_lessons) != 0) {
        $category->recent_lesson_id = $category->recent_lessons[0]->id;
        $category->latest_lesson_length = count($category->recent_lessons[0]->page_views);
      } else {
        $category->latest_lesson_length = 0;
      }
      unset($category->recent_lessons);
      return $category;
    });
    // dd($filtered_categories);
    return Inertia::render('Student/Category', [
      'categories' => $categories
    ]);
  }
}
