<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;


  protected $fillable = [
    'major_id',
    'category_name',
  ];

  public function major()
  {
    return $this->belongsTo(Major::class);
  }

  public function lessons()
  {
    return $this->hasMany(Lesson::class);
  }
}