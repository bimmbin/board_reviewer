<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Major;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $majors = Major::whereHas('student_majors', function (Builder $query) use ($user) {
            $query->where('student_major_id', $user->student_profile->student_major->id);
        })->whereHas('categories', function (Builder $query) use ($user) {
            $query->where('status', 'approved');
        })->with('major_coverage')->get();

        $coverage_count = Auth::user()->student_profile->student_major->majors->count();


        if ($assessment = Assessment::with('exams')->where('student_profile_id', $user->student_profile->id)->latest()->first()) {
            if ($assessment->exams->count() < $coverage_count) {
                $filtered_majors = $majors->map(function ($major) use ($assessment) {
                    foreach ($assessment->exams as $exam) {
                        if ($exam->major_id == $major->id) {
                            $major->has_taken = true;
                        } else {
                            $major->has_taken = false;
                        }
                    }
                    return $major;
                });
            } else {
                $filtered_majors = $majors->map(function ($major) use ($assessment) {
                    $major->has_taken = false;
                    return $major;
                });
            }
        } else {
            $filtered_majors = $majors->map(function ($major) use ($assessment) {
                $major->has_taken = false;
                return $major;
            });
        }

        return Inertia::render('Student/ExamCategories', [
            'majors' => $filtered_majors,
        ]);
    }

    public function store(Request $request)
    {
        $student_profile_id = Auth::user()->student_profile->id;
        $coverage_count = Auth::user()->student_profile->student_major->majors->count();

        $assessment = Assessment::with('exams')->where('student_profile_id', $student_profile_id)->latest()->first();

        if ($assessment) {
            if ($assessment->exams->count() < $coverage_count) {
                $assessment_final = $assessment;
            } else {
                $assessment_final = Assessment::create([
                    'student_profile_id' => $student_profile_id,
                ]);
            }
        }
        //only if db is fresh
        else {
            // dd('doesnt have any assessment');
            $assessment_final = Assessment::create([
                'student_profile_id' => $student_profile_id,
            ]);
        }

        $user = Auth::user();
        $exam = Exam::create([
            'major_id' => $request->major_id,
            'student_profile_id' => $user->student_profile->id,
            'assessment_id' => $assessment_final->id,
        ]);



        $major = Major::with('categories', 'categories.lessons')->findOrFail($request->major_id);

        $lesson_collection = new Collection();
        foreach ($major->categories as $category) {
            $lesson_collection = $lesson_collection->merge($category->lessons);
        }

        session()->put($exam->id . $user->username, $lesson_collection->shuffle()->take(100));

        return redirect()->route('exam.show', [$exam->id, 1]);
    }

    public function show($exam_id, $page)
    {
        // dd($exam_id, $page);
        $user = Auth::user();
        if (!session()->has($exam_id . $user->username)) {
            return redirect()->back();
        }
        $lessons = Session::get($exam_id . $user->username);
        $lessons_count = count($lessons);

        if (!($page >= 1 && $page <= $lessons_count)) {
            return redirect()->route('unauthorized');
        }
        $lesson = $lessons->skip($page - 1)->first();
        $lesson->load('category');
        $lesson->load('choices');

        //set time for each lesson (1min)
        if (!$lesson->getAttribute('time_ends')) {
            $lesson->setAttribute('time_ends', now()->addMinutes(1));
        }
        $lesson->setAttribute('time_remaining', now()->diff($lesson->time_ends));


        $choices = $lesson->choices()->inRandomOrder()->get();

        return Inertia::render('Student/Exam', [
            'lesson' => $lesson,
            'choices' => $choices,
            'current_page' => $page,
            'lessons_count' => $lessons_count,
            'exam_id' => $exam_id
        ]);
    }
}
