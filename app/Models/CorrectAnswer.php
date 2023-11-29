<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
      'lesson_id',
      'choice_id',
    ];
  
    public function lesson()
    {
      return $this->belongsTo(Lesson::class);
    }
    public function choice()
    {
      return $this->belongsTo(Choice::class);
    }
}
