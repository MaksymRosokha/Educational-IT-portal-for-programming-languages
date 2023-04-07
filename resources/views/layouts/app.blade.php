<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">

    <meta name="author" content="Росоха Максим Валентинович">
    <meta name="copyright" content="Росоха Максим Валентинович">
    <meta name="address" content="Україна, Закарпатська область, Хустський район, село Нижній Бистрий">

    <meta name="description"
          content="Навчальний IT-портал для мов програмування — це онлайн-ресурс, який надає безкоштовну та
          зручну платформу для вивчення різних мов програмування. Серед основних мов, які доступні на сайті,
          можна виділити Java, C++, JavaScript, С#, PHP та інші. Сайт пропонує навчальні матеріали різного
          рівня складності, які допоможуть як новачкам у програмуванні, так і досвідченим програмістам розширити
          свої знання та вміння. Кожен урок на сайті містить теоретичний матеріал, приклади коду та вправи, що
          допоможуть закріпити знання та використовувати їх на практиці. Навчальний IT-портал для мов програмування
          є ідеальним місцем для тих, хто хоче покращити свої навички у програмуванні та розвиватися в цій галузі.">
    <meta name="keywords"
          content="it, IT portal, programming, IT-портал, навчання, learning, програмування, Java, C++, JavaScript, PHP, C#, уроки, lessons, вправи, онлайн-ресурс, ">

    <meta property="og:title" content="Навчальний IT-портал для мов програмування — @yield('title')">
    <meta property="og:local" content="uk_UA">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('main') }}">
    <meta property="og:image" content="/storage/images/icon.png">
    <meta property="og:site_name" content="Навчальний IT-портал для мов програмування">
    <meta property="og:description"
          content="Навчальний IT-портал для мов програмування — це онлайн-ресурс, який надає безкоштовну та
          зручну платформу для вивчення різних мов програмування.">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Навчальний IT-портал для мов програмування — @yield('title')">
    <meta name="twitter:description" content="Навчальний IT-портал для мов програмування — це онлайн-ресурс, який надає безкоштовну та
          зручну платформу для вивчення різних мов програмування.">
    <meta name="twitter:image" content="/storage/images/icon.png">

    <meta itemprop="name" content="Навчальний IT-портал для мов програмування — @yield('title')">
    <meta itemprop="description" content="Навчальний IT-портал для мов програмування — це онлайн-ресурс, який надає безкоштовну та
          зручну платформу для вивчення різних мов програмування.">
    <meta itemprop="image" content="/storage/images/icon.png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Навчальний IT-портал для мов програмування — @yield('title')</title>
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