<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\CorrectAnswer;
use App\Models\StaffProfile;
use App\Models\StudentProfile;
use Illuminate\Database\Seeder;
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
    $major_lists = ['General Education', 'Social Science', 'Mathematics', 'Filipino', 'English', 'Professional Education'];

    foreach ($major_lists as $major) {
      Major::create([
        'major_name' => $major
      ]);
    }

    $admin = User::create([
      'username' => 'admin',
      'user_role' => 'admin',
      'password' => Hash::make('admin123'),
    ]);
    StaffProfile::create([
      'user_id' => $admin->id,
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'middle_name' => fake()->lastName(),
      'employee_number' => rand(1000, 9999) . "2021",
    ]);


    for ($i = 0; $i < 40; $i++) {
      $student = User::create([
        'username' => 'student' . $i,
        'user_role' => 'student',
        'password' => Hash::make('student123'),
      ]);

      StudentProfile::create([
        'user_id' => $student->id,
        'major_id' => 1,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'middle_name' => fake()->lastName(),
        'student_number' => rand(1000, 9999) . "2021",
      ]);
    }

    for ($i = 0; $i < 5; $i++) {
      $instructor = User::create([
        'username' => 'instructor' . $i,
        'user_role' => 'instructor',
        'password' => Hash::make('instructor123'),
      ]);

      StaffProfile::create([
        'user_id' => $instructor->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'middle_name' => fake()->lastName(),
        'employee_number' => rand(1000, 9999) . "2021",
      ]);
    }

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
