<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Major;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\CorrectAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    Major::factory(1)
      ->has(
        Category::factory()->count(10)
          ->has(
            Lesson::factory()->count(40)
              ->has(
                Choice::factory()->count(4),
                'choices'
              )->has(
                CorrectAnswer::factory()->count(1)->sequence(fn (Sequence $sequence) => ['choice_id' => ($sequence->index+1)*4]),
                'correct_answer'
              ),
            'lessons'
          ),
        'categories'
      )
      ->create();

    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
  }
}
