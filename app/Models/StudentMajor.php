<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMajor extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_major_name',
  ];

  public function majors()
  {
    return $this->belongsToMany(Major::class, 'student_major_conjunctions');
  }
  public function students()
  {
    return $this->hasMany(StudentProfile::class);
  }
}
