<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeanHistory extends Model
{
  use HasFactory;

  protected $fillable = [
    'staff_profile_id',
    'category_id',
    'status',
  ];

  public static function getDeanHistory()
  {
    $histories = DeanHistory::latest()
      ->with('category', 'category.staff_profile', 'category.major')
      ->paginate(10)
      ->through(function ($item) {
        return [
          'id' => $item->id,
          'category_name' => $item->category->category_name,
          'major_name' => $item->category->major->major_name,
          'status' => $item->status,
          'uploaded_by' => $item->category->staff_profile->first_name . ' ' . $item->category->staff_profile->last_name,
          'date' => $item->created_at->toFormattedDateString(),
        ];
      });


    return $histories;
  }

  public function staff_profile()
  {
    return $this->belongsTo(StaffProfile::class);
  }
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
}
