@extends('layouts.app')

@section('title')
    Адмін-панель
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
    <div class="admin">
        <h2 class="admin__title">Адмін-панель</h2>
        <div class="admin__search search">
            <form class="search__form" action="#" method="POST">
                <input class="search__field" type="text" placeholder="Пошук">
                <button class="search__submit" type="submit">Шукати</button>
            </form>
        </div>
        <div class="admin__users users">
            @foreach($users as $user)
                <div class="users__user user">
                    <div class="user__avatar avatar">
                        <img class="avatar__image"
                             src="/storage/images/users/avatars/{{ $user->avatar }}"
                             alt="">
                    </div>
                    <div class="user__text-info">
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Id:</label>
                            <p class="user__info">{{ $user->id }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">email:</label>
                            <p class="user__info">{{ $user->email }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Логін:</label>
                            <p class="user__info">{{ $user->login }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Ім'я:</label>
                            <p class="user__info">{{ $user->name }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Активний:</label>
                            <p class="user__info">{{ $user->active === 1 ? "Так" : "Ні" }}</p>
                        </div>
                        @if(!empty($user->blocked_until))
                            <div class="user__info-block">
                                <label class="user__name-of-info" for="user__info">Заблокований до:</label>
                                <p class="user__info">{{ $user->blocked_until }}</p>
                            </div>
                        @endif
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Дата народження:</label>
                            <p class="user__info">{{ $user->date_of_birthday }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Про користувача:</label>
                            <p class="user__info">{{ $user->about_me }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Дата створення:</label>
                            <p class="user__info">{{ $user->created_at }}</p>
                        </div>
                        <div class="user__info-block">
                            <label class="user__name-of-info" for="user__info">Дата оновлення:</label>
                            <p class="user__info">{{ $user->updated_at }}</p>
                        </div>
                    </div>

                    <div class="user__additional-abilities additional-abilities">
                        <div class="additional-abilities__ability role">
                            <label class="role__name" for="role__selector">Роль:</label>
                            <select class="role__selector" name="role">
                                <option class="role__point">Користувач</option>
                                <option class="role__point" @if($user->admin === 1) selected @endif>Адміністратор
                                </option>
                            </select>
                        </div>
                        <button class="additional-abilities__ability additional-abilities__block"
                                type="submit">
                            Заблокувати
                        </button>
                        <button class="additional-abilities__ability additional-abilities__delete"
                                type="submit">
                            <a class="additional-abilities__link"
                               href="{{ route('deleteUser', $user->id) }}">Видалити</a>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection