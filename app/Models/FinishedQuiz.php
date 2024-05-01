<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedQuiz extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'category_id',
        'student_profile_id',
    ];

    public function student_profile()
    {
        return $this->belongsTo(StudentProfile::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
