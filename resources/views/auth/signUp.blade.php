@extends('layouts.app')

@section('title', 'Реєстрація')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/signUp.css') }}">
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
                <label class="sign-up-form__label" for="email-field">Email:</label>
                <input id="email-field"
                       class="sign-up-form__input-field"
                       type="email"
                       name="email"
                       placeholder="Введіть email"
                       required
                       maxlength="320"
                       minlength="3">

                @error('login')
                <p class="sign-up-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-up-form__label" for="login-field">Login:</label>
                <input id="login-field"
                       class="sign-up-form__input-field"
                       type="text" name="login"
                       placeholder="Введіть login"
                       required
                       maxlength="50"
                       minlength="3">

                @error('password')
                <p class="sign-up-form__error">{{ $message }}</p>
                @enderror
                <label class="sign-up-form__label" for="password-field">Пароль:</label>
                <input id="password-field"
                       class="sign-up-form__input-field"
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
                    <label class="sign-up-form__label" for="name-field">Ім'я:</label>
                    <input id="name-field"
                           class="sign-up-form__input-field"
                           type="text"
                           name="name"
                           placeholder="Введіть ваше ім'я"
                           minlength="2"
                           maxlength="200">

                    @error('date_of_birthday')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="date-of-birthday-field">Дата народження:</label>
                    <input id="date-of-birthday-field"
                           class="sign-up-form__input-field sign-up-form__input-date"
                           type="date"
                           name="date_of_birthday"
                           min="1900-01-01"
                           max="{{ date('Y-m-d') }}">

                    @error('avatar')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="avatar-field">Аватар:</label>
                    <input id="avatar-field"
                           class="sign-up-form__input-field sign-up-form__input-file"
                           type="file"
                           name="avatar"
                           accept="image/*">

                    @error('about_me')
                    <p class="sign-up-form__error">{{ $message }}</p>
                    @enderror
                    <label class="sign-up-form__label" for="about-me-field">Інформація про вас:</label>
                    <textarea id="about-me-field"
                              class="sign-up-form__input-field sign-up-form__input-textarea"
                              name="about_me"
                              minlength="10"
                              maxlength="2000"
                              placeholder="Напишіть інформацію про себе"></textarea>

                </details>

                <form-button class="sign-up-form__do-register" type="submit">Зареєструватися</form-button>
            </form>
            <table class="sign-up__additional-links">
                <tr class="additional-link sign-up__sign-in">
                    <th class="additional-link__label">Вже маєте акаунт?</th>
                    <td class="additional-link__link">
                        <a class="additional-link__link" href="{{ route('login') }}">Вхід</a>
                    </td>
                </tr>
            </table>
        </div>
    </section>
@endsection