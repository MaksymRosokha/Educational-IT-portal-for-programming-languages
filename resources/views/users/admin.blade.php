@extends('layouts.app')

@section('title', 'Адмін-панель')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js') }}" defer></script>
@endsection

@section('content')
    <section class="admin">
        <h2 class="admin__title">Адмін-панель</h2>
        <div class="admin__search search">
            <input type="text"
                   id="search-text"
                   name="search-text"
                   class="search__field"
                   placeholder="Пошук">
        </div>
        <div class="admin__users users">
            @include("users.generateUsers", [$users])
        </div>
    </section>
@endsection