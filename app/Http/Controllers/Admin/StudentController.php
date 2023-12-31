<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Shuchkin\SimpleXLSX;
use App\Http\Requests\File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
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
          'student_id' => $row[0]
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
      'student_id' => 'required|integer|unique:' . User::class,
      'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'middle_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
    ]);

    $student = User::firstOrNew(
      [
        'student_id' => $request->student_id
      ],
      [
        'major_id' => 1,
        'user_role' => 'student',
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'middle_name' => $request->middle_name,
        'username' => $request->last_name . $request->student_id,
        'password' => Hash::make($request->student_id)
      ]
    );
    if (!$student->exists) {
      $student->save();
    };

    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, string $id)
  {

    $students = User::whereHas('major', function (Builder $query) use ($id) {
      $query->where('id', $id);
    })->when($request->input('search'), function ($query, $search) {
      $query->where('first_name', 'like', "%{$search}%")
        ->orWhere('last_name', 'like', "%{$search}%")
        ->orWhere('middle_name', 'like', "%{$search}%")
        ->orWhere('student_id', 'like', "%{$search}%");
    })->latest()
      ->paginate(10)
      ->withQueryString()
      ->through(function ($item) {
        return [
          'id' => $item->id,
          'first_name' => $item->first_name,
          'last_name' => $item->last_name,
          'middle_name' => $item->middle_name,
          'student_id' => $item->student_id,
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
      'student_id' => ['required', Rule::unique('users')->ignore($id)],
      'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      'middle_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
    ]);
    
    $user = User::findOrFail($id);

    //User update
    $user->student_id = $request->student_id;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->middle_name = $request->middle_name;
    $user->save();

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
