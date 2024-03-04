<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_profile_id',
  ];

  public function student_profile()
  {
    return $this->belongsTo(StudentProfile::class);
  }
  public function exams()
  {
    return $this->hasMany(Exam::class);
  }
}
