<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditProfileRequest extends FormRequest
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
            'id' => ['required', 'int'],
            'email' => ['email', 'string', 'unique:users,email', 'min:3', 'max:320'],
            'login' => [
                'string',
                'regex:/^[a-z0-9\._]+$/',
                'unique:users,login',
                'min:3',
                'max:50',
            ],
            'name' => ['nullable', 'string', 'max:200'],
            'date_of_birthday' => [
                'nullable',
                'date',
                'after:' . date('m/d/Y', strtotime('-1 day', strtotime(date('01/01/1900')))),
                'before:' . date('m/d/Y', strtotime('+1 day', strtotime(date('m/d/Y')))),
            ],
            'avatar' => ['nullable', 'image', 'max:10240'],
            'about_me' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
