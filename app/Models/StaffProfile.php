<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'first_name',
    'last_name',
    'middle_name',
    'employee_number',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function submitted_lessons()
  {
    return $this->hasMany(Category::class);
  }
  public function dean_history()
  {
    return $this->hasMany(DeanHistory::class);
  }
}
