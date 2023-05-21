<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function showPage()
    {
        return view('questionsAndAnswers.questions', [
            'questions' => Question::all(),
        ]);
    }
}
