<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\ProgramInProgrammingLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 200; $i++) {
            DB::transaction(function () {
                Lesson::factory()->create();
            });
        }
    }
}
