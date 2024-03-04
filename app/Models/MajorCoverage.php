<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajorCoverage extends Model
{
  use HasFactory;

  protected $fillable = [
    'percent',
  ];

  public function majors()
  {
    return $this->belongsToMany(Major::class, 'student_major_conjunctions');
  }
}
