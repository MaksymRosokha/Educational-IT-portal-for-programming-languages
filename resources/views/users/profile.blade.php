@extends('layouts.app')

@section('title')
    {{ $user->login }}
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

@section('scripts')
    <script src="/js/profile.js" defer></script>
@endsection
@section('content')

    <div id="profile" class="profile">
        <div class="profile__general-information">
            <h2 class="profile__title">@if($isOwnProfile)
                    Ваш профіль
                @else
                    Профіль {{ $user->login }}
                @endif</h2>
        </div>
        <div class="profile__wrapper">
            <img class="profile__avatar"
                 src="/storage/images/users/avatars/{{ $user->avatar }}"
                 alt="">
            <div class="profile__info-wrapper">
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Логін:</label>
                    <p class="profile__field-information">{{ $user->login }}</p>
                </div>
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Email: </label>
                    <p class="profile__field-information">{{ $user->email }}</p>
                </div>
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Ім'я: </label>
                    <p class="profile__field-information">{{ $user->name }}</p>
                </div>
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Дата народження: </label>
                    <p class="profile__field-information">{{ $user->date_of_birthday }}</p>
                </div>
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Про вас: </label>
                    <p class="profile__field-information">{{ $user->about_me }}</p>
                </div>
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Дата реєстрації: </label>
                    <p class="profile__field-information">{{ $user->created_at }}</p>
                </div>
                <div class="profile__info-block">
                    <label class="profile__name-of-field-information" for="">Дата останнього оновлення: </label>
                    <p class="profile__field-information">{{ $user->updated_at }}</p>
                </div>
            </div>
        </div>
        @if($isOwnProfile)
            <div class="profile__additional-abilities additional-abilities">
                <button-with-modal-window class="additional-abilities__button"
                                          button-text="Змінити пароль">
                    <password-changer class="password-changer"
                                      link="{{ route('changePassword') }}">
                    </password-changer>
                </button-with-modal-window>

                <button-with-modal-window class="additional-abilities__button"
                                          button-text="Редагувати профіль">
                    Редагуваня профілю
                </button-with-modal-window>
                <button-with-modal-window class="additional-abilities__button"
                                          button-text="Видалити акаунт">
                    Видалення акаунту
                </button-with-modal-window>
            </div>
        @endif
    </div>
@endsection