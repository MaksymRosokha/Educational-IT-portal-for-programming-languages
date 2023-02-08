<?php

namespace Database\Factories;

use App\Models\ProgrammingLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProgramInProgrammingLanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'programming_language_id' => fake()->randomElement(ProgrammingLanguage::all()),
            'name' => fake()->company(),
            'description' => fake()->text(2000),
        ];
    }
}
