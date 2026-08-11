@extends('layouts.app', ['headerClass' => 'header clearfix element_to_stick'])

@section('title', 'Foogra - Discover & Book the best restaurants')

@section('css')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

@php
    $heroUrl = \App\Models\SiteSetting::getValue('home_section_1');
    $heroBgUrl = $heroUrl ? (str_starts_with($heroUrl, 'img/') ? asset($heroUrl) : \Illuminate\Support\Facades\Storage::disk('s3')->url($heroUrl)) : null;
@endphp
<div class="hero_single version_2"{{ $heroBgUrl ? ' style="background-image: url('.$heroBgUrl.');"' : '' }}>
    <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-10 col-md-8">
                    <h1>{{ \App\Models\SiteSetting::getValue('home_hero_title') ?? 'Discover & Book' }}</h1>
                    <p>{{ \App\Models\SiteSetting::getValue('home_hero_subtitle') ?? 'The best restaurants at the best price' }}</p>
                    <form method="get" action="{{ route('restaurants.index') }}">
                        <div class="row g-0 custom-search-input">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="q" placeholder="Search restaurants..." value="{{ request('q') }}">
                                    <i class="icon_search"></i>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <input type="submit" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg_gray">
    <div class="container margin_60_40">
        <div class="main_title center">
            <span><em></em></span>
            <h2>Popular Categories</h2>
            <p>Browse restaurants by category</p>
        </div>
        @if($categories->isNotEmpty())
        <div class="owl-carousel owl-theme categories_carousel">
            @foreach($categories as $category)
            <div class="item">
                <a href="{{ route('restaurants.index', ['category' => $category->slug]) }}">
                    <span>{{ $category->restaurants_count ?? '' }}</span>
                    <i class="{{ $category->icon ?? 'icon-food_icon_pizza' }}"></i>
                    <h3>{{ $category->name }}</h3>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<div class="container margin_60_40">
    <div class="main_title">
        <span><em></em></span>
        <h2>Popular Restaurants</h2>
        <p>Top-rated restaurants near you</p>
        <a href="{{ route('restaurants.index') }}">View All</a>
    </div>

    @if($popular->isNotEmpty())
    <div class="owl-carousel owl-theme carousel_4">
        @foreach($popular as $restaurant)
        <div class="item">
            <div class="strip">
                <figure>
                    <img src="{{ asset('img/lazy-placeholder.png') }}" data-src="{{ $restaurant->featured_image_url }}" class="owl-lazy" alt="{{ $restaurant->name }}">
                    <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="strip_info">
                        <small>{{ $restaurant->categories->first()?->name ?? '' }}</small>
                        <div class="item_title">
                            <h3>{{ $restaurant->name }}</h3>
                            <small>{{ $restaurant->address }}</small>
                        </div>
                    </a>
                </figure>
                <ul>
                    <li><span class="loc_open">Now Open</span></li>
                    <li>
                        <div class="score">
                            <span>{{ $restaurant->rating_label }}<em>{{ $restaurant->review_count }} Reviews</em></span>
                            <strong>{{ number_format($restaurant->avg_rating, 1) }}</strong>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="banner lazy" data-bg="url({{ \App\Models\SiteSetting::imageUrl('banner_bg_desktop', 'img/banner_bg_desktop.jpg') }})">
        <div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.2)">
            <div>
                <small>foogra</small>
                <h3>{{ $featured->count() }}+ Great Restaurants</h3>
                <p>Book a table easily at the best price</p>
                <a href="{{ route('restaurants.index') }}" class="btn_1">View All</a>
            </div>
        </div>
    </div>

    @if($featured->isNotEmpty())
    <div class="row">
        <div class="col-12">
            <div class="main_title version_2">
                <span><em></em></span>
                <h2>Featured Restaurants</h2>
                <p>Our top picks for you</p>
                <a href="{{ route('restaurants.index') }}">View All</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="list_home">
                <ul>
                    @foreach($featured->take(3) as $restaurant)
                    <li>
                        <a href="{{ route('restaurants.show', $restaurant->slug) }}">
                            <figure>
                                <img src="{{ asset('img/location_list_placeholder.png') }}" data-src="{{ $restaurant->featured_image_url }}" alt="" class="lazy">
                            </figure>
                            <div class="score"><strong>{{ number_format($restaurant->avg_rating, 1) }}</strong></div>
                            <em>{{ $restaurant->categories->first()?->name ?? 'Restaurant' }}</em>
                            <h3>{{ $restaurant->name }}</h3>
                            <small>{{ $restaurant->address }}</small>
                            <ul>
                                <li>{{ $restaurant->price_symbol }}</li>
                                @if($restaurant->avg_price)
                                    <li>Average price ${{ $restaurant->avg_price }}</li>
                                @endif
                            </ul>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="list_home">
                <ul>
                    @foreach($featured->skip(3)->take(3) as $restaurant)
                    <li>
                        <a href="{{ route('restaurants.show', $restaurant->slug) }}">
                            <figure>
                                <img src="{{ asset('img/location_list_placeholder.png') }}" data-src="{{ $restaurant->featured_image_url }}" alt="" class="lazy">
                            </figure>
                            <div class="score"><strong>{{ number_format($restaurant->avg_rating, 1) }}</strong></div>
                            <em>{{ $restaurant->categories->first()?->name ?? 'Restaurant' }}</em>
                            <h3>{{ $restaurant->name }}</h3>
                            <small>{{ $restaurant->address }}</small>
                            <ul>
                                <li>{{ $restaurant->price_symbol }}</li>
                                @if($restaurant->avg_price)
                                    <li>Average price ${{ $restaurant->avg_price }}</li>
                                @endif
                            </ul>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="call_section lazy" data-bg="url({{ \App\Models\SiteSetting::imageUrl('bg_call_section', 'img/bg_call_section.jpg') }})">
        <div class="container clearfix">
            <div class="col-lg-5 col-md-6 float-end wow">
                <div class="box_1">
                    <h3>Are you a Restaurant Owner?</h3>
                    <p>Join Us to increase your online visibility. You'll have access to even more customers who are looking to enjoy your tasty dishes.</p>
                    @auth
                        <a href="{{ route('restaurants.submit') }}" class="btn_1">Get Started</a>
                    @else
                        <a href="{{ route('register') }}" class="btn_1">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/sticky_sidebar.min.js') }}"></script>
@endsection
