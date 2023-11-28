<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
  public function index()
  {
    $categories = Category::all();
    // dd($lessons );
    return Inertia::render('Student/Category', [
      'categories' => $categories
    ]);
  }
}
