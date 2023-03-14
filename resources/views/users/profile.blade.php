@extends('layouts.app')

@section('title')
    {{ $user->login }}
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

@section('content')
    <div class="profile">
        <div class="profile__general-information">
            <h2 class="profile__title">Ваш профіль</h2>
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
                <button class="additional-abilities__button additional-abilities__change-password">
                    Змінити пароль
                </button>
                <button class="additional-abilities__button additional-abilities__edit-profile">
                    Редагувати профіль
                </button>
                <button class="additional-abilities__button additional-abilities__delete-account">
                    Видалити акаунт
                </button>
            </div>
        @endif
    </div>
@endsection