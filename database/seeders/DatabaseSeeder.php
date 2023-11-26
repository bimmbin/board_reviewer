<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Choice;
use App\Models\Lesson;
use App\Models\Major;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    Major::factory(1)
      ->has(
        Category::factory()->count(1)
          ->has(
            Lesson::factory()->count(38)
              ->has(Choice::factory()->count(4), 'choices'),
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
