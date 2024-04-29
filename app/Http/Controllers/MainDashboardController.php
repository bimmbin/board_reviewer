<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Quote;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class MainDashboardController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['exams' => function ($query) {
            $query->withCount(['exam_answers' => function (Builder $query) {
                $query->where('is_correct', '1');
            }]);
        }])->get();

        $quotes = Quote::inRandomOrder()->get();

        $exam_coverage = User::findOrFail(2)->student_profile->student_major->majors;

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

        $data = [];
        $average_total = 0;
        foreach ($filtered_assessments as $assessment) {
            $average_total += $assessment->total_score;
            $data[] = $assessment->total_score;
        }
        $series[] = [
            "name" => "Student Assessment Total Score",
            "data" => $data,
        ];



        // getting the categories for apexchart
        $categories = [];
        for ($i = 0; $i < count($assessments); $i++) {
            $categories[] = $i + 1;
        }



        if (count($filtered_assessments) != 0) {
            $average_double = $average_total / count($filtered_assessments);
            $average = intval(substr(explode('.', $average_double)[0], 0, 2));
        } else {
            $average = 0;
        }

        // dd($series, $categories, $quotes, $average);

        return Inertia::render('MainDashboard', [
            'series' => $series,
            'categories' => $categories,
            'quotes' => $quotes,
            'average' => $average,
        ]);
    }
}
