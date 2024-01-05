<?php

namespace App\Http\Controllers\Instructor;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class InstructorLessonsController extends Controller
{
  public function show(Request $request, $major_id, $status)
  {
    $categories = Category::whereHas('major', function (Builder $query) use ($major_id) {
      $query->where('id', $major_id);
    })->where('status', $status)
      ->with('staff_profile')
      ->withCount('lessons')
      ->latest()
      ->paginate(10)
      ->withQueryString()
      ->through(function ($item) {
        return [
          'id' => $item->id,
          'category_name' => $item->category_name,
          'status' => $item->status,
          'item_count' => $item->lessons_count,
          'uploaded_by' => $item->staff_profile->first_name.' '.$item->staff_profile->last_name,
        ];
      });


    return Inertia::render('Instructor/InstructorLessons', [
      'lessons' => $categories,
      'status' => $status
    ]);
  }
}
