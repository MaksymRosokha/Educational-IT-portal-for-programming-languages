<?php

namespace App\Http\Requests\questionsAndAnswers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SearchAnswersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'question_id' => ['required', 'int'],
            'searchText' => ['sometimes'],
            'isOnlyMy' => ['required', 'nullable'],
        ];
    }
}
