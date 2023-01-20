@extends('layouts.app')

@section('title')
    Вхід
@endsection

@section('content')
    <section>
        <h2>Вхід</h2>
        <form action="#" method="POST">
            <input type="text" name="email" placeholder="Введіть email">
            <input type="password" name="password" placeholder="Введіть пароль">
            <button type="submit">Увійти</button>
        </form>
        <a href="{{ route('signup') }}">Реєстрація</a>
    </section>
@endsection