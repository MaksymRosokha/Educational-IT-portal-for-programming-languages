<?php

namespace Database\Factories;

use App\Models\ProgramInProgrammingLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'program_id' => fake()->randomElement(ProgramInProgrammingLanguage::all()),
            'sequence_number' => fake()->unique()->randomNumber(),
            'title' => fake()->word(),
            'content' => fake()->randomHtml(),
        ];
    }
}
