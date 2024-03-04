<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMajorConjunction extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_major_id',
    'major_id',
  ];
  
}
