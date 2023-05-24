<?php

namespace App\Http\Controllers;

use App\Http\Requests\questionsAndAnswers\DeleteQuestionRequest;
use App\Http\Requests\questionsAndAnswers\CreateQuestionRequest;
use App\Http\Requests\questionsAndAnswers\LoadMoreQuestions;
use App\Http\Requests\questionsAndAnswers\SearchQuestionsRequest;
use App\Http\Requests\questionsAndAnswers\ShowOnlyMyQuestionsRequest;
use App\Http\Requests\questionsAndAnswers\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function showPage()
    {
        return view('questionsAndAnswers.questions', [
            'questions' => $this->getQuestions(),
            'countOfQuestions' => Question::query()->count('id'),
        ]);
    }

    public function showMoreQuestions(LoadMoreQuestions $request)
    {
        $data = $request->validated();
        $limit = $data['limit'];

        if ($request->boolean('isOnlyMy')) {
            $questions = Question::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit($limit)
                ->get();
            $countOfQuestions = Question::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        } else {
            $questions = Question::query()
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit($limit)
                ->get();
            $countOfQuestions = Question::query()
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        }

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateQuestions', [
                'questions' => $questions,
                'countOfQuestions' => $countOfQuestions,
            ]);
        }
        return view('questionsAndAnswers.questions', [
            'questions' => $questions,
            'countOfQuestions' => $countOfQuestions,
        ]);
    }

    public function getQuestions(int $limit = 10)
    {
        return Question::query()->orderByDesc('created_at')->orderByDesc('id')->limit($limit)->get();
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

        $countOfQuestions = Question::query()->count('id');

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateQuestions', [
                'questions' => $this->getQuestions(),
                'countOfQuestions' => $countOfQuestions,
            ]);
        }
        return $this->showPage();
    }

    public function update(UpdateQuestionRequest $request)
    {
        $data = $request->validated();
        $question = Question::query()->findOrFail($data['id']);

        $question->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }

    public function delete(DeleteQuestionRequest $request)
    {
        $data = $request->validated();
        $question = Question::query()->findOrFail($data['id']);

        $question->delete();

        return redirect()->route('questions');
    }

    public function showOnlyMyQuestions(ShowOnlyMyQuestionsRequest $request)
    {
        $countOfQuestions = Question::query()->count('id');

        if ($request->boolean('isOnlyMy')) {
            $questions = Question::query()
                ->where('user_id', '=', Auth::user()->id)
                ->limit(10)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfQuestions = Question::query()
                ->where('user_id', '=', Auth::user()->id)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');

            if ($request->ajax()) {
                return view('questionsAndAnswers.generateQuestions', [
                    'questions' => $questions,
                    'countOfQuestions' => $countOfQuestions,
                    ]);
            }
            return view('questionsAndAnswers.questions', [
                'questions' => $questions,
                'countOfQuestions' => $countOfQuestions,
            ]);
        }
        if ($request->ajax()) {
            return view('questionsAndAnswers.generateQuestions', [
                'questions' => $this->getQuestions(),
                'countOfQuestions' => $countOfQuestions,
                ]);
        }
        return view('questionsAndAnswers.questions', [
            'questions' => $this->getQuestions(),
            'countOfQuestions' => $countOfQuestions,
            ]);
    }

    public function search(SearchQuestionsRequest $request)
    {
        $data = $request->validated();
        $questions = $this->getQuestions();

        if ($request->boolean('isOnlyMy')) {
            $questions = Question::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->limit(10)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfQuestions = Question::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        } else {
            $questions = Question::query()
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->limit(10)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
            $countOfQuestions = Question::query()
                ->where('title', 'LIKE', '%' . $data['searchText'] . '%')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->count('id');
        }

        if ($request->ajax()) {
            return view('questionsAndAnswers.generateQuestions', [
                'questions' => $questions,
                'countOfQuestions' => $countOfQuestions,
            ]);
        }
        return view('questionsAndAnswers.questions', [
            'questions' => $questions,
            'countOfQuestions' => $countOfQuestions,
        ]);
    }
}
