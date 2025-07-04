<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_text' => fake()->sentence(),
            // 'question_upload_id' => fake()->uuid(),
            'max_total' => fake()->numberBetween(1, 10),
            'course_code' => fake()->word(),
            'session' => fake()->year() - 1 . '/' . fake()->year(),
            'semester' => fake()->numberBetween(1, 3),
            'level' => fake()->numberBetween(1, 4),
            'user_id' => User::first()->id,
        ];
    }
}
