<header class="header">
    <div class="info">
        <img class="info__logo" src="/storage/images/icon.png" alt="">
        <h1 class="info__title">Навчальний IT-портал для мов програмування</h1>
    </div>
    <div class="references">
        @if( !isset($isMainPage) || $isMainPage === false)
            <a class="references__link" href="{{ route('main') }}">Головна</a>
        @endif
        @guest('web')
            <a class="references__link" href="{{ route('login') }}">Вхід</a>
            <a class="references__link" href="{{ route('signUp') }}">Реєстрація</a>
        @endguest
        @auth('web')
            <a class="references__link" href="{{ route('profile', auth('web')->user()->login) }}">Профіль</a>
            @if(auth('web')->user()->admin === 1)
                <a class="references__link" href="{{ route('admin') }}">Адмін-панель</a>
            @endif
            <a class="references__link" href="{{ route('logout') }}">Вихід</a>
        @endauth
    </div>
</header>