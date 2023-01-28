@extends('layouts.app')

@section('title')
    Реєстрація
@endsection

@section('content')
    <section>
        <h2>Реєстрація</h2>
        <form action="{{ route('registerUser') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @error('email')
            <p>{{ $message }}</p>
            @enderror
            <input type="email" name="email" placeholder="Введіть email" required maxlength="320" minlength="3">*
            <br>
            @error('login')
            <p>{{ $message }}</p>
            @enderror
            <input type="text" name="login" placeholder="Введіть login" required maxlength="50" minlength="3">*
            <br>
            @error('password')
            <p>{{ $message }}</p>
            @enderror
            <input type="password" name="password" placeholder="Введіть пароль" required minlength="6" maxlength="100">*
            <br>
            @error('name')
            <p>{{ $message }}</p>
            @enderror
            <input type="text" name="name" placeholder="Введіть ваше ім'я" minlength="2" maxlength="200">
            <br>
            @error('date_of_birthday')
            <p>{{ $message }}</p>
            @enderror
            <input type="date" name="date_of_birthday" min="1900-01-01" max="{{ date('Y-m-d') }}">
            <br>
            @error('avatar')
            <p>{{ $message }}</p>
            @enderror
            <input type="file" name="avatar" accept="image/*">
            <br>
            @error('about_me')
            <p>{{ $message }}</p>
            @enderror
            <textarea name="about_me" cols="30" rows="10" minlength="10" maxlength="2000"
                      placeholder="Напишіть інформацію про себе"></textarea>
            <br>
            <button type="submit">Зареєструватися</button>
        </form>
        <a href="{{ route('login') }}">Вхід</a>
    </section>
@endsection