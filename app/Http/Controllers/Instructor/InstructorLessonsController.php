<?php

namespace App\Http\Controllers\Instructor;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class InstructorLessonsController extends Controller
{
    public function index($major_id, $status)
    {
        $categories = Category::getCategoriesByMajor($major_id, $status);

        return Inertia::render('Instructor/InstructorLessons', [
            'lessons' => $categories,
            'status' => $status
        ]);
    }

    public function store_pdf(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048'
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;
        $file->storeAs('public', $fileName);

        // 
        $category = Category::findOrFail($request->category_id);
        $category->pdf = $fileName;
        $category->save();


        redirect()->back();
    }

    public function view_pdf($category_id)
    {
        $category = Category::findOrFail($category_id);
        $pdf = $category->pdf;

        // dd(Storage::getVisibility('public/' . $pdf));
        // dd(Storage::exists('public/' . $pdf));

        // dd(Storage::path('public/' . $pdf));
        return Storage::download('public/' . $pdf);
    }
    public function show($category_id, $page)
    {
        $category = Category::with('lessons', 'lessons.choices', 'lessons.correct_answer')->findOrFail($category_id);
        $lesson = $category->lessons[$page - 1];
        $lesson->load('category');

        $lessons_count = $category->lessons->count();

        return Inertia::render('Instructor/LessonView', [
            'category_id' => $category_id,
            'lesson' => $lesson,
            'current_page' => $page,
            'lessons_count' => $lessons_count,
        ]);
    }

    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();

        redirect()->back();
    }
}
