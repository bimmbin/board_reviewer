<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\StaffProfile;
use App\Models\CorrectAnswer;
use App\Models\MajorCoverage;
use App\Models\StudentProfile;
use Illuminate\Database\Seeder;
use App\Models\MajorExamCoverage;
use App\Models\StudentMajor;
use App\Models\StudentMajorConjunction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class tester extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $major_lists = ['General Education', 'Professional Education', 'Social Science', 'Mathematics', 'Filipino', 'English'];

    foreach ($major_lists as $major) {
      Major::create([
        'major_name' => $major
      ]);
      StudentMajor::create([
        'student_major_name' => $major
      ]);
    }
    MajorCoverage::create([
      'percent' => 60,
    ]);
    MajorCoverage::create([
      'percent' => 40,
    ]);

    for ($i = 1; $i <= 2; $i++) {
      StudentMajorConjunction::create([
        'student_major_id' => '1',
        'major_id' => $i,
        'major_coverage_id' => $i,
      ]);
    }

    $admin = User::create([
      'username' => 'admin',
      'user_role' => 'admin',
      'password' => Hash::make("admin123"),
    ]);
    StaffProfile::create([
      'user_id' => $admin->id,
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'middle_name' => fake()->lastName(),
      'employee_number' => "23452022",
    ]);


    for ($i = 0; $i < 40; $i++) {
      $student = User::create([
        'username' => 'student' . $i,
        'user_role' => 'student',
        'password' => Hash::make($i . "23452022"),
      ]);

      StudentProfile::create([
        'user_id' => $student->id,
        'student_major_id' => 1,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'middle_name' => fake()->lastName(),
        'student_number' => $i . "23452022",
      ]);
    }

    for ($i = 0; $i < 5; $i++) {
      $instructor = User::create([
        'username' => 'instructor' . $i,
        'user_role' => 'instructor',
        'password' => Hash::make($i . "23452021"),
      ]);

      StaffProfile::create([
        'user_id' => $instructor->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'middle_name' => fake()->lastName(),
        'employee_number' => $i . "23452021",
      ]);
    }

    $dean = User::create([
      'username' => 'dean',
      'user_role' => 'dean',
      'password' => Hash::make($i . "23452024"),
    ]);

    StaffProfile::create([
      'user_id' => $dean->id,
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'middle_name' => fake()->lastName(),
      'employee_number' => $i . "23452024",
    ]);
    // User::factory()->count(40)->create();
    // Category::factory()->count(10)
    //   ->has(
    //     Lesson::factory()->count(40)
    //       ->has(
    //         Choice::factory()->count(4),
    //         'choices'
    //       )->has(
    //         CorrectAnswer::factory()->count(1)->sequence(fn (Sequence $sequence) => ['choice_id' => ($sequence->index + 1) * 4]),
    //         'correct_answer'
    //       ),
    //     'lessons'
    //   )

    //   ->create();
  }
}
