<?php

namespace Database\Seeders;

use App\Models\QuestionForTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionForTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuestionForTest::factory(20)->create();
    }
}
