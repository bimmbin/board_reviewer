<?php

namespace App\Http\Controllers\Instructor;

use Inertia\Inertia;
use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Category;
use Shuchkin\SimpleXLSX;
use App\Http\Requests\File;
use Illuminate\Http\Request;
use App\Models\CorrectAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class InstructorMajorController extends Controller
{
    public function index()
    {
        $majors = Major::with('categories')->orderBy('created_at', 'asc')->get();

        //getting all the approved categories count per majors
        $filtered_majors  = $majors->map(function ($major) {

            $major->category_approved_count = $major->categories()->where('status', 'approved')->count();
            $major->category_pending_count = $major->categories()->where('status', 'pending')->count();

            return $major;
        });

        return Inertia::render('Instructor/InstructorMajors', [
            'majors' => $filtered_majors
        ]);
    }
    public function store(File $request)
    {

        $reviewers = SimpleXLSX::parse($request->file);


        for ($i = 0; $i < $reviewers->sheetsCount(); $i++) {
            // Check if the sheet has less than 6 columns
            if ($reviewers->rows($i)[0] && count($reviewers->rows($i)[0]) < 6) {
                return redirect()->back()->withErrors(['file' => 'Sheet ' . $reviewers->sheetName($i) . ' has less than 6 columns.']);
            }
            // Check if the sheet has more than 6 columns
            if ($reviewers->rows($i)[0] && count($reviewers->rows($i)[0]) > 6) {
                return redirect()->back()->withErrors(['file' => 'Sheet ' . $reviewers->sheetName($i) . ' has more than 6 columns.']);
            }
            // Rest of your code...
        }


        //iteration for sheets
        for ($i = 0; $i < $reviewers->sheetsCount(); $i++) {
            //category
            $category = Category::firstOrNew([
                'major_id' => $request->id,
                'staff_profile_id' => Auth::user()->staff_profile->id,
                'category_name' => $reviewers->sheetName($i),
                'status' => 'pending'
            ]);
            if (!$category->exists) {
                $category->save();
            }
            $counter = 0;
            foreach ($reviewers->rows($i) as $sheet) {

                // Skip the first iteration
                if ($counter++ == 0) continue;

                //Lesson
                $lesson = Lesson::firstOrNew([
                    'category_id' => $category->id,
                    'lesson_question' => $sheet[0]
                ]);
                if (!$lesson->exists) {
                    $lesson->save();
                }
                //Choices
                for ($j = 1; $j <= 4; $j++) {
                    $choice[$j] = Choice::firstOrNew([
                        'lesson_id' => $lesson->id,
                        'choice_description' => $sheet[$j]
                    ]);
                    if (!$choice[$j]->exists) {
                        $choice[$j]->save();
                    }
                }
                //CorrectAnswer
                $correct_answer = CorrectAnswer::firstOrNew([
                    'lesson_id' => $lesson->id,
                    'choice_id' => $choice[$sheet[5]]->id,
                ]);
                if (!$correct_answer->exists) {
                    $correct_answer->save();
                }
            }
        }

        return redirect()->back();
    }
}
