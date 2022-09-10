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
                        <a class="list-group-item flex-column">Home</a>
                        <a class="list-group-item flex-column">About</a>
                        <a class="list-group-item flex-column">Contact</a>
                        <a class="list-group-item flex-column">Blog</a>
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
                <img width="75" src="{{ asset('images/logo.png') }}">
            </a>
        </li>
        <li class="nav-item header-top-end" >
          <!-- Forms -->
          <div class="dropdown">
            <a class="arrow-none dropdown-toggle" data-bs-toggle="dropdown" href="#" aria-haspopup="true"
              aria-expanded="false">
              <span class="material-icons-outlined">shopping_cart</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
              <!-- item-->
              <div class="dropdown-item noti-title px-3">
                <h5 class="m-0">
                  Panier
                </h5>
              </div>

              <div class="px-3" style="max-height: 300px;" data-simplebar>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-2">
                  <div class="card-body">
                    <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="notify-icon bg-primary">
                          <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 text-truncate ms-2">
                        <h5 class="noti-item-title fw-semibold font-14">Datacorp <small class="fw-normal text-muted ms-1">1
                            min ago</small></h5>
                        <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                      </div>
                    </div>
                  </div>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                  <div class="card-body">
                    <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="notify-icon bg-info">
                          <i class="mdi mdi-account-plus"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 text-truncate ms-2">
                        <h5 class="noti-item-title fw-semibold font-14">Admin <small class="fw-normal text-muted ms-1">1
                            hours ago</small></h5>
                        <small class="noti-item-subtitle text-muted">New user registered</small>
                      </div>
                    </div>
                  </div>
                </a>


                <div class="text-center">
                  <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                </div>
              </div>

              <!-- All-->
              <a href="javascript:void(0);"
                class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                View All
              </a>

            </div>
          </div>

        </li>
      </ul>
</div>
