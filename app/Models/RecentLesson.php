<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentLesson extends Model
{
  use HasFactory;

  protected $fillable = [
    'category_id',
    'user_id',
    'countdown',
  ];

  public function page_views()
  {
    return $this->hasMany(PageViews::class);
  }
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  public function student_profile()
  {
    return $this->belongsTo(StudentProfile::class);
  }
}
