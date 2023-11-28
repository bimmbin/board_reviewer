<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonsController extends Controller
{
  public function index()
  {
    $lessons = Category::all();
    // dd($lessons );
    return Inertia::render('Student/Lessons', [
      'lessons' => $lessons
    ]);
  }
}
