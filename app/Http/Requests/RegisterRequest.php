<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'string', 'unique:users,email', 'min:3', 'max:320'],
            'login' => [
                'required',
                'string',
                'regex:/^[a-z0-9\._]+$/',
                'unique:users,login',
                'min:3',
                'max:50',
            ],
            'password' => ['required', 'string', 'min:6', 'max:100'],
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
