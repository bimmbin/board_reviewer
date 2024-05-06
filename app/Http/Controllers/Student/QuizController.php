<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Major;
use App\Models\Lesson;
use App\Models\Assessment;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FinishedQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;

class QuizController extends Controller
{
    //\

    public function store(Request $request)
    {
        $user = Auth::user();
        $exam = Exam::create([
            'major_id' => $request->major_id,
            'student_profile_id' => $user->student_profile->id,
            'assessment_id' => null,
        ]);

        $category = Category::with('lessons')->findOrFail($request->category_id);

        session()->put($exam->id . $user->username, $category->lessons->shuffle()->take(10));

        return redirect()->route('quiz.show', [$exam->id, 1]);
    }

    public function store_answer(Request $request)
    {
        $request->validate([
            'choice_id' => 'required',
        ]);

        $user = Auth::user();
        $lessons = Session::get($request->exam_id . $user->username);
        $lessons_count = count($lessons);
        $lesson = $lessons->skip($request->current_page - 1)->first();
        $lesson->load('correct_answer');

        //check if user choice is correct
        if ($request->not_answered == 1) {
            $is_correct = false;
        } elseif ($lesson->correct_answer->choice->id == $request->choice_id) {
            $is_correct = true;
        } else {
            $is_correct = false;
        }
        $e_answer = ExamAnswer::firstOrNew([
            'exam_id' => $request->exam_id,
            'lesson_id' => $request->lesson_id,
        ], [
            'choice_id' => $request->choice_id,
            'is_correct' => $is_correct,
            'not_answered' => $request->not_answered,
        ]);
        if (!$e_answer->exists) {
            $e_answer->save();
        }

        if ($request->current_page != $lessons_count) {
            return redirect()->route('quiz.show', [$request->exam_id, intval($request->current_page) + 1]);
        } else {
            return redirect()->route('quiz.result', $request->exam_id);
        }

        // return redirect()->route('exam.result.show', [$request->exam_id, $request->current_page]);

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

        return Inertia::render('Student/Quiz', [
            'lesson' => $lesson,
            'choices' => $choices,
            'current_page' => $page,
            'lessons_count' => $lessons_count,
            'exam_id' => $exam_id
        ]);
    }

    public function result($exam_id)
    {
        $user = Auth::user();

        $exam = Exam::findOrFail($exam_id);
        $exam->touch();
        $exam->load('exam_answers');
        $exam->load('major');
        $correct_count = $exam->exam_answers()->where('is_correct', 1)->count();

        $lessons_count = count(Session::get($exam_id . $user->username));

        $lessons = Session::get($exam_id . $user->username);
        $lessons->load('correct_answer', 'correct_answer.choice', 'exam_answer', 'exam_answer.choice');

        $category = $lessons->first()->category;

        // Session::forget($exam_id . $user->username);
        $filtered_lessons = $lessons->map(function ($lesson) use ($exam_id) {

            $exam = ExamAnswer::with('choice')->where('exam_id', $exam_id)->where('lesson_id', $lesson->id)->first();
            // return $major;
            $recent_lessons = [
                'lesson_question' => $lesson->lesson_question,
                'correct_answer' => $lesson->correct_answer->choice->choice_description,
                'exam_answer' => !empty($exam) ? $exam->choice->choice_description : 'no answer',
            ];
            return $recent_lessons;
        });

        FinishedQuiz::create(
            [
                'category_id' =>  $category->id,
                'student_profile_id' => $user->student_profile->id
            ]
        );


        return Inertia::render('Student/QuizResult', [
            'exam' => $exam,
            'correct_count' => $correct_count,
            'lesson_count' => $lessons_count,
            'lessons' => $filtered_lessons,
            'category_name' => $category->category_name,
        ]);
    }
}
