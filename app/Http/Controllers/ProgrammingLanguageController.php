<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingLanguage;
use Illuminate\Http\Request;

/**
 * This class is controller for programming languages page
 */
class ProgrammingLanguageController extends Controller
{

    /**
     * This method opens programming languages page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPage(){
        return view('programmingLanguages.programmingLanguages', ['programmingLanguages' => ProgrammingLanguage::all()]);
    }

    /**
     * This function shows one programming language page.
     *
     * @param int $id programming language id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showOneLanguage(int $id){
        $programmingLanguage = ProgrammingLanguage::query()->find($id);
        return view('programmingLanguages.programmingLanguage', ['programmingLanguage' => $programmingLanguage]);
    }
}
