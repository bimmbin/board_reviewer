<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
  use HasFactory;

  protected $fillable = [
    'major_name',
  ];

  public function categories()
  {
    return $this->hasMany(Category::class);
  }
  public function student_majors()
  {
    return $this->belongsToMany(Major::class, 'student_major_conjunctions');
  }
  public function major_coverage()
  {
    return $this->belongsToMany(MajorCoverage::class, 'student_major_conjunctions');
  }
  public function exams()
  {
    return $this->hasMany(Exam::class);
  }
  
}
