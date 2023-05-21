<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = fake()->randomElement(Question::all());
        $user = fake()->randomElement(User::all());

        return [
            'question_id' => $question,
            'user_id' => $user,
            'text' => fake()->text(5000),
        ];
    }
}
