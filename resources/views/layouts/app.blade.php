<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="/storage/images/icon.png" type="image/icon">
    <link rel="stylesheet" href="/css/reboot.css">
    <link rel="stylesheet" href="/css/helpers.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
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