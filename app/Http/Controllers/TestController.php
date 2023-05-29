<?php

namespace App\Http\Controllers;

use App\Models\AnswerOptionForTest;
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

    public function validateUserTestData(Request $request){
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
}
