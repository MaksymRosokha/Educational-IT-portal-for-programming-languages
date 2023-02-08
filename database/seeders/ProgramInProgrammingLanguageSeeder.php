<?php

namespace Database\Seeders;

use App\Models\ProgramInProgrammingLanguage;
use App\Models\ProgrammingLanguage;
use Illuminate\Database\Seeder;

class ProgramInProgrammingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgramInProgrammingLanguage::factory(20)->create();
    }
}
