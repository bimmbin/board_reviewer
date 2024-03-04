<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\StudentMajor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class AdminLessonController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $majors = StudentMajor::with('categories')->get();
    $majors = StudentMajor::all();
    $majors->loadCount('students');

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
  public function store(File $request)
  {
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
