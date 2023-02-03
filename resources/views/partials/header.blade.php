<h1>Навчальний IT-портал для мов програмування</h1>

@if( !isset($isMainPage) ||  $isMainPage === false)
    <a href="{{ route('main') }}">Головна</a>
@endif
@guest('web')
    <a href="{{ route('login') }}">Вхід</a>
    <a href="{{ route('signUp') }}">Реєстрація</a>
@endguest
@auth('web')
    <a href="{{ route('logout') }}">Вихід</a>
    <a href="{{ route('profile', auth('web')->user()->login) }}">Профіль</a>
@endauth