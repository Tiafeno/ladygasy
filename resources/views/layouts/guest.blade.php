<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Styles -->

    <!-- App css -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('hyper/css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('hyper/css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <!--<link href="{{ asset('hyper/css/app-creative-dark.css') }}" rel="stylesheet" type="text/css" id="dark-style" />-->
</head>

<body data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">

    <div class="menu-bg" id="menu-bg"></div>
    <!-- Begin page -->
    <div class="wrapper">
      <!-- Page Contents -->
      <div class="position-relative">
          <div id="header__top">
              <x-menu-primary></x-menu-primary>
          </div>

          <main class="py-4">
            <div style="margin-top: calc(50vh - 16em)"></div>
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
