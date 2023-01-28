@extends('layouts.app')

@section('title')
    Вхід
@endsection

@section('content')
    <section>
        <h2>Вхід</h2>
        <form action="{{ route('login_process') }}" method="POST">
            @csrf

            @error('email')
            <p>{{ $message }}</p>
            @enderror
            <input type="text" name="email" placeholder="Введіть email">
            <br>
            @error('password')
            <p>{{ $message }}</p>
            @enderror
            <input type="password" name="password" placeholder="Введіть пароль">
            <br>
            <button type="submit">Увійти</button>
        </form>
        <a href="{{ route('signUp') }}">Реєстрація</a>
    </section>
@endsection