<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageViews extends Model
{
    use HasFactory;

    protected $fillable = [
      'category_id',
      'lesson_id',
      'user_id',
      'page_number'
    ];
  
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function lesson()
    {
      return $this->belongsTo(Lesson::class);
    }
    public function category()
    {
      return $this->belongsTo(Category::class);
    }
}
