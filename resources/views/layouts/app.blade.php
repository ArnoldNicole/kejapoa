    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{asset('css/new-age.min.css')}}" rel="stylesheet"> --}}
    <style type="text/css">
      main {
        background: url("../img/bg-pattern.png"), #7b4397;
      background: url("../img/bg-pattern.png"), linear-gradient(to left, #7b4397, #dc2430);
       position: relative;
      width: auto;
       min-height: 100%;
       padding-top: 50px;
      }
    </style>
    @yield('styles')
     <script>
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        </script>
</head>
<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-light" id="mainNav">
          <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="/">Keja Search</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              Menu
              <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav ml-auto">
                    @guest
                    @if (Route::has('login'))
                  <li class="nav-item">
                    <a class="nav-link js-scroll-trigger text-dark font-weight-bold" href="/login">Login</a>
                  </li>
                  @endif                           
                @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link js-scroll-trigger text-dark font-weight-bold" href="/register">Register</a>
                  </li>
                  @endif
                  @else
                  {{-- <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="/profile">My Profile</a>
                  </li> --}}
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle font-weight-bold text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-dark font-weight-bold" href="/profile">
                              {{ __('Profile') }}
                          </a>
                          <a class="dropdown-item text-dark font-weight-bold" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>
                          

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </div>
                  </li>
                  @endguest
                <li class="nav-item">
                  <a class="nav-link js-scroll-trigger text-dark font-weight-bold" href="/#download">Discover</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link js-scroll-trigger text-dark font-weight-bold" href="/#features">Houses</a>
                </li>          
              </ul>
            </div>
          </div>
        </nav>

         <main class="py-4 pt-5">
            @yield('content')
        </main>
        
    </div>
</body>
</html>
