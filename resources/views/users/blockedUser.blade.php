@extends('layouts.app')

@section('title', 'Ваш акаунт заблокований')

@section('meta_tags')
    <meta http-equiv="refresh" content="120; {{ route('main') }}">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/blocked_user.css') }}">
@endsection

@section('content')
    <div class="blocked-user">
        @if($user->blocked_until !== null)
        <h3 class="blocked-user__title">Ваш акаунт заблокований</h3>
        <p class="blocked-user__text">
            Ваш акаунт <strong class="blocked-user__text--important">{{ $user->login }}</strong>
            заблокований до <strong class="blocked-user__text--important">{{ $user->blocked_until }}</strong>.
        </p>
        <p class="blocked-user__text">
            Всі внесені зміни не будуть зрерігатися.
        </p>
        <p class="blocked-user__text">
            Ви можете користуватися акаунтом як не зареєстрований користувач поки не мине блокування.
        </p>
        @else
            <h3 class="blocked-user__title">Ваш акаунт активний</h3>
        @endif
    </div>
@endsection