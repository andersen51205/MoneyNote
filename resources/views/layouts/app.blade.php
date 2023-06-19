<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- App Title --}}
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- Styles & Scripts --}}
    @vite([
        'resources/sass/app.scss',
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body>
    <header>
        {{-- 導航列 --}}
        @include('layouts.components.navbar')
    </header>
    <main>
        @yield('content')
    </main>
    @yield('script')
</body>
</html>
