<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\ProgramInProgrammingLanguage;
use App\Models\ProgrammingLanguage;
use App\Models\User;
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
        $isAdmin = Auth::check() && Auth::user()->admin === 1;
        $statistics = [
            'programmingLanguages' => ProgrammingLanguage::query()->count(),
            'programs' => ProgramInProgrammingLanguage::query()->count(),
            'lessons' => Lesson::query()->count(),
            'users' => User::query()->count(),
        ];

        return view('main', [
            'isMainPage' => true,
            'isAdmin' => $isAdmin,
            'programmingLanguages' => ProgrammingLanguage::all(),
            'statistics' => $statistics,
        ]);
    }
}
