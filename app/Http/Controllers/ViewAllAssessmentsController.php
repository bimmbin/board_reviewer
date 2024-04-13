<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ViewAllAssessmentsController extends Controller
{
    public function index()
    {

        $assessments = Assessment::with(['exams' => function ($query) {
            $query->withCount(['exam_answers' => function (Builder $query) {
                $query->where('is_correct', '1');
            }]);
        }])->latest()->get();
        $assessments->load('student_profile', 'student_profile.student_major', 'student_profile.student_major.majors');


        $filtered_assessments = $assessments->map(function ($assessment) {
            $exam_coverage = $assessment->student_profile->student_major->majors;
            $total_score = 0;
            $exam_scores = [];
            foreach ($exam_coverage as $exam_cover) {
                foreach ($assessment->exams as $exam) {
                    if ($exam_cover->id == $exam->major_id) {
                        $exam_scores[] = $exam_cover->major_name . ' (' . $exam->exam_answers_count . '/100)';
                        // $exam->newshit = floatval('0.'.$exam_cover->major_coverage[0]->percent);
                        $total_score += ($exam->exam_answers_count / 100) * floatval('0.' . $exam_cover->major_coverage[0]->percent);
                    }
                }
            }

            if ($total_score != 0) {
                $rounded_total_score = intval(substr(explode('.', $total_score)[1], 0, 2));
            } else {
                $rounded_total_score = intval(explode('.', $total_score)[0]);
            }

            $new_format_assessments = [
                'first_name' => $assessment->student_profile->first_name,
                'last_name' => $assessment->student_profile->last_name,
                'major' => $assessment->student_profile->student_major->student_major_name,
                'updated_at' => $assessment->updated_at,
                'updated_at' => $assessment->updated_at,
                'exam_scores' => $exam_scores,
                'total_score' => $rounded_total_score,
            ];
            return $new_format_assessments;
        });

        return Inertia::render('ViewAssessments', [
            'assessments' => $filtered_assessments,
        ]);
    }
}
