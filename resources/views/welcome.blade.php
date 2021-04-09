<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{ config('app.name') }}</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('css/app.css')}}" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('vendor/simple-line-icons/css/simple-line-icons.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

  <!-- Plugin CSS -->
  {{-- <link rel="stylesheet" href="{{asset('device-mockups/device-mockups.min.css')}}"> --}}

  <!-- Custom styles for this template -->
  <link href="{{asset('css/new-age.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/mycss.css">
   <script src="{{asset('js/manifest.js')}}"></script>
  <script src="{{asset('js/vendor.js')}}"></script>
  <script src="{{asset('js/app.js')}}" defer></script>
</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
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
              <a class="nav-link js-scroll-trigger" href="/login">Login</a>
            </li>
            @endif                           
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/register">Register</a>
            </li>
            @endif
            @else
            {{-- <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/profile">My Profile</a>
            </li> --}}
            <li class="nav-item">
                <a  class="nav-link dropdown-toggle" href="/profile">
                    {{ Auth::user()->name }}
                </a>
            </li>
            @endguest
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#download">Discover</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#features">Houses</a>
          </li>                     
        </ul>
      </div>
    </div>
  </nav>

  <header class="masthead">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-lg-7 my-auto">
          <div class="header-content mx-auto">
            <h1 class="mb-5">Keja search is a one stop location for all your house search business. Find your desired locations, the house you need and begin renting.</h1>
            <a class="btn btn-outline btn-xl js-scroll-trigger" href="/register">Register for free</a><br>
            

          </div>
        </div>
        <div class="col-lg-5 my-auto">
          <div class="header-content mx-auto">
            <h1 class="mb-5">Place your houses for rent on our platform and reach more tenants. Begin your journey as a digital landlord now</h1>
            <a href="/new_landlord" class="btn btn-outline-info btn-xl js-scroll-trigger"> Start Renting Out</a>
          </div>
        </div>
      </div>
    </div>
  </header>
 <div id="app">
   <section class="features" id="features">
     <div class="container">
       <div class="section-heading text-center">
         <h2>Find Unlimited rooms</h2>
         <p class="text-muted">In Unlimited locations!</p>     
       </div>
       <div class="row justify-content-center">
         <div class="col-md-12">
           <h4 class="h4 text-capitalize text-info">Search Houses</h4>
           <div class="row">
             <div class="col-md-12">
               <div class="form-group row">
                 <label class="text-md-right col-form-label col-md-4">House Search</label>
                 <div class="col-md-8 input-group">
                   <input type="text" id="FindHouse" class="form-control" placeholder="Type your search">
                 </div>
               </div>
             </div>
           </div>

           <div class="row justify-content-center">
             <div class="col-md-12" id="HouseResults">
               
             </div>
           </div>

           <div class="row justify-content-center" id="loader" style="display: none;">
             <div class="col-3">
             <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
               <span class="sr-only">Loading...</span>
             </div>
             <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
               <span class="sr-only">Loading...</span>
             </div>
             </div>
           </div>         

         </div>
       </div>
       <div class="container-fluid" id="app">
         <details-data :authenticated="@auth true @else false @endauth" :houses="{{$featuredHouses}}"/>
        {{-- @foreach($featuredHouses as $featuredHouse)
          <div class="col-lg-3 my-auto">
            <div class="device-container">
              <div class="device-mockup iphone6_plus portrait white">
                <div class="device">
                  <div class="screen">
                    Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else!
                    <img src="img/img_1.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="button text-center">
                    <details :house="$featuredHouse"></details>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach --}}
       </div>
     </div>
   </section>
   <section class="download bg-primary text-center" id="download">
     <div class="container">
       <div class="row">
         <div class="col-md-8 mx-auto">{{request()->cookie('chat_session')}}
            {{-- <get-help :chat_data="<?php
              $value = request()->cookie('chat_session');
               if($value==''){
                echo 'null';
                 } else{
                  echo request()->cookie('chat_session');
                } ?>"></get-help> --}}
           <h2 class="section-heading">Discover what all the buzz is about!</h2>

           <p>Download Our App</p>

           <div class="badges">
             <a class="badge-link" href="#"><img src="img/google-play-badge.svg" alt=""></a>
             {{-- <a class="badge-link" href="#"><img src="img/app-store-badge.svg" alt=""></a> --}}
           </div>
         </div>
       </div>
     </div>
   </section>
   <section class="contact bg-primary" id="contact">
     <div class="container">
       <h2>We
         <i class="fas fa-heart"></i>
         new members
       </h2>
       <ul class="list-inline list-social">
         <li class="list-inline-item social-twitter">
           <a href="#">
             <i class="fab fa-twitter"></i>
           </a>
         </li>
         <li class="list-inline-item social-facebook">
           <a href="#">
             <i class="fab fa-facebook-f"></i>
           </a>
         </li>
         <li class="list-inline-item social-google-plus">
           <a href="#">
             <i class="fab fa-google-plus-g"></i>
           </a>
         </li>
       </ul>
     </div>
   </section>
 </div>     

  <footer>
    <div class="container">
      <p>&copy;KejaPoa  Reserved.</p>
      <ul class="list-inline">
        <li class="list-inline-item">
          <a href="#">Privacy</a>
        </li>
        <li class="list-inline-item">
          <a href="#">Terms</a>
        </li>
        <li class="list-inline-item">
          <a href="#">FAQ</a>
        </li>
      </ul>
    </div>
  </footer>
  <!-- Bootstrap core JavaScript -->
  {{-- <script type="text/javascript" src="{{asset('/js/app.js')}}"></script> --}}
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
  <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Plugin JavaScript -->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for this template -->
  <script src="{{ asset('js/new-age.min.js')}}"></script>
  {{-- <script src="{{ asset('js/debounce.js')}}"></script> --}}
  <script type="text/javascript" src="{{ asset('/js/search.js')}}"></script> 

</body>

</html>
