<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'major_id',
    'first_name',
    'last_name',
    'middle_name',
    'student_number',
  ];

  public function major()
  {
    return $this->belongsTo(Major::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
