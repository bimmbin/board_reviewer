<?php

namespace App\Http\Controllers\Dean;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\DeanHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeanLessonsController extends Controller
{
    public function index($major_id, $status)
    {
        $categories = Category::getCategoriesByMajor($major_id, $status);

        return Inertia::render('Dean/DeanLessons', [
            'lessons' => $categories,
            'status' => $status
        ]);
    }

    public function show($category_id, $page)
    {
        $category = Category::with('lessons', 'lessons.choices', 'lessons.correct_answer')->findOrFail($category_id);
        $lesson = $category->lessons[$page - 1];
        $lesson->load('category');

        $lessons_count = $category->lessons->count();

        return Inertia::render('Dean/DeanLessonView', [
            'category_id' => $category_id,
            'lesson' => $lesson,
            'current_page' => $page,
            'lessons_count' => $lessons_count,
        ]);
    }

    public function update($category_id, $action)
    {
        $category = Category::findOrFail($category_id);
        $category->status = $action;
        $category->save();

        DeanHistory::create([
            'staff_profile_id' => Auth::user()->staff_profile->id,
            'category_id' => $category->id,
            'status' => $action,
        ]);

        if ($action == 'disapproved') {
            $color = 'yellow';
        } elseif ($action == 'approved') {
            $color = 'green';
        }

        redirect()->back()->with([
            'message' => $category->category_name . ' has been successfully ' . $action,
            'color' => $color,
        ]);
    }
}
