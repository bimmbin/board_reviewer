<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id',
    'choice_id',
    'is_correct',
  ];

  public function exam()
  {
    return $this->belongsTo(Exam::class);
  }
  public function choice()
  {
    return $this->belongsTo(Choice::class);
  }
  
}
