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
  public function students()
  {
    return $this->hasMany(User::class);
  }
}
