<h1>Навчальний IT-портал для мов програмування</h1>

@guest('web')
    <a href="{{ route('login') }}">Вхід</a>
    <a href="{{ route('signUp') }}">Реєстрація</a>
@endguest
@auth('web')
    <a href="{{ route('logout') }}">Вихід</a>
@endauth