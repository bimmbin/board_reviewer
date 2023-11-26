<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function index($id)
  { 
    $lesson = Lesson::with('choices')->findOrFail($id);
    
    return Inertia::render('Test', [
      'lesson' => $lesson,
    ]);
  }
}
