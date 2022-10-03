<div>
  <style>
    #header__slider {
    height: 100vh;
    background: #f5f5f5 url("{{ asset('images/coffee-scrub-orange-en_0x484_001.png') }}") no-repeat bottom center;
  }
  </style>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endauth
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <div id="menu">
                <div id="menu-bar">
                    <div id="bar1" class="bar"></div>
                    <div id="bar2" class="bar"></div>
                    <div id="bar3" class="bar"></div>
                </div>
                <nav class="nav_ mt-4" id="nav">
                    <div class="list-group d-flex">
                        <a href="{{route('home')}}" class="list-group-item flex-column">Accueil</a>
                        <a class="list-group-item flex-column" href="{{route('index.category', ['slug' => 'huile-de-risain'])}}">Huille de risain</a>
                        <a class="list-group-item flex-column">Contact</a>
                        @auth()
                            <a class="list-group-item flex-column"
                                onclick="event.preventDefault(); document.querySelector('#logout-form').submit();">
                                Déconnexion</a>
                        @else
                            <a class="list-group-item flex-column" href="{{ route('login') }}">
                                Connexion</a>
                        @endauth
                    </div>
                </nav>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" title="Lady Gasy">
                <img width="125" class="rounded" src="{{ asset('images/logo.png') }}">
            </a>
        </li>
        <li class="nav-item header-top-end mini-cart">
            <x-cart-mini-component></x-cart-mini-component>
        </li>
      </ul>
</div>
