<?php

namespace App\Http\Controllers\Student;

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

    $categories = Category::with(['page_views' => function ($query) use ($user_id) {
      $query->where('user_id', $user_id);
    }, 'lessons'])->where('major_id', $user->major->id)->get();

    return Inertia::render('Student/Category', [
      'categories' => $categories
    ]);
  }
}
