<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\StaffProfile;
use App\Models\StudentMajor;
use App\Models\CorrectAnswer;
use App\Models\MajorCoverage;
use App\Models\StudentProfile;
use Illuminate\Database\Seeder;
use App\Models\MajorExamCoverage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentMajorConjunction;
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
      'percent' => 40,
    ]);
    MajorCoverage::create([
      'percent' => 60,
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


    $quotesarray = [
      [
        "quote" => "Trust yourself; you know more than you think you do.",
        "author" => "Benjamin Spock",
      ],
      [
        "quote" => "Education not just preparation for life, but part of life itself – a continuous art.",
        "author" => "Henry Ford",
      ],
      [
        "quote" => "My advice is to never do tomorrow what you can do today. Procrastination is the thief of time.",
        "author" => "Charles Dickens",
      ],
      [
        "quote" => "The roots of education are bitter, but the fruit is sweet.",
        "author" => "Aristotle",
      ],
      [
        "quote" => "I never said it would be easy, I only said it would be worth it.",
        "author" => "Mae West",
      ],
      [
        "quote" => "Nothing is impossible, the word itself says ‘I’m possible’!",
        "author" => "Audrey Hepburn",
      ],
      [
        "quote" => "If you can dream it, you can do it.",
        "author" => "Walt Disney",
      ],
      [
        "quote" => "The only limit to the height of your achievements is the reach of your dreams and your willingness to work for them.",
        "author" => "Michelle Obama",
      ],
      [
        "quote" => "Do not let what you cannot do interfere with what you can do.",
        "author" => "John Wooden",
      ],
      [
        "quote" => "Believe you can and you’re halfway there.",
        "author" => "Theodore Roosevelt",
      ],
      [
        "quote" => "You are capable of more than you know. Aim high. Behave honorably.",
        "author" => "E.O. Wilson",
      ],
      [
        "quote" => "In order to succeed, we must first believe that we can.",
        "author" => "Nikos Kazantzakis",
      ],
      [
        "quote" => "The future belongs to those who believe in the beauty of their dreams.",
        "author" => "Eleanor Roosevelt",
      ],
      [
        "quote" => "When you get tired, learn to rest, not quit.",
        "author" => "Banksy",
      ],
      [
        "quote" => "Believe in yourself and all that you are. Know that there is something inside you that is greater than any obstacle.",
        "author" => "Christian D. Larson",
      ],
      [
        "quote" => "Keep your dreams alive. Understand to achieve anything requires faith and belief in yourself, vision, hard work, determination, and dedication. Remember all things are possible for those who believe.",
        "author" => "Gail Devers",
      ]
    ];

    DB::table('quotes')->insert($quotesarray);
  }
}
