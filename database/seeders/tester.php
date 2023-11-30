<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\CorrectAnswer;
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
    User::create([
      'username' => 'admin',
      'user_role' => 'admin',
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'password' => Hash::make('admin123'),
    ]);
    User::create([
      'username' => 'student1',
      'user_role' => 'student',
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'password' => Hash::make('student123'),
    ]);
    User::create([
      'username' => 'student2',
      'user_role' => 'student',
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'password' => Hash::make('student123'),
    ]);

    Major::factory(1)
      ->has(
        Category::factory()->count(10)
          ->has(
            Lesson::factory()->count(40)
              ->has(
                Choice::factory()->count(4),
                'choices'
              )->has(
                CorrectAnswer::factory()->count(1)->sequence(fn (Sequence $sequence) => ['choice_id' => ($sequence->index + 1) * 4]),
                'correct_answer'
              ),
            'lessons'
          ),
        'categories'
      )
      ->create();
  }
}
