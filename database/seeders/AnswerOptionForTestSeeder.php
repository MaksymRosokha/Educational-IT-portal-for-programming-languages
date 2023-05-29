<?php

namespace Database\Seeders;

use App\Models\AnswerOptionForTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerOptionForTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 60; $i++) {
            DB::transaction(function () {
                AnswerOptionForTest::factory()->create();
            });
        }
    }
}
