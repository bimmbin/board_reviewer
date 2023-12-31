<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Exam extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_profile_id',
    'category_id',
  ];

  public function student_profile()
  {
    return $this->belongsTo(StudentProfile::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function exam_answers()
  {
    return $this->hasMany(ExamAnswer::class);
  }
  public function lessons(): HasManyThrough
  {
    return $this->hasManyThrough(Lesson::class, Category::class);
  }
}
