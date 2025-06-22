<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessment>
 */
class AssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = Question::factory()->create();
        return [
            'question_id' => $question->id,
            'score' => $this->faker->numberBetween(0, $question->max_total),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'percentage' => $this->faker->numberBetween(0, 100),
            'response' => json_encode([
                'student_id' => $this->faker->numberBetween(10000000, 99999999),
                'marked_by_ai' => $this->faker->boolean(),
                'ai_analysis_of_the_student_answer' => $this->faker->sentence(),
            ]),
            'status' => $this->faker->randomElement(['pending', 'completed']),
        ];
    }
}
