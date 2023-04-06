@extends('layouts.app')

@section('title')
    Вхід
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/signIn.css">
@endsection

@section('content')
    <section class="sign-in">
        <div class="sign-in__wrapper">
            <h2 class="sign-in__title">Вхід</h2>
            <form class="sign-in__form sign-in-form" action="{{ route('loginProcess') }}" method="POST">
                @csrf

                @error('email')
                <p class="sign-in-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-in-form__label" for="email-field">Email:</label>
                <input id="email-field"
                       class="sign-in-form__input-field"
                       type="email"
                       name="email"
                       placeholder="Введіть ваш email"
                       required
                       maxlength="320"
                       minlength="3">
                @error('password')
                <p class="sign-in-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-in-form__label" for="password-field">Пароль:</label>
                <input id="password-field"
                       class="sign-in-form__input-field"
                       type="password"
                       name="password"
                       placeholder="Введіть ваш пароль"
                       required
                       minlength="6"
                       maxlength="100">
                <form-button class="sign-in-form__do-sign-in" type="submit">Увійти</form-button>
            </form>
            <table class="sign-in__additional-links">
                <tr class="additional-link sign-in__forgot-password">
                    <th class="additional-link__label">Забули пароль?</th>
                    <td class="additional-link__link">
                        <a class="additional-link__link" href="#">Відновити</a>
                    </td>
                </tr>
                <tr class="additional-link sign-in__sign-up">
                    <th class="additional-link__label">Не маєте акаунту?</th>
                    <td class="additional-link__link">
                        <a class="additional-link__link" href="{{ route('signUp') }}">Реєстрація</a>
                    </td>
                </tr>
            </table>
        </div>
    </section>
@endsection