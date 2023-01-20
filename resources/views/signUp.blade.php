@extends('layouts.app')

@section('title')
    Реєстрація
@endsection

@section('content')
    <section>
        <h2>Реєстрація</h2>
        <form action="#" method="POST">
            @csrf
            <input type="text" name="email" placeholder="Введвть email">
            <input type="password" name="password" placeholder="Введіть пароль">
            <button type="submit">Зареєструватися</button>
        </form>
        <a href="{{ route('login') }}">Вхід</a>
    </section>
@endsection