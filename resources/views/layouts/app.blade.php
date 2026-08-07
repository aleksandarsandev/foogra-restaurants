<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Foogra - Discover & Book the best restaurants')</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

<header class="{{ $headerClass ?? 'header_in' }} clearfix">
    <div class="container">
        <div id="logo">
            <a href="{{ route('home') }}">
                <img src="{{ \App\Models\SiteSetting::imageUrl('logo_sticky', 'img/logo_sticky.png') }}" width="140" height="35" alt="Foogra">
            </a>
        </div>
        <ul id="top_menu">
            @guest
                <li><a href="{{ route('login') }}" class="login">Sign In</a></li>
            @endguest
        </ul>
        <a href="#0" class="open_close">
            <i class="icon_menu"></i><span>Menu</span>
        </a>
        <nav class="main-menu">
            <div id="header_menu">
                <a href="#0" class="open_close">
                    <i class="icon_close"></i><span>Menu</span>
                </a>
                <a href="{{ route('home') }}"><img src="{{ \App\Models\SiteSetting::imageUrl('logo', 'img/logo.png') }}" width="140" height="35" alt=""></a>
            </div>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('restaurants.index') }}">Restaurants</a></li>
                @guest
                    <li><a href="{{ route('register') }}">Sign Up</a></li>
                @endguest
                @auth
                    <li class="submenu">
                        <a href="#0" class="show-submenu">{{ auth()->user()->name }}</a>
                        <ul>
                            <li><a href="{{ route('user.bookings') }}" style="background:none;padding:7px 15px;font-size:0.8125rem;font-family:'Poppins',sans-serif;color:#444;">My Bookings</a></li>
                            <li><a href="{{ route('user.reviews') }}" style="background:none;padding:7px 15px;font-size:0.8125rem;font-family:'Poppins',sans-serif;color:#444;">My Reviews</a></li>
                            @if(auth()->user()->restaurants()->exists())
                            <li><a href="{{ route('user.restaurants') }}" style="background:none;padding:7px 15px;font-size:0.8125rem;font-family:'Poppins',sans-serif;color:#444;">My Restaurants</a></li>
                            @endif
                            <li><a href="{{ route('restaurants.submit') }}" style="background:none;padding:7px 15px;font-size:0.8125rem;font-family:'Poppins',sans-serif;color:#444;">Submit a Restaurant</a></li>
                            @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}" style="background:none;padding:7px 15px;font-size:0.8125rem;font-family:'Poppins',sans-serif;color:#444;">Admin Panel</a></li>
                            @endif
                            <li><form action="{{ route('logout') }}" method="POST" style="margin:0;padding:0;">@csrf<button type="submit" style="background:none;border:none;cursor:pointer;padding:7px 15px;width:100%;text-align:left;font-size:0.8125rem;font-family:'Poppins',sans-serif;color:#444;">Sign Out</button></form></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

<main>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible m-0" role="alert">
            <div class="container">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <h3 data-bs-target="#collapse_1">Quick Links</h3>
                <div class="collapse dont-collapse-sm links" id="collapse_1">
                    <ul>
                        <li><a href="{{ route('restaurants.index') }}">All Restaurants</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 data-bs-target="#collapse_2">Categories</h3>
                <div class="collapse dont-collapse-sm links" id="collapse_2">
                    <ul>
                        <li><a href="{{ route('restaurants.index', ['sort' => 'rating']) }}">Best Rated</a></li>
                        <li><a href="{{ route('restaurants.index', ['sort' => 'price_asc']) }}">Best Price</a></li>
                        <li><a href="{{ route('restaurants.index', ['sort' => 'newest']) }}">Newest</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 data-bs-target="#collapse_3">Contacts</h3>
                <div class="collapse dont-collapse-sm contacts" id="collapse_3">
                    <ul>
                        <li><i class="icon_house_alt"></i>97845 Baker st. 567<br>Los Angeles - US</li>
                        <li><i class="icon_mobile"></i>+94 423-23-221</li>
                        <li><i class="icon_mail_alt"></i><a href="#">info@foogra.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 data-bs-target="#collapse_4">Keep in touch</h3>
                <div class="collapse dont-collapse-sm" id="collapse_4">
                    <div class="follow_us">
                        <h5>Follow Us</h5>
                        <ul>
                            <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                            <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row add_bottom_25">
            <div class="col-lg-6">
                <ul class="footer-selector clearfix">
                </ul>
            </div>
            <div class="col-lg-6">
                <ul class="additional_links">
                    <li><a href="#0">Terms and conditions</a></li>
                    <li><a href="#0">Privacy</a></li>
                    <li><span>© Foogra {{ date('Y') }}</span></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<div id="toTop"></div>
<div class="layer"></div>

<script src="{{ asset('js/common_scripts.min.js') }}"></script>
<script src="{{ asset('js/common_func.js') }}"></script>
@yield('js')
</body>
</html>
