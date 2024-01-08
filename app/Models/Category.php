<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
  use HasFactory;

  protected $fillable = [
    'major_id',
    'staff_profile_id',
    'category_name',
    'status',
  ];

  public static function getStaffCategories()
  {
    $staff_profile_id = Auth::user()->staff_profile->id;
    $categories = Category::where('staff_profile_id', $staff_profile_id)
      ->with('staff_profile', 'major')
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
          'major_name' => $item->major->major_name,
          'date' => $item->created_at->toFormattedDateString(),
        ];
      });

    return $categories;
  }

  public static function getCategoriesByMajor($major_id, $status)
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
          'date' => $item->created_at->toFormattedDateString(),
        ];
      });

    return $categories;
  }

  public function major()
  {
    return $this->belongsTo(Major::class);
  }

  public function lessons()
  {
    return $this->hasMany(Lesson::class);
  }
  public function page_views()
  {
    return $this->hasMany(PageViews::class);
  }
  public function recent_lessons()
  {
    return $this->hasMany(RecentLesson::class);
  }
  public function exams()
  {
    return $this->hasMany(Exam::class);
  }
  public function staff_profile()
  {
    return $this->belongsTo(StaffProfile::class);
  }
  public function dean_history()
  {
    return $this->hasMany(DeanHistory::class);
  }
}
