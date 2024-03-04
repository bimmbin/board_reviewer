<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Exam extends Model
{
  use HasFactory;

  protected $fillable = [
    'major_id',
    'assessment_id',
  ];

  

  public function major()
  {
    return $this->belongsTo(Major::class);
  }

  public function exam_answers()
  {
    return $this->hasMany(ExamAnswer::class);
  }
  
}
