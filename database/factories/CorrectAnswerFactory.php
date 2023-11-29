<?php

namespace Database\Factories;

use App\Models\Choice;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CorrectAnswer>
 */
class CorrectAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'lesson_id' => Lesson::factory(),
        ];
    }
}
