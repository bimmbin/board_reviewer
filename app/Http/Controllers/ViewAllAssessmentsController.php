<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ViewAllAssessmentsController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $sort = $request->input('sort');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $assessments = Assessment::with(['exams' => function ($query) {
            $query->withCount(['exam_answers' => function (Builder $query) {
                $query->where('is_correct', '1');
            }]);
        }, 'student_profile.student_major', 'student_profile.student_major.majors'])
            ->when($search, function ($query, $search) {
                $query->whereHas('student_profile', function (Builder $query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%");
                });
            })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get();
        // $assessments->load('student_profile', 'student_profile.student_major', 'student_profile.student_major.majors');

        // 'student_profile' => function ($query) use ($search) {
        //     $query->when($search, function ($query, $search) {
        //         $query->where('first_name', 'like', "%{$search}%")
        //             ->orWhere('last_name', 'like', "%{$search}%")
        //             ->orWhere('middle_name', 'like', "%{$search}%")
        //             ->orWhere('student_number', 'like', "%{$search}%");
        //     });
        // }
        // dd($assessments);

        $filtered_assessments = $assessments->map(function ($assessment) {
            $exam_coverage = $assessment->student_profile->student_major->majors;
            $total_score = 0;
            $exam_scores = [];
            foreach ($exam_coverage as $exam_cover) {
                foreach ($assessment->exams as $exam) {
                    if ($exam_cover->id == $exam->major_id) {
                        $exam_scores[] = $exam_cover->major_name . ' (' . $exam->exam_answers_count . '/150)';
                        // $exam->newshit = floatval('0.'.$exam_cover->major_coverage[0]->percent);
                        $total_score += ($exam->exam_answers_count / 150) * floatval('0.' . $exam_cover->major_coverage[0]->percent);
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

        $final_assessments = $filtered_assessments->when($sort, function (Collection $collection, $sort) {
            if ($sort == '1') {
                return $collection->sortByDesc('updated_at')->values();
            } elseif ($sort == '2') {
                return $collection->sortByDesc('total_score')->values();
            } else {
                return $collection->sortBy('total_score')->values();
            }
        });

        // dd($final_assessments);

        return Inertia::render('ViewAssessments', [
            'assessments' => $final_assessments,
            'filters' => [
                'search' => $request->input('search'),
                'sort' => $request->input('sort') ? $request->input('sort') : 1,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ],
        ]);
    }
}
