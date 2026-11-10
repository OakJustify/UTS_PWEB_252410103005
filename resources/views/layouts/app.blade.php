<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tunas, pengelolaan kebun hidroponik rumahan untuk UTS Pemrograman Web 2026.">
    <title>@yield('title', 'Tunas')</title>
    <script>document.documentElement.classList.add('js');</script>
    <link rel="stylesheet" href="{{ asset('vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <x-navbar :username="$username ?? null" />

    @include('partials.flash')

    <main id="konten" class="page-shell">
        @yield('content')
    </main>

    <x-footer />

    <script src="{{ asset('vendor/aos/aos.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
