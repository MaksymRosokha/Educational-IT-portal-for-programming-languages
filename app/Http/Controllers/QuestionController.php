<?php

namespace App\Http\Controllers;

use App\Http\Requests\questionsAndAnswers\CreateQuestionRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function showPage()
    {
        return view('questionsAndAnswers.questions', ['questions' => $this->getQuestions(),]);
    }

    public function create(CreateQuestionRequest $request)
    {
        $data = $request->validated();
        $questionData = [
            'user_id' => Auth::user()->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'created_at' => date('Y-m-d H-i-m'),
            'updated_at' => date('Y-m-d H-i-m'),
        ];

        Question::query()->insert($questionData);
        if ($request->ajax()) {
            return view('questionsAndAnswers.generateQuestions', ['questions' => $this->getQuestions()]);
        }
        return redirect()->back();
    }

    public function getQuestions()
    {
        return Question::query()->orderByDesc('created_at')->orderByDesc('id')->get();
    }
}
