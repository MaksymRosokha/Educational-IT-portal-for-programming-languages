<?php

namespace App\Http\Controllers;

use App\Http\Requests\questionsAndAnswers\CreateAnswerRequest;
use App\Http\Requests\questionsAndAnswers\DeleteAnswerRequest;
use App\Http\Requests\questionsAndAnswers\LoadMoreAnswers;
use App\Http\Requests\questionsAndAnswers\SearchAnswersRequest;
use App\Http\Requests\questionsAndAnswers\ShowOnlyMyAnswersRequest;
use App\Http\Requests\questionsAndAnswers\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function showPage($questionID)
    {
        if (!intval($questionID)) {
            abort(404);
        }

        $countOfAnswers = Answer::query()
            ->where('question_id', '=', $questionID)
            ->count('id');

        return view('questionsAndAnswers.answers', [
            'question' => Question::query()->findOrFail($questionID),
            'answers' => $this->getAnswers(questionID: $questionID),
            'countOfAnswers' => $countOfAnswers,
        ]);
    }

    public function showMoreAnswers(LoadMoreAnswers $request){
        $data = $request->validated();
        $limit = $data['limit'];

        if ($request->boolean('isOnlyMy')) {
            $answers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('user_id', '=', Auth::user()->id)
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->limit($limit)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfAnswers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('user_id', '=', Auth::user()->id)
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        } else {
            $answers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->limit($limit)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfAnswers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        }

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateAnswers', [
                'answers' => $answers,
                'countOfAnswers' => $countOfAnswers,
            ]);
        }
        return view('questionsAndAnswers.answers', [
            'question' => Question::query()->findOrFail($data['question_id']),
            'answers' => $answers,
            'countOfAnswers' => $countOfAnswers,
        ]);
    }

    public function getAnswers(int $questionID, int $limit = 10)
    {
        return Answer::query()
            ->where('question_id', '=', $questionID)
            ->limit($limit)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
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

        $countOfAnswers = Answer::query()
            ->where('question_id', '=', $data['question_id'])
            ->count('id');

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateAnswers', [
                'answers' => $this->getAnswers($data['question_id']),
                'countOfAnswers' => $countOfAnswers,
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

    public function showOnlyMyAnswers(ShowOnlyMyAnswersRequest $request)
    {
        $data = $request->validated();
        $countOfAnswers = Answer::query()
            ->where('question_id', '=', $data['question_id'])
            ->count('id');

        if ($request->boolean('isOnlyMy')) {
            $answers = Answer::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('question_id', '=', $data['question_id'])
                ->limit(10)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfAnswers = Answer::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('question_id', '=', $data['question_id'])
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');

            if ($request->ajax()) {
                return view('questionsAndAnswers.generateAnswers', [
                    'answers' => $answers,
                    'countOfAnswers' => $countOfAnswers,
                ]);
            }
            return view('questionsAndAnswers.answers', [
                'answers' => $answers,
                'countOfAnswers' => $countOfAnswers,
            ]);
        }
        if ($request->ajax()) {
            return view(
                'questionsAndAnswers.generateAnswers', [
                    'answers' => $this->getAnswers($data['question_id']),
                    'countOfAnswers' => $countOfAnswers,
                ]
            );
        }
        return view('questionsAndAnswers.answers', [
            'answers' => $this->getAnswers($data['question_id']),
            'countOfAnswers' => $countOfAnswers,
        ]);
    }

    public function search(SearchAnswersRequest $request)
    {
        $data = $request->validated();

        if ($request->boolean('isOnlyMy')) {
            $answers = Answer::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->limit(10)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfAnswers = Answer::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        } else {
            $answers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->limit(10)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfAnswers = Answer::query()
                ->where('question_id', '=', $data['question_id'])
                ->where('text', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        }

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateAnswers', [
                'answers' => $answers,
                'countOfAnswers' => $countOfAnswers,
            ]);
        }
        return view('questionsAndAnswers.answers', [
            'answers' => $answers,
            'question' => $countOfAnswers,
        ]);
    }

    public function getAnswerByID(Request $request) {
        return Answer::query()->findOrFail($request['id']);
    }
}
