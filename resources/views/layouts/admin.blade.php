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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- App css -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('hyper/css/app.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('hyper/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('hyper/css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
  <!--<link href="{{ asset('hyper/css/app-creative-dark.css') }}" rel="stylesheet" type="text/css" id="dark-style" /> -->
  @routes
</head>

<body data-layout-color="dark" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
<div class="menu-bg" id="menu-bg"></div>
<!-- Begin page -->
<div class="wrapper" id="app">
  <x-menu-admin></x-menu-admin>
  <!-- Page Contents -->
  <div class="content-page">
    <div class="content">
      <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box">
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  @yield('breadcrumb')
                  <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
              </div>
              @yield('title')
            </div>
          </div>
        </div>
        <!-- end page title -->
        @yield('content')
      </div>

    </div>

  @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endauth
    <!-- Footer Start -->
    <footer class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <script>document.write(new Date().getFullYear())</script> © Tiafeno Finel
          </div>
          <div class="col-md-6">
            <div class="text-md-end footer-links d-none d-md-block">
              <a href="{{route('home')}}" target="_blank">Voir le site</a>
              <a href="javascript: void(0);"   onclick="event.preventDefault(); document.querySelector('#logout-form').submit();">Se deconnecter</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/manifest.js') }}" defer></script>
<script src="{{ asset('js/vendor.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('hyper/js/vendor.js') }}"></script>
<script src="{{ asset('hyper/js/app.js') }}"></script>
</body>
</html>
