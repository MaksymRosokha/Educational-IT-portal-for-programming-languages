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
                <label for="sign-in-form__input-field" class="sign-in-form__label">Email:</label>
                <input class="sign-in-form__input-field" type="email" name="email" placeholder="Введіть ваш email"
                       required maxlength="320" minlength="3">
                @error('password')
                <p class="sign-in-form__error">{{ $message }}</p>
                @enderror
                <label for="sign-in-form__input-field" class="sign-in-form__label">Пароль:</label>
                <input class="sign-in-form__input-field" type="password" name="password"
                       placeholder="Введіть ваш пароль" required minlength="6" maxlength="100">
                <button class="sign-in-form__do-sign-in" type="submit">Увійти</button>
            </form>
            <div class="sign-in__additional-links">
                <div class="additional-link sign-in__forgot-password">
                    <label class="additional-link__label" for="">Забули пароль?</label>
                    <a class="additional-link__link" href="#">Відновити</a>
                </div>
                <div class="additional-link sign-in__sign-up">
                    <label class="additional-link__label" for="">Не маєте акаунту?</label>
                    <a class="additional-link__link" href="{{ route('signUp') }}">Реєстрація</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        let items = document.querySelectorAll('.sign-in-form__input-field');
        items.forEach(input => {
            input.addEventListener('select', () => {
                input.style.backgroundColor = 'transparent';
            });
        });
    </script>
@endsection