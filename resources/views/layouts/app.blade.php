<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Real Estate</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
<link rel="stylesheet" href="{{ asset('assets1/fonts/icomoon/style.css') }}">

<link rel="stylesheet" href="{{ asset('assets1/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/mediaelementplayer.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/fonts/flaticon/font/flaticon.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/css/fl-bigmug-line.css') }}">

<link rel="stylesheet" href="{{ asset('assets1/css/aos.css') }}">

<link rel="stylesheet" href="{{ asset('assets1/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/showcase.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">

        <div class="site-navbar mt-4">
        <div class="container py-1">
          <div class="row align-items-center">
            <div class="col-8 col-md-8 col-lg-4">
              <h1 class="mb-0"><a href="{{ url('/') }}" class="text-white h2 mb-0"><strong>Real Estate<span class="text-danger">.</span></strong></a></h1>
            </div>
            <div class="col-4 col-md-4 col-lg-8">
              <nav class="site-navigation text-right text-md-right" role="navigation">

                <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

                <ul class="site-menu js-clone-nav d-none d-lg-block">
                  <li class="active">
                    <a href="{{ url('/home') }}">Home</a>
                  </li>

                  <li class="has-children">
                    <a href="#">Properties</a>
                    <ul class="dropdown arrow-top">
                    @foreach ($homeTypes as $hometype)
                           <li><a href="{{ route('display.prop.hometype', $hometype->hometypes) }}">{{ $hometype->hometypes }}</a></li>

                          @endforeach
                     
                    </ul>
                  </li>
                  <li><a href="{{ route('props.about') }}">About</a></li>
                  <!-- <li><a href="contact.html">Contact</a></li> -->
                  @guest
                                    @if (Route::has('login'))
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                    @endif
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @endif
                                    @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.requests') }}">
                                        <i class="fas fa-list mr-2"></i>My Requests
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.saved.properties') }}">
                                        <i class="fas fa-heart mr-2"></i>Saved Properties
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
                    </ul>
                </div>
            </div>
        </nav> 
           

          </div>
        </div>
      </div>
    </div>


    <div class="slide-one-item home-slider owl-carousel">
    @if(isset($props) && count($props) > 0)
        @foreach($props->take(9) as $prop)
        <div class="site-blocks-cover overlay" style="background-image: url({{ asset('assets1/images/'.$prop->image) }});" data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-10">
                        <span class="d-inline-block bg-danger text-white px-3 mb-3 property-offer-type rounded">For Sale</span>
                        <h1 class="mb-2">{{ $prop->title }}</h1>
                        <p class="mb-5"><strong class="h2 font-weight-bold">PHP {{ number_format((float) $prop->price) }}</strong></p>
                        <p><a href="{{ url('prop-details/'.$prop->id) }}" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">See Details</a></p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="site-blocks-cover overlay" style="background-image: url({{ asset('assets1/images/1745941300.jpg') }});" data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-10">
                        <span class="d-inline-block bg-danger text-white px-3 mb-3 property-offer-type rounded">For Sale</span>
                        <h1 class="mb-2">Find Your Dream Home</h1>
                        <p class="mb-5"><strong class="h2 font-weight-bold">Exclusive Properties</strong></p>
                        <p><a href="{{ url('/home') }}" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">Browse Properties</a></p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<footer class="site-footer py-2 text-center">
      <div class="container">
        <p class="mb-0">Copyright &copy; {{ date('Y') }} Real Estate Management System. All rights reserved.</p>
      </div>
    </footer>

    <script src="{{ asset('assets1/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets1/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('assets1/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets1/js/popper.min.js') }}"></script>
<script src="{{ asset('assets1/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets1/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets1/js/mediaelement-and-player.min.js') }}"></script>
<script src="{{ asset('assets1/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('assets1/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets1/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets1/js/aos.js') }}"></script>

<script src="{{ asset('assets1/js/main.js') }}"></script>

</body>
</html>
