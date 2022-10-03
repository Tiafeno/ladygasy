<!doctype html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- App css -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('hyper/css/app.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('hyper/css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style" /> -->
    <link href="{{ asset('hyper/css/app-creative.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
</head>

<body data-layout-color="light" data-leftbar-theme="light" data-layout-mode="fluid" data-rightbar-onstart="true">
    <div class="menu-bg" id="menu-bg"></div>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- Page Contents -->
        <div class="position-relative">
            <div id="header__top">
                <x-menu-primary></x-menu-primary>
            </div>
            @yield('slider')
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Bundle -->
    <script src="{{ asset('hyper/js/vendor.js') }}"></script>
    <script src="{{ asset('hyper/js/app.js') }}"></script>
</body>
</html>
