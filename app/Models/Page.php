<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id',
    'correct_index',
    'user_index',
  ];

  public function exam()
  {
    return $this->belongsTo(Exam::class);
  }

}
