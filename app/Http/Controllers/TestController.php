<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CreateTestRequest;
use App\Http\Requests\admin\DeleteTestRequest;
use App\Models\AnswerOptionForTest;
use App\Models\Lesson;
use App\Models\QuestionForTest;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TestController extends Controller
{
    public function calculateTest(Request $request)
    {
        $validatedAnswers = $this->validateUserTestData($request);
        $test = Test::query()->findOrFail($request['test_id']);
        $numberOfCorrectAnswers = 0;

        foreach ($validatedAnswers as $validAnswer) {
            $numberOfCorrectAnswers += $validAnswer->is_correct ? 1 : 0;
        }

        TestResult::query()->updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'test_id' => $test->id,
            ],
            [
                'percentage_result' => round($numberOfCorrectAnswers / count($validatedAnswers) * 100) . '%',
                'relative_result' => $numberOfCorrectAnswers . '/' . count($validatedAnswers),
            ]
        );

        return redirect()->back();
    }

    public function validateUserTestData(Request $request)
    {
        $request->validate([
            'test_id' => ['required', 'int', Rule::exists('tests', 'id')],
        ]);
        $data = $request->all();
        $test = Test::query()->findOrFail($data['test_id']);

        $validQuestions = [];
        $validAnswers = [];

        $userQuestions = array_keys($data);
        $userQuestionsIterator = 0;
        $userAnswers = array_values($data);
        $userAnswersIterator = 0;
        unset($userQuestions[0], $userQuestions[1], $userAnswers[0], $userAnswers[1]);

        foreach ($test->questions as $question) {
            $isUserQuestionsValid = false;

            foreach ($userQuestions as $userQuestion) {
                $tempQuestion = QuestionForTest::query()->findOrFail($userQuestion);
                if ($question->id == $tempQuestion->id) {
                    $isUserQuestionsValid = true;
                    $validQuestions[$userQuestionsIterator] = $tempQuestion;
                    $userQuestionsIterator++;
                    break;
                }
            }
            if (!$isUserQuestionsValid) {
                abort(404);
            }
        }

        foreach ($validQuestions as $validQuestion) {
            $isUserAnswersValid = false;

            foreach ($validQuestion->answerOptions as $answerOption) {
                foreach ($userAnswers as $userAnswer) {
                    $tempAnswer = AnswerOptionForTest::query()->findOrFail($userAnswer);

                    if ($answerOption->id == $tempAnswer->id) {
                        $isUserAnswersValid = true;
                        $validAnswers[$userAnswersIterator] = $tempAnswer;
                        $userAnswersIterator++;
                        break;
                    }
                }
            }

            if (!$isUserAnswersValid) {
                abort(404);
            }
        }

        return $validAnswers;
    }

    public function createTest(CreateTestRequest $request)
    {
        $data = $request->all();
        $lesson = Lesson::query()->findOrFail($data['lesson_id']);
        $test = null;
        $questions = [];
        $isCorrectAnswer = false;

        $userQuestions = [];
        $userAnswersByQuestion = [];
        $userCheckedAnswers = [];

        foreach ($data as $index => $item) {
            if (str_contains($index, "question_text-")) {
                $userQuestions[] = $item;
            }
            if (str_contains($index, "answer-")) {
                $indexesTemp = explode("answer-", $index);
                [$questionID, $answerID] = explode('-', $indexesTemp[1]);
                $userAnswersByQuestion[$questionID][$answerID] = $item;
            }
            if (str_contains($index, "answer_checked-")) {
                $indexesTemp = explode("answer_checked-", $index);
                $userCheckedAnswers[$indexesTemp[1]] = $item;
            }
        }

        $test = Test::create([
            'lesson_id' => $lesson->id,
        ]);

        $lesson->test_id = $test->id;
        $lesson->save();

        foreach ($userQuestions as $userQuestionIndex => $userQuestion) {
            $questions[$userQuestionIndex] = QuestionForTest::create([
                'test_id' => $test->id,
                'text' => $userQuestion,
            ]);
        }

        foreach ($userAnswersByQuestion as $userQuestionIndex => $userAnswers) {
            foreach ($questions as $questionIndex => $question) {
                if ($userQuestionIndex == $questionIndex) {
                    foreach ($userAnswers as $userAnswerIndex => $userAnswer) {
                        foreach ($userCheckedAnswers as $userCheckedAnswerQuestionIndex => $userCheckedAnswer) {
                            if ($userCheckedAnswerQuestionIndex == $questionIndex) {
                                if ($userCheckedAnswer == $userAnswerIndex) {
                                    $isCorrectAnswer = true;
                                    break;
                                } else {
                                    $isCorrectAnswer = false;
                                    break;
                                }
                            }
                        }
                        AnswerOptionForTest::create([
                            'question_for_test_id' => $question->id,
                            'text' => $userAnswer,
                            'is_correct' => $isCorrectAnswer,
                        ]);
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function deleteTest(DeleteTestRequest $request) {
        $data = $request->validated();
        $test = Test::query()->findOrFail($data['id']);
        $lessons = Lesson::query()->where('test_id', '=', $test->id)->get();

        $lessons->each(function ($item) {
            $item->update([
                'test_id' => null,
            ]);
        });
        $test->delete();

        return redirect()->back()->with(['deleteTestResult' => "Тест успішно видалено"]);
    }
}
