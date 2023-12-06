<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use Shuchkin\SimpleXLSX;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CorrectAnswer;

class AdminLessonController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $majors = Major::get();
    return Inertia::render('Admin/AdminMajors', [
      'majors' => $majors
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->all());
    $reviewers = SimpleXLSX::parse($request->file);

    //iteration for sheets
    for ($i = 0; $i < $reviewers->sheetsCount(); $i++) {
      //category
      $category = Category::firstOrNew([
        'major_id' => $request->id,
        'category_name' => $reviewers->sheetName($i)
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

    return redirect()->route('majors.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
