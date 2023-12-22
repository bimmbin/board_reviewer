<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id',
    'lesson_id',
    'choice_id',
    'is_correct',
    'not_answered',
  ];

  public function exam()
  {
    return $this->belongsTo(Exam::class);
  }
  public function choice()
  {
    return $this->belongsTo(Choice::class);
  }
  public function lesson()
  {
    return $this->belongsTo(Lesson::class);
  }
}
