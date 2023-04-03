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
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('layouts.components._navbar')

        <main class="my-4">
            @yield('content')
        </main>
    </div>
    @yield('script')
</body>
</html>
