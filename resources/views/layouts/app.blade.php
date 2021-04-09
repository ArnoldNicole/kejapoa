    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
     <script src="{{asset('js/manifest.js')}}"></script>
    <script src="{{asset('js/vendor.js')}}"></script>
    <script src="{{asset('js/app.js')}}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
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
    <!-- ClickDesk Live Chat Service for websites -->
    <script type='text/javascript'>
    var _glc =_glc || []; _glc.push('all_ag9zfmNsaWNrZGVza2NoYXRyEgsSBXVzZXJzGICAiL_j9L0LDA');
    var glcpath = (('https:' == document.location.protocol) ? 'https://my.clickdesk.com/clickdesk-ui/browser/' : 
    'http://my.clickdesk.com/clickdesk-ui/browser/');
    var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');
    var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; 
    glcspt.async = true; glcspt.src = glcpath + 'livechat-cloud-new.js';
    var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);
    </script>
    <!-- End of ClickDesk -->
</body>
</html>
