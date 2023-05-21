@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
@endsection

<div class="header">
    <nav class="header__container">
        <div class="info">
            <a class="info__link" href="{{ route('main') }}">
                <img class="info__logo" src="{{ asset('storage/images/icon.png') }}" alt="Логотип">
            </a>
            <a class="info__link" href="{{ route('main') }}">
                <h1 class="info__title">Навчальний IT-портал для мов програмування</h1>
            </a>
        </div>
        <div class="references">
            @if( !isset($isMainPage) || $isMainPage === false)
                <a class="references__link" href="{{ route('main') }}">Головна</a>
            @endif

            <a class="references__link" href="{{ route('questions') }}">Питання та відповіді</a>

            @guest('web')
                <a class="references__link" href="{{ route('login') }}">Вхід</a>
                <a class="references__link" href="{{ route('signUp') }}">Реєстрація</a>
            @endguest

            @auth('web')
                <a class="references__link" href="{{ route('user', auth('web')->user()->login) }}">Профіль</a>

                @if(auth('web')->user()->admin === 1)
                    <a class="references__link" href="{{ route('admin') }}">Адмін-панель</a>
                @endif

                <a class="references__link" href="{{ route('logout') }}">Вихід</a>
            @endauth
        </div>
    </nav>
</div>
