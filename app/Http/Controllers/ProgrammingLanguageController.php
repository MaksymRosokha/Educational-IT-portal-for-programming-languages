<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingLanguage;
use Illuminate\Http\Request;

/**
 * This class is controller for programming languages
 */
class ProgrammingLanguageController extends Controller
{

    /**
     * Shows page of programming languages.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPage(){
        return view('programmingLanguages.programmingLanguages', ['programmingLanguages' => ProgrammingLanguage::all()]);
    }

    /**
     * Shows one programming language page by id.
     *
     * @param int $id programming language id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showOneLanguage($id){
        $programmingLanguage = ProgrammingLanguage::query()->findOrFail($id);
        return view('programmingLanguages.programmingLanguage', ['programmingLanguage' => $programmingLanguage]);
    }
}
