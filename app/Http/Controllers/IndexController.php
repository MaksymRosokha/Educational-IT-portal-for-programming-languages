<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for main page
 */
class IndexController extends Controller
{
    /**
     * Shows main page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $isAdmin = Auth::check() &&  Auth::user()->admin === 1;

        return view('main', [
            'isMainPage' => true,
            'isAdmin' => $isAdmin,
            'programmingLanguages' => ProgrammingLanguage::all()
        ]);
    }
}
