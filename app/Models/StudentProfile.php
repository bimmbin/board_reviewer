<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'student_major_id',
    'first_name',
    'last_name',
    'middle_name',
    'student_number',
  ];

  public function student_major()
  {
    return $this->belongsTo(StudentMajor::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function assessments()
  {
    return $this->hasMany(Assessment::class);
  }

}
