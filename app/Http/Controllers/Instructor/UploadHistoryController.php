<?php

namespace App\Http\Controllers\Instructor;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UploadHistoryController extends Controller
{
  public function index()
  {
    $categories = Category::getStaffCategories();

    return Inertia::render('Instructor/UploadHistory', [
      'lessons' => $categories,
    ]);
  }
}
