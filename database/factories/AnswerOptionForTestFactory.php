<?php

namespace Database\Factories;

use App\Models\QuestionForTest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnswerOptionForTest>
 */
class AnswerOptionForTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = fake()->randomElement(QuestionForTest::all());
        $isCorrect = true;

        foreach($question->answerOptions as $answer) {
            if($answer->is_correct === 1) {
                $isCorrect = false;
                break;
            }
        }

        return [
            'question_for_test_id' => $question,
            'text' => fake()->text(),
            'is_correct' => $isCorrect,
        ];
    }
}
