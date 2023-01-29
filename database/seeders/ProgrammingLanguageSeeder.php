<?php

namespace Database\Seeders;

use App\Models\ProgrammingLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgrammingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgrammingLanguage::factory(10)->create();
    }
}
