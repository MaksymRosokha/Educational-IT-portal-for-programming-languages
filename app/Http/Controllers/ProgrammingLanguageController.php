<?php

namespace App\Http\Controllers;

use App\Models\ProgramInProgrammingLanguage;
use App\Models\ProgrammingLanguage;

/**
 * This class is controller for programming languages
 */
class ProgrammingLanguageController extends Controller
{

    /**
     * Shows one programming language page by ID.
     *
     * @param int $id programming language ID
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showOneLanguage($id)
    {
        $programmingLanguage = ProgrammingLanguage::query()->findOrFail($id);
        return view('programmingLanguages.programmingLanguage', ['programmingLanguage' => $programmingLanguage]);
    }

    /**
     * Shows program by ID
     *
     * @param int $programID program ID
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProgram($programID)
    {
        if (!intval($programID)) {
            abort(404);
        }
        return view(
            'programmingLanguages.programsInProgrammingLanguage.program',
            ['program' => ProgramInProgrammingLanguage::query()->findOrFail($programID)]
        );
    }
}
