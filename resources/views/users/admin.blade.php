@extends('layouts.app')

@section('title')
    Адмін-панель
@endsection

@section('content')
    <div>
        <h2>Адмін-панель</h2>
    </div>
    <div>
        <form action="#" method="POST">
            <input type="text" placeholder="Пошук">
            <button type="submit">Пошук</button>
        </form>
    </div>
    <div>
        @foreach($users as $user)
            <div>
                <label for="">Id:</label>
                <p>{{ $user->id }}</p>
                <label for="">email:</label>
                <p>{{ $user->email }}</p>
                <label for="">Логін:</label>
                <p>{{ $user->login }}</p>
                <label for="">Ім'я:</label>
                <p>{{ $user->name }}</p>
                <label for="">Активний:</label>
                <p>{{ $user->active === 1 ? "Так" : "Ні" }}</p>
                @if(!empty($user->blocked_until))
                    <label for="">Заблокований до:</label>
                    <p>{{ $user->blocked_until }}</p>
                @endif
                <label for="">Аватар:</label>
                <br>
                <img src="/storage/images/users/avatars/{{ $user->avatar }}" alt="">
                <br>
                <label for="">Дата народження:</label>
                <p>{{ $user->date_of_birthday }}</p>
                <label for="">Про користувача:</label>
                <p>{{ $user->about_me }}</p>
                <label for="">Дата створення:</label>
                <p>{{ $user->created_at }}</p>
                <label for="">Дата оновлення:</label>
                <p>{{ $user->updated_at }}</p>
                <label for="">Роль:</label>
                <select name="role">
                    <option>Користувач</option>
                    <option @if($user->admin === 1) selected @endif>Адміністратор</option>
                </select>
                <button type="submit">Заблокувати</button>
                <button type="submit"><a href="{{ route('deleteUser', $user->id) }}">Видалити</a></button>
                <hr>
            </div>
        @endforeach
    </div>
@endsection