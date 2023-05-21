<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function showPage($questionID)
    {
        if (!intval($questionID)) {
            abort(404);
        }

        return view('questionsAndAnswers.answers', [
            'question' => Question::query()->findOrFail($questionID),
            'answers' => Answer::query()->where('question_id', '=', $questionID)->get(),
        ]);
    }
}
