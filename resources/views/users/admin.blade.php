@extends('layouts.app')

@section('title')
    Адмін-панель
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
    <section class="admin">
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
                             alt="Аватар користувача {{ $user->login }}">
                    </div>
                    <table class="user__text-info">
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Id:</th>
                            <td class="user__info">{{ $user->id }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">email:</th>
                            <td class="user__info">{{ $user->email }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Логін:</th>
                            <td class="user__info">{{ $user->login }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Ім'я:</th>
                            <td class="user__info">{{ $user->name }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Активний:</th>
                            <td class="user__info">{{ $user->active === 1 ? "Так" : "Ні" }}</td>
                        </tr>
                        @if(!empty($user->blocked_until))
                            <tr class="user__info-block">
                                <th class="user__name-of-info">Заблокований до:</th>
                                <td class="user__info">{{ $user->blocked_until }}</td>
                            </tr>
                        @endif
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Дата народження:</th>
                            <td class="user__info">{{ $user->date_of_birthday }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Про користувача:</th>
                            <td class="user__info">{{ $user->about_me }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Дата створення:</th>
                            <td class="user__info">{{ $user->created_at }}</td>
                        </tr>
                        <tr class="user__info-block">
                            <th class="user__name-of-info">Дата оновлення:</th>
                            <td class="user__info">{{ $user->updated_at }}</td>
                        </tr>
                    </table>

                    <div class="user__additional-abilities additional-abilities">
                        <div class="additional-abilities__ability role">
                            <label class="role__name">Роль:</label>
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
{{--                            <a class="additional-abilities__link"--}}
{{--                               href="{{ route('deleteUser', $user->id) }}">Видалити</a>--}}
                            Видалити
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection