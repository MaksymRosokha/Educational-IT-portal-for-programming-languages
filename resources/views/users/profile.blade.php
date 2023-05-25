@extends('layouts.app')

@section('title', $user->login)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

    <section id="profile" class="profile">
        <div class="profile__general-information">
            <h2 class="profile__title">
                @if($isOwnProfile)
                    Ваш профіль
                @else
                    Профіль {{ $user->login }}
                @endif
            </h2>
        </div>
        <div class="profile__wrapper">
            <img class="profile__avatar"
                 src="{{ asset('storage/images/users/avatars/' . $user->avatar) }}"
                 alt="Аватар користувача {{ $user->login }}">
            <table class="profile__info-wrapper">
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Логін:</th>
                    <td class="profile__field-information">{{ $user->login }}</td>
                </tr>
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Email:</th>
                    <td class="profile__field-information">{{ $user->email }}</td>
                </tr>
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Ім'я:</th>
                    <td class="profile__field-information">{{ $user->name }}</td>
                </tr>
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Дата народження:</th>
                    <td class="profile__field-information">{{ $user->date_of_birthday }}</td>
                </tr>
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Про вас:</th>
                    <td class="profile__field-information">{{ $user->about_me }}</td>
                </tr>
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Дата реєстрації:</th>
                    <td class="profile__field-information">{{ $user->created_at }}</td>
                </tr>
                <tr class="profile__info-block">
                    <th class="profile__name-of-field-information">Дата останнього оновлення:</th>
                    <td class="profile__field-information">{{ $user->updated_at }}</td>
                </tr>
            </table>
        </div>
        @if($isOwnProfile)
            <div class="profile__additional-abilities additional-abilities">
                <button-with-modal-window class="additional-abilities__button"
                                          button-text="Змінити пароль"
                                          title="Змінення паролю">
                    <password-changer class="password-changer"
                                      link="{{ route('changePassword') }}"
                                      id="{{ $user->id }}">
                    </password-changer>
                </button-with-modal-window>

                <button-with-modal-window class="additional-abilities__button"
                                          button-text="Редагувати профіль"
                                          title="Редагуваня профілю">
                    <profile-editor class="profile-editor"
                                    link="{{ route('editProfile') }}"
                                    user="{{ $user }}">
                    </profile-editor>
                </button-with-modal-window>
                <button-with-modal-window class="additional-abilities__button"
                                          button-text="Видалити акаунт"
                                          title="Видалення акаунту">
                    <delete-confirmation class="user-deleter"
                                         link="{{ route('deleteUser') }}"
                                         id="{{ $user->id }}">
                    </delete-confirmation>
                </button-with-modal-window>
            </div>
        @endif
    </section>
@endsection