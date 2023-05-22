<?php

namespace App\Http\Controllers;

use App\Http\Requests\questionsAndAnswers\CreateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function showPage($questionID)
    {
        if (!intval($questionID)) {
            abort(404);
        }

        return view('questionsAndAnswers.answers', [
            'question' => Question::query()->findOrFail($questionID),
            'answers' => $this->getAnswers($questionID),
        ]);
    }

    public function create(CreateAnswerRequest $request)
    {
        $data = $request->validated();
        $answerData = [
            'user_id' => Auth::user()->id,
            'question_id' => $data['question_id'],
            'text' => $data['text'],
            'created_at' => date('Y-m-d H-i-m'),
            'updated_at' => date('Y-m-d H-i-m'),
        ];

        Answer::query()->insert($answerData);
        if ($request->ajax()) {
            return view('questionsAndAnswers.generateAnswers', [
                'answers' => $this->getAnswers($data['question_id'])
            ]);
        }
        return redirect()->back();
    }

    public function getAnswers(int $questionID)
    {
        return Answer::query()
            ->where('question_id', '=', $questionID)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
    }
}
