@extends('layouts.app')

@section('title', 'Restaurants - Foogra')

@section('css')
<link href="{{ asset('css/listing.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page_header element_to_stick">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Restaurants</li>
                    </ul>
                </div>
                <h1>{{ $restaurants->total() }} restaurants found</h1>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-5">
                <form method="get" action="{{ route('restaurants.index') }}" class="search_bar_list d-flex">
                    <input type="text" name="q" class="form-control" placeholder="Search restaurants..." value="{{ request('q') }}">
                    <input type="submit" value="Search">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container margin_30_40">
    <div class="row">
        <aside class="col-lg-3" id="sidebar_fixed">
            <form method="get" action="{{ route('restaurants.index') }}" id="filter-form">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                <div class="clearfix">
                    <div class="sort_select">
                        <select name="sort" id="sort" onchange="document.getElementById('filter-form').submit()">
                            <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Sort by Popularity</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Sort by Rating</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort by Newness</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    <a href="#0" class="open_filters btn_filters"><i class="icon_adjust-vert"></i><span>Filters</span></a>
                </div>

                <div class="filter_col">
                    <div class="inner_bt"><a href="#" class="open_filters"><i class="icon_close"></i></a></div>

                    <div class="filter_type">
                        <h4><a href="#filter_1" data-bs-toggle="collapse" class="opened">Categories</a></h4>
                        <div class="collapse show" id="filter_1">
                            <ul>
                                @foreach($categories as $category)
                                <li>
                                    <label class="container_check">{{ $category->name }}
                                        <input type="checkbox" name="category[]" value="{{ $category->slug }}" {{ in_array($category->slug, (array) request('category', [])) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="filter_type">
                        <h4><a href="#filter_2" data-bs-toggle="collapse" class="closed">Cuisine</a></h4>
                        <div class="collapse" id="filter_2">
                            <ul>
                                @foreach($cuisines as $cuisine)
                                <li>
                                    <label class="container_check">{{ $cuisine->name }}
                                        <input type="checkbox" name="cuisine[]" value="{{ $cuisine->slug }}" {{ in_array($cuisine->slug, (array) request('cuisine', [])) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="filter_type">
                        <h4><a href="#filter_3" data-bs-toggle="collapse" class="closed">Rating</a></h4>
                        <div class="collapse" id="filter_3">
                            <ul>
                                <li><label class="container_check">Superb 9+
                                    <input type="checkbox" name="rating[]" value="9" {{ in_array('9', (array) request('rating', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                                <li><label class="container_check">Very Good 8+
                                    <input type="checkbox" name="rating[]" value="8" {{ in_array('8', (array) request('rating', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                                <li><label class="container_check">Good 7+
                                    <input type="checkbox" name="rating[]" value="7" {{ in_array('7', (array) request('rating', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                                <li><label class="container_check">Pleasant 6+
                                    <input type="checkbox" name="rating[]" value="6" {{ in_array('6', (array) request('rating', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                            </ul>
                        </div>
                    </div>

                    <div class="filter_type">
                        <h4><a href="#filter_4" data-bs-toggle="collapse" class="closed">Price Range</a></h4>
                        <div class="collapse" id="filter_4">
                            <ul>
                                <li><label class="container_check">$ Budget
                                    <input type="checkbox" name="price[]" value="1" {{ in_array('1', (array) request('price', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                                <li><label class="container_check">$$ Moderate
                                    <input type="checkbox" name="price[]" value="2" {{ in_array('2', (array) request('price', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                                <li><label class="container_check">$$$ Upscale
                                    <input type="checkbox" name="price[]" value="3" {{ in_array('3', (array) request('price', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                                <li><label class="container_check">$$$$ Fine Dining
                                    <input type="checkbox" name="price[]" value="4" {{ in_array('4', (array) request('price', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label></li>
                            </ul>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="btn_1 full-width">Apply Filters</button>
                        <a href="{{ route('restaurants.index') }}" class="btn_1 full-width outline mt-2">Clear All</a>
                    </div>
                </div>
            </form>
        </aside>

        <div class="col-lg-9">
            <div class="row">
                @forelse($restaurants as $restaurant)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <img src="{{ asset('img/lazy-placeholder.png') }}" data-src="{{ $restaurant->featured_image_url }}" class="img-fluid lazy" alt="{{ $restaurant->name }}">
                            <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="strip_info">
                                <small>{{ $restaurant->categories->first()?->name ?? '' }}</small>
                                <div class="item_title">
                                    <h3>{{ $restaurant->name }}</h3>
                                    <small>{{ $restaurant->address }}</small>
                                </div>
                            </a>
                        </figure>
                        <ul>
                            <li><span>{{ $restaurant->price_symbol }}{{ $restaurant->avg_price ? ' · Avg $' . $restaurant->avg_price : '' }}</span></li>
                            <li>
                                <div class="score">
                                    <span>{{ $restaurant->rating_label }}<em>{{ $restaurant->review_count }} Reviews</em></span>
                                    <strong>{{ number_format($restaurant->avg_rating, 1) }}</strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <h4>No restaurants found</h4>
                    <p class="text-muted">Try adjusting your filters or search term.</p>
                    <a href="{{ route('restaurants.index') }}" class="btn_1">Clear Filters</a>
                </div>
                @endforelse
            </div>

            @if($restaurants->hasPages())
            <div class="pagination_fg">
                {{ $restaurants->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('js/specific_listing.js') }}"></script>
@endsection
