<?php

namespace App\Http\Controllers;

use App\Http\Requests\questionsAndAnswers\CreateAnswerRequest;
use App\Http\Requests\questionsAndAnswers\DeleteAnswerRequest;
use App\Http\Requests\questionsAndAnswers\SearchAnswersRequest;
use App\Http\Requests\questionsAndAnswers\ShowOnlyMyAnswersRequest;
use App\Http\Requests\questionsAndAnswers\UpdateAnswerRequest;
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
                'answers' => $this->getAnswers($data['question_id']),
            ]);
        }
        return $this->showPage($data['question_id']);
    }

    public function update(UpdateAnswerRequest $request)
    {
        $data = $request->validated();
        $answer = Answer::query()->findOrFail($data['id']);

        $answer->update(['text' => $data['text'],]);
    }

    public function delete(DeleteAnswerRequest $request)
    {
        $data = $request->validated();
        $answer = Answer::query()->findOrFail($data['id']);

        $answer->delete();

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

    public function showOnlyMyAnswers(ShowOnlyMyAnswersRequest $request)
    {
        $data = $request->validated();

        if ($request->boolean('isOnlyMy')) {
            $answers = Answer::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('question_id', '=', $data['question_id'])
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();

            if ($request->ajax()) {
                return view('questionsAndAnswers.generateAnswers', ['answers' => $answers]);
            }
            return view('questionsAndAnswers.answers', ['answers' => $answers]);
        }
        if ($request->ajax()) {
            return view(
                'questionsAndAnswers.generateAnswers',
                ['answers' => $this->getAnswers($data['question_id'])]
            );
        }
        return view('questionsAndAnswers.answers', ['answers' => $this->getAnswers($data['question_id'])]);
    }

    public function search(SearchAnswersRequest $request)
    {
        $data = $request->validated();
        $answers = $this->getAnswers($data['question_id']);

        if ($request->boolean('isOnlyMy')) {
            $answers = Answer::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
        } else {
            $answers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
        }

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateAnswers', ['answers' => $answers]);
        }
        return view('questionsAndAnswers.answers', [
            'answers' => $answers,
            'question' => Question::query()->findOrFail($data['question_id']),
        ]);
    }
}
