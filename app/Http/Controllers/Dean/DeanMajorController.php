<?php

namespace App\Http\Controllers\Dean;

use Inertia\Inertia;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeanMajorController extends Controller
{
  public function index()
  {
    $majors = Major::with('categories')->get();

    //get category status counts of each major
    $filtered_majors  = $majors->map(function ($major) {

      $major->category_approved_count = $major->categories()->where('status', 'approved')->count();
      $major->category_pending_count = $major->categories()->where('status', 'pending')->count();
      $major->category_disapproved_count = $major->categories()->where('status', 'disapproved')->count();

      return $major;
    });

    return Inertia::render('Dean/DeanMajors', [
      'majors' => $filtered_majors
    ]);
  }
}
