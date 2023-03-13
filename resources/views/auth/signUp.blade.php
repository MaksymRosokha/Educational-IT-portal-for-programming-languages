@extends('layouts.app')

@section('title')
    Реєстрація
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/signUp.css">
@endsection

@section('content')
    <section class="sign-up">
        <div class="sign-up__wrapper">
            <h2 class="sign-up__title">Реєстрація</h2>
            <form class="sign-up__form sign-up-form"
                  action="{{ route('registerProcess') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                @error('email')
                <p class="sign-up-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-up-form__label" for="sign-up-form__input-field">Email:</label>
                <input class="sign-up-form__input-field"
                       type="email"
                       name="email"
                       placeholder="Введіть email"
                       required
                       maxlength="320"
                       minlength="3">

                @error('login')
                <p class="sign-up-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-up-form__label" for="sign-up-form__input-field">Login:</label>
                <input class="sign-up-form__input-field"
                       type="text" name="login"
                       placeholder="Введіть login"
                       required
                       maxlength="50"
                       minlength="3">

                @error('password')
                <p class="sign-up-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-up-form__label" for="sign-up-form__input-field">Пароль:</label>
                <input class="sign-up-form__input-field"
                       type="password"
                       name="password"
                       placeholder="Введіть пароль"
                       required
                       minlength="6"
                       maxlength="100">

                <details class="sign-up-form__more-input-fields more-input-fields">
                    <summary class="more-input-fields__title">Заповнити більше інформації</summary>

                    @error('name')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="sign-up-form__input-field">Ім'я:</label>
                    <input class="sign-up-form__input-field"
                           type="text"
                           name="name"
                           placeholder="Введіть ваше ім'я"
                           minlength="2"
                           maxlength="200">

                    @error('date_of_birthday')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="sign-up-form__input-field">Дата народження:</label>
                    <input class="sign-up-form__input-field sign-up-form__input-date"
                           type="date"
                           name="date_of_birthday"
                           min="1900-01-01"
                           max="{{ date('Y-m-d') }}">

                    @error('avatar')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="sign-up-form__input-field">Аватар:</label>
                    <input class="sign-up-form__input-field sign-up-form__input-file"
                           type="file"
                           name="avatar"
                           accept="image/*">

                    @error('about_me')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="sign-up-form__input-field">Інформація про вас:</label>
                    <textarea class="sign-up-form__input-field sign-up-form__input-textarea"
                              name="about_me"
                              minlength="10"
                              maxlength="2000"
                              placeholder="Напишіть інформацію про себе"></textarea>

                </details>

                <button class="sign-up-form__do-register"
                        type="submit">
                    Зареєструватися
                </button>
            </form>
            <div class="sign-up__additional-links">
                <div class="additional-link sign-up__sign-in">
                    <label class="additional-link__label" for="additional-link__link">Вже маєте акаунт?</label>
                    <a class="additional-link__link" href="{{ route('login') }}">Вхід</a>
                </div>
            </div>
        </div>
    </section>
@endsection