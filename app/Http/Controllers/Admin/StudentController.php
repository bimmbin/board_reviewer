<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Shuchkin\SimpleXLSX;
use App\Http\Requests\File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class StudentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource using excel.
   */
  public function store_excel(File $request)
  {
    $reviewers = SimpleXLSX::parse($request->file);

    $counter = 0;
    foreach ($reviewers->rows() as $row) {

      // Skip the first iteration
      if ($counter++ == 0) continue;

      $student = User::firstOrNew(
        [
          'student_number' => $row[0]
        ],
        [
          'major_id' => 1,
          'user_role' => 'student',
          'last_name' => $row[1],
          'first_name' => $row[2],
          'middle_name' => $row[3],
          'username' => $row[1] . $row[0],
          'password' => Hash::make($row[0])
        ]
      );
      if (!$student->exists) {
        $student->save();
      };
    };

    return redirect()->back();
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'student_number' => 'required|integer|unique:' . StudentProfile::class,
      'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'middle_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
    ]);

    //user
    $student_user = User::firstOrNew(
      ['username' => $request->last_name . $request->student_number],
      [
        'user_role' => 'student',
        'password' => Hash::make('student123'),
      ]
    );
    if (!$student_user->exists) {
      $student_user->save();
    };

    //profile
    $student_profile = StudentProfile::firstOrNew(
      [
        'user_id' => $student_user->id,
      ],
      [
        'major_id' => $request->major_id,
        'user_role' => 'student',
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'middle_name' => $request->middle_name,
        'student_number' => rand(1000, 9999) . "2021",
      ]
    );
    if (!$student_profile->exists) {
      $student_profile->save();
    };

    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, string $id)
  {

    $students = StudentProfile::whereHas('student_major', function (Builder $query) use ($id) {
      $query->where('id', $id);
    })->with('user')->when($request->input('search'), function ($query, $search) {
      $query->where('first_name', 'like', "%{$search}%")
        ->orWhere('last_name', 'like', "%{$search}%")
        ->orWhere('middle_name', 'like', "%{$search}%")
        ->orWhere('student_number', 'like', "%{$search}%");
    })->latest()
      ->paginate(10)
      ->withQueryString()
      ->through(function ($item) {
        return [
          'id' => $item->id,
          'first_name' => $item->first_name,
          'last_name' => $item->last_name,
          'middle_name' => $item->middle_name,
          'student_number' => $item->student_number,
          'user_id' => $item->user->id,
        ];
      });

    return Inertia::render('Admin/Students', [
      'students' => $students,
      'filters' => $request->only('search'),
      'major_id' => $id,
    ]);
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
    $request->validate([
      'student_number' => ['required', Rule::unique('student_profiles')->ignore($id)],
      'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'middle_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
    ]);

    $student_profile = StudentProfile::findOrFail($id);

    //StudentProfile update
    $student_profile->student_number = $request->student_number;
    $student_profile->first_name = $request->first_name;
    $student_profile->last_name = $request->last_name;
    $student_profile->middle_name = $request->middle_name;
    $student_profile->save();

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back();
  }
}
