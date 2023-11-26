<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
  use HasFactory;

  protected $fillable = [
    'category_id',
    'lesson_question',
    'correct_index',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function choices()
  {
    return $this->hasMany(Choice::class);
  }
}