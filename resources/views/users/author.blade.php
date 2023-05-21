@section('styles')
    <link rel="stylesheet" href="{{ asset('css/author.css') }}">
@endsection

<div class="author">
    <a href="{{ route('user', ['login' => $user->login]) }}" class="author__link">
        <img src="{{ asset('storage/images/users/avatars/' . $user->avatar) }}"
             alt="Аватар автора"
             class="author__avatar">
        <span class="author__login">
            {{ $user->login }}
            @if($user->admin === 1)
                <img src="{{ asset('storage/images/users/admin/adminVerification.png') }}"
                     alt="Адміністратор"
                     class="author__admin-verification">
            @endif
        </span>
    </a>
</div>