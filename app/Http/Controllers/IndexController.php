<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('main', ['isMainPage' => true]);
    }
}
