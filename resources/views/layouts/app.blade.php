<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="/storage/images/icon.png" type="image/icon type">
    <link rel="stylesheet" href="/css/reboot.css"/>
    <link rel="stylesheet" href="/css/app.css?v=1"/>
    <link rel="stylesheet" href="/css/header.css"/>
    <link rel="stylesheet" href="/css/footer.css"/>
    @yield('styles')
    <script src="/js/app.js" defer></script>
    @yield('scripts')
</head>
<body>
<div id="app" class="container">
    <header id="header">
        @include('partials.header')
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer id="footer">
        @include('partials.footer')
    </footer>
</div>
</body>
</html>