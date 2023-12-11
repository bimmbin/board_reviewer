<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
  use HasFactory;

  protected $fillable = [
    'lesson_id',
    'choice_index',
    'choice_description',
  ];

  public function lesson()
  {
    return $this->belongsTo(Lesson::class);
  }
  public function correct_answer()
  {
    return $this->hasOne(CorrectAnswer::class);
  }
  public function exam_answers()
  {
    return $this->hasMany(ExamAnswer::class);
  }
}
