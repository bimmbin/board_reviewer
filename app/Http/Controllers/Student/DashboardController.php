<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Quote;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\CssSelector\Node\FunctionNode;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->student_profile->id;

        $assessments = Assessment::with(['exams' => function ($query) {
            $query->withCount(['exam_answers' => function (Builder $query) {
                $query->where('is_correct', '1');
            }]);
        }])->where('student_profile_id', $user_id)->get();

        $quotes = Quote::inRandomOrder()->get();


        $exam_coverage = Auth::user()->student_profile->student_major->majors;

        $filtered_assessments = $assessments->map(function ($assessment) use ($exam_coverage) {
            $total_score = 0;
            foreach ($exam_coverage as $exam_cover) {
                foreach ($assessment->exams as $exam) {
                    if ($exam_cover->id == $exam->major_id) {
                        // $exam->newshit = floatval('0.'.$exam_cover->major_coverage[0]->percent);
                        $total_score += ($exam->exam_answers_count / 10) * floatval('0.' . $exam_cover->major_coverage[0]->percent);
                    }
                }
            }
            if ($total_score != 0) {
                $assessment->total_score = intval(substr(explode('.', $total_score)[1], 0, 2));
            } else {
                $assessment->total_score = intval(explode('.', $total_score)[0]);
            }
            return $assessment;
        });

        $average_total = 0;
        foreach ($filtered_assessments as $assessment) {
            $average_total += $assessment->total_score;
        }

        // getting the categories for apexchart
        $categories = [];
        for ($i = 0; $i < count($assessments); $i++) {
            $categories[] = $i + 1;
        }

        // getting the series for apexchart
        $series = [];
        foreach ($exam_coverage as $coverage) {
            $data = [];
            foreach ($filtered_assessments as $assessment) {
                foreach ($assessment->exams as $exam) {
                    if ($coverage->id == $exam->major_id) {
                        // $exam->newshit = floatval('0.'.$exam_cover->major_coverage[0]->percent);
                        $data[] =  $exam->exam_answers_count;
                    }
                }
            }
            $series[] = [
                "name" => $coverage->major_name,
                "data" => $data,
            ];
        }

        if (count($filtered_assessments) != 0) {
            $average_double = $average_total / count($filtered_assessments);
            $average = intval(substr(explode('.', $average_double)[0], 0, 2));
        } else {
            $average = 0;
        }

        return Inertia::render('Student/Dashboard', [
            'series' => $series,
            'categories' => $categories,
            'quotes' => $quotes,
            'average' => $average,
        ]);
    }

    public function credentials()
    {
        $student = User::with('student_profile')->where('user_role', 'student')->latest()->first();
        $instructor = User::with('staff_profile')->where('user_role', 'instructor')->latest()->first();
        $dean = User::with('staff_profile')->where('user_role', 'dean')->latest()->first();
        $admin = User::where('user_role', 'admin')->latest()->first();

        return Inertia::render('Auth/Credentials', [
            'student' => $student,
            'instructor' => $instructor,
            'dean' => $dean,
            'admin' => $admin,
        ]);
    }
}
