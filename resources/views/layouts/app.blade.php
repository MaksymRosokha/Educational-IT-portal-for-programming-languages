<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="css/app.css"/>
    <script src="js/app.js" defer></script>
</head>
<body>
<header>
    @include('partials.header')
</header>

<main>
    @yield('content')
</main>

<footer>
    @include('partials.footer')
</footer>
</body>
</html>