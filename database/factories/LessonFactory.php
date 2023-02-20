<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\ProgramInProgrammingLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        $programInProgrammingLanguage = fake()->randomElement(ProgramInProgrammingLanguage::all());

        $maxSequenceNumber = DB::table('lessons')
            ->where('program_id', $programInProgrammingLanguage->id)
            ->max('sequence_number');

        $nextSequenceNumber = $maxSequenceNumber + 1;

        return [
            'program_id' => $programInProgrammingLanguage->id,
            'sequence_number' => $nextSequenceNumber,
            'title' => fake()->word(),
            'content' => fake()->randomHtml(),
        ];
    }
}
