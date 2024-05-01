<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Major;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories = Category::with('page_views', 'lessons')->get();
        $user = Auth::user();

        $majors = Major::whereHas('student_majors', function (Builder $query) use ($user) {
            $query->where('student_major_id', $user->student_profile->student_major->id);
        })->with(['categories' => function ($query) use ($user) {
            $query->where('status', 'approved')
                ->withCount(['finished_quizzes' => function ($query) use ($user) {
                    $query->where('student_profile_id', $user->student_profile->id);
                }]);
        }], 'categories.lessons', 'categories.lessons.correct_answer', 'categories.lessons.choices', 'categories.recent_lessons', 'categories.recent_lessons.page_views')->get();

        // dd($filtered_majors);
        return Inertia::render('Student/Category', [
            'majors' => $majors
        ]);
    }
}
