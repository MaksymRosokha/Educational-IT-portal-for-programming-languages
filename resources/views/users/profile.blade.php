@extends('layouts.app')

@section('title')
    {{ $user->login }}
@endsection

@section('content')
    <div>
        <h2>Ваш профіль</h2>
    </div>
    <div>
        <img src="/storage/images/users/avatars/{{ $user->avatar }}" alt="Аватар не знайдений">
        <br>
        <label for="">Логін: </label>
        <p>{{ $user->login }}</p>
        <label for="">Email: </label>
        <p>{{ $user->email }}</p>
        <label for="">Ім'я: </label>
        <p>{{ $user->name }}</p>
        <label for="">Дата народження: </label>
        <p>{{ $user->date_of_birthday }}</p>
        <label for="">Про вас: </label>
        <p>{{ $user->about_me }}</p>
    </div>
    @if($isOwnProfile)
        <div>
            <button>Редагувати профіль</button>
        </div>
    @endif
@endsection