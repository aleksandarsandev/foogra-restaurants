@extends('layouts.app')

@section('title', $restaurant->name . ' - Foogra')

@section('css')
<link href="{{ asset('css/detail-page.css') }}" rel="stylesheet">
<link href="{{ asset('css/review.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="hero_in detail_page background-image" data-background="url({{ $restaurant->featured_image_url }})">
    <div class="wrapper opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
        <div class="container">
            <div class="main_info">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6">
                        <div class="head">
                            <div class="score">
                                <span>{{ $restaurant->rating_label }}<em>{{ $restaurant->review_count }} Reviews</em></span>
                                <strong>{{ number_format($restaurant->avg_rating, 1) }}</strong>
                            </div>
                        </div>
                        <h1>{{ $restaurant->name }}</h1>
                        {{ $restaurant->categories->pluck('name')->join(' · ') }}
                        @if($restaurant->address) - {{ $restaurant->address }}@endif
                    </div>
                    <div class="col-xl-8 col-lg-7 col-md-6 position-relative">
                        <div class="buttons clearfix">
                            @if($restaurant->images->isNotEmpty())
                            <span class="magnific-gallery">
                                @foreach($restaurant->images as $img)
                                <a href="{{ $img->url }}" class="{{ $loop->first ? 'btn_hero' : '' }}" title="{{ $restaurant->name }}" data-effect="mfp-zoom-in">
                                    @if($loop->first)<i class="icon_image"></i>View photos @endif
                                </a>
                                @endforeach
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container margin_detail">
    <div class="row">
        <div class="col-lg-8">
            <div class="tabs_detail">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab" role="tab">Information</a>
                    </li>
                    <li class="nav-item">
                        <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">
                            Reviews <span class="badge bg-secondary">{{ $restaurant->review_count }}</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" role="tablist">
                    {{-- Information Tab --}}
                    <div id="pane-A" class="card tab-pane fade show active" role="tabpanel">
                        <div class="card-header" role="tab" id="heading-A">
                            <h5>
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A">Information</a>
                            </h5>
                        </div>
                        <div id="collapse-A" class="collapse" role="tabpanel">
                            <div class="card-body info_content">
                                @if($restaurant->description)
                                    <p>{{ $restaurant->description }}</p>
                                @endif

                                @if($restaurant->images->isNotEmpty())
                                <div class="add_bottom_25"></div>
                                <h2>Photos</h2>
                                <div class="pictures magnific-gallery clearfix">
                                    @foreach($restaurant->images->take(5) as $image)
                                    <figure>
                                        <a href="{{ $image->url }}" title="{{ $restaurant->name }}" data-effect="mfp-zoom-in">
                                            @if($loop->last && $restaurant->images->count() > 5)
                                                <span class="d-flex align-items-center justify-content-center">+{{ $restaurant->images->count() - 5 }}</span>
                                            @endif
                                            <img src="{{ asset('img/thumb_detail_placeholder.jpg') }}" data-src="{{ $image->url }}" class="lazy" alt="">
                                        </a>
                                    </figure>
                                    @endforeach
                                </div>
                                @endif

                                {{-- Menu --}}
                                @if($restaurant->menuSections->isNotEmpty())
                                <div class="add_bottom_25">
                                    <h2>{{ $restaurant->name }} Menu</h2>
                                    @foreach($restaurant->menuSections as $section)
                                    <h3>{{ $section->name }}</h3>
                                    @foreach($section->items as $item)
                                    <div class="menu_item">
                                        @if($item->price)<em>${{ number_format($item->price, 2) }}</em>@endif
                                        <h4>{{ $item->name }}</h4>
                                        @if($item->description)<p>{{ $item->description }}</p>@endif
                                    </div>
                                    @endforeach
                                    @if(!$loop->last)<hr>@endif
                                    @endforeach
                                </div>
                                @endif

                                <div class="other_info">
                                    <h2>How to get to {{ $restaurant->name }}</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h3>Address</h3>
                                            <p>
                                                {{ $restaurant->address }}<br>
                                                {{ $restaurant->city }}{{ $restaurant->state ? ', ' . $restaurant->state : '' }} {{ $restaurant->zip }}
                                                @if($restaurant->address)
                                                <br><a href="https://www.google.com/maps/search/{{ urlencode($restaurant->address . ' ' . $restaurant->city) }}" target="_blank"><strong>Get directions</strong></a>
                                                @endif
                                            </p>
                                            @if($restaurant->phone)
                                                <p><strong>Phone</strong><br>{{ $restaurant->phone }}</p>
                                            @endif
                                            @if($restaurant->email)
                                                <p><strong>Email</strong><br><a href="mailto:{{ $restaurant->email }}">{{ $restaurant->email }}</a></p>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Opening Hours</h3>
                                            @if($restaurant->opening_hours)
                                                @foreach($restaurant->opening_hours as $day => $hours)
                                                <p>
                                                    <strong>{{ ucfirst($day) }}</strong><br>
                                                    @if(strtolower($hours) === 'closed')
                                                        <span class="loc_closed">Closed</span>
                                                    @else
                                                        {{ $hours }}
                                                    @endif
                                                </p>
                                                @endforeach
                                            @else
                                                <p>Please call for hours.</p>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Info</h3>
                                            <p>
                                                <strong>Price Range</strong><br>
                                                {{ $restaurant->price_symbol }}
                                                @if($restaurant->avg_price) &mdash; avg ${{ $restaurant->avg_price }}@endif
                                            </p>
                                            @if($restaurant->cuisines->isNotEmpty())
                                                <p><strong>Cuisines</strong><br>{{ $restaurant->cuisines->pluck('name')->join(', ') }}</p>
                                            @endif
                                            @if($restaurant->website)
                                                <p><strong>Website</strong><br><a href="{{ $restaurant->website }}" target="_blank">{{ $restaurant->website }}</a></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Reviews Tab --}}
                    <div id="pane-B" class="card tab-pane fade" role="tabpanel">
                        <div class="card-header" role="tab" id="heading-B">
                            <h5>
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B">Reviews</a>
                            </h5>
                        </div>
                        <div id="collapse-B" class="collapse" role="tabpanel">
                            <div class="card-body reviews">

                                {{-- Summary --}}
                                @if($restaurant->review_count > 0)
                                <div class="row add_bottom_45 d-flex align-items-center">
                                    <div class="col-md-3">
                                        <div id="review_summary">
                                            <strong>{{ number_format($restaurant->avg_rating, 1) }}</strong>
                                            <em>{{ $restaurant->rating_label }}</em>
                                            <small>Based on {{ $restaurant->review_count }} reviews</small>
                                        </div>
                                    </div>
                                    <div class="col-md-9 reviews_sum_details">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Overall Rating</h6>
                                                <div class="row">
                                                    <div class="col-xl-10 col-lg-9 col-9">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $restaurant->avg_rating * 10 }}%"
                                                                aria-valuenow="{{ $restaurant->avg_rating * 10 }}"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-3"><strong>{{ number_format($restaurant->avg_rating, 1) }}</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- Review Cards --}}
                                <div id="reviews">
                                    @php $reviewList = $restaurant->approvedReviews; @endphp

                                    @if($userReview && $userReview->status === 'pending')
                                    @php
                                        $initials = collect(explode(' ', $userReview->user->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                                        $palette = ['#e74c3c','#3498db','#2ecc71','#f39c12','#9b59b6','#1abc9c','#e67e22','#34495e'];
                                        $bgColor = $palette[ord($userReview->user->name[0]) % count($palette)];
                                    @endphp
                                    <div class="review_card" style="opacity:0.6;">
                                        <div class="row">
                                            <div class="col-md-2 user_info">
                                                <figure class="avatar-initials" style="background-color:{{ $bgColor }}">{{ $initials }}</figure>
                                                <h5>{{ $userReview->user->name }}</h5>
                                            </div>
                                            <div class="col-md-10 review_content">
                                                <div class="clearfix add_bottom_15">
                                                    <span class="rating">{{ number_format($userReview->rating, 1) }}<small>/10</small> <strong>Rating</strong></span>
                                                    <em>{{ $userReview->created_at->diffForHumans() }}</em>
                                                    <span class="badge bg-warning ms-2" style="font-size:0.75rem;">Pending approval</span>
                                                </div>
                                                @if($userReview->title)<h4>"{{ $userReview->title }}"</h4>@endif
                                                <p>{{ $userReview->body }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @forelse($reviewList as $review)
                                    @php
                                        $initials = collect(explode(' ', $review->user->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                                        $palette = ['#e74c3c','#3498db','#2ecc71','#f39c12','#9b59b6','#1abc9c','#e67e22','#34495e'];
                                        $bgColor = $palette[ord($review->user->name[0]) % count($palette)];
                                    @endphp
                                    <div class="review_card">
                                        <div class="row">
                                            <div class="col-md-2 user_info">
                                                <figure class="avatar-initials" style="background-color:{{ $bgColor }}">{{ $initials }}</figure>
                                                <h5>{{ $review->user->name }}</h5>
                                            </div>
                                            <div class="col-md-10 review_content">
                                                <div class="clearfix add_bottom_15">
                                                    <span class="rating">{{ number_format($review->rating, 1) }}<small>/10</small> <strong>Rating</strong></span>
                                                    <em>{{ $review->created_at->diffForHumans() }}</em>
                                                </div>
                                                @if($review->title)<h4>"{{ $review->title }}"</h4>@endif
                                                <p>{{ $review->body }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @if(!$userReview)
                                    <p class="text-muted">No reviews yet. Be the first to review!</p>
                                    @endif
                                    @endforelse
                                </div>

                                {{-- Write Review --}}
                                @auth
                                @if(session('error'))
                                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                @endif
                                @if($userReview || $hasBooking)
                                <div class="box_general write_review add_top_30">
                                    <h4 class="add_bottom_15">{{ $userReview ? 'Edit your review for' : 'Write a review for' }} "{{ $restaurant->name }}"</h4>

                                    @if($userReview)
                                        <form id="review-form" action="{{ route('reviews.update', [$restaurant->slug, $userReview->id]) }}" method="POST">
                                            @csrf @method('PATCH')
                                    @else
                                        <form id="review-form" action="{{ route('reviews.store', $restaurant->slug) }}" method="POST">
                                            @csrf
                                    @endif

                                        <label class="d-block add_bottom_15">Overall rating</label>
                                        <div class="row add_bottom_15">
                                            <div class="col-md-6 add_bottom_25">
                                                <div class="add_bottom_15">Rating <strong class="rating_val"></strong></div>
                                                <input type="range" min="1" max="10" step="1"
                                                       value="{{ old('rating', $userReview->rating ?? 8) }}"
                                                       data-orientation="horizontal"
                                                       id="rating_slider" name="rating">
                                                @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Title of your review</label>
                                            <input class="form-control" type="text" name="title"
                                                   value="{{ old('title', $userReview->title ?? '') }}"
                                                   placeholder="If you could say it in one sentence, what would you say?">
                                        </div>
                                        <div class="form-group">
                                            <label>Your review</label>
                                            <textarea class="form-control @error('body') is-invalid @enderror"
                                                      name="body" style="height:180px;"
                                                      placeholder="Write your review to help others learn about this restaurant">{{ old('body', $userReview->body ?? '') }}</textarea>
                                            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <a href="#0" class="btn_1">
                                            <span onclick="document.getElementById('review-form').submit()">
                                                {{ $userReview ? 'Update Review' : 'Submit Review' }}
                                            </span>
                                        </a>
                                    </form>

                                    @if($userReview)
                                    <form id="delete-form" action="{{ route('reviews.destroy', [$restaurant->slug, $userReview->id]) }}" method="POST"
                                          onsubmit="return confirm('Delete your review?')" class="mt-2">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn_1" style="background:#e74c3c;">Delete Review</button>
                                    </form>
                                    @endif
                                </div>
                                @else
                                <div class="text-end add_bottom_30 add_top_15">
                                    <p class="text-muted">Only guests who have made a booking can leave a review.</p>
                                </div>
                                @endif
                                @else
                                <div class="text-end add_bottom_30">
                                    <a href="{{ route('login') }}" class="btn_1">Sign in to leave a review</a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Sidebar --}}
        <div class="col-lg-4" id="sidebar_fixed">
            <div class="box_booking">
                <div class="head">
                    <h3>Book your table</h3>
                </div>
                <div class="main">
                    <form action="{{ route('bookings.store', $restaurant->slug) }}" method="POST" id="booking_form">
                        @csrf

                        {{-- Hidden fields submitted to backend --}}
                        <input type="hidden" name="booking_date" id="datepicker_field" value="{{ old('booking_date') }}">
                        <input type="hidden" name="booking_time" id="hidden_time" value="{{ old('booking_time') }}">
                        <input type="hidden" name="guests" id="hidden_guests" value="{{ old('guests', 2) }}">

                        {{-- Inline calendar --}}
                        <div id="DatePicker"></div>

                        {{-- Time dropdown --}}
                        <div class="dropdown time">
                            <a href="#" data-bs-toggle="dropdown">Hour <span id="selected_time">{{ old('booking_time', 'Select') }}</span></a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <h4>Lunch</h4>
                                    <div class="radio_select add_bottom_15">
                                        <ul>
                                            @foreach(['12:00','12:30','13:00','13:30','14:00'] as $t)
                                            <li>
                                                <input type="radio" id="time_l{{ $loop->index }}" name="time" value="{{ $t }}" {{ old('booking_time') == $t ? 'checked' : '' }}>
                                                <label for="time_l{{ $loop->index }}">{{ $t }}</label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <h4>Dinner</h4>
                                    <div class="radio_select">
                                        <ul>
                                            @foreach(['19:00','19:30','20:00','20:30','21:00','21:30'] as $t)
                                            <li>
                                                <input type="radio" id="time_d{{ $loop->index }}" name="time" value="{{ $t }}" {{ old('booking_time') == $t ? 'checked' : '' }}>
                                                <label for="time_d{{ $loop->index }}">{{ $t }}</label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- People dropdown --}}
                        <div class="dropdown people">
                            <a href="#" data-bs-toggle="dropdown">People <span id="selected_people">{{ old('guests', 2) }}</span></a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <h4>How many people?</h4>
                                    <div class="radio_select">
                                        <ul>
                                            @for($i = 1; $i <= 8; $i++)
                                            <li>
                                                <input type="radio" id="people_{{ $i }}" name="people" value="{{ $i }}" {{ old('guests', 2) == $i ? 'checked' : '' }}>
                                                <label for="people_{{ $i }}">{{ $i }}</label>
                                            </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Contact fields --}}
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name', auth()->user()?->name) }}" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', auth()->user()?->email) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone (optional)" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <textarea name="notes" class="form-control" rows="2" placeholder="Special requests (optional)">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn_1 full-width mb_5">Reserve Now</button>
                        <div class="text-center"><small>No payment required at this step</small></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('js/datepicker.min.js') }}"></script>
<script src="{{ asset('js/specific_detail.js') }}"></script>
<script src="{{ asset('js/specific_review.js') }}"></script>
<script>
$('#rating_slider').rangeslider({
    polyfill: false,
    onInit: function () {
        this.output = $('.rating_val').html(this.$element.val());
    },
    onSlide: function (position, value) {
        this.output.html(value);
    }
});
</script>
<script>
// Inline datepicker
$('#DatePicker').datepicker({
    inline: true,
    altField: '#datepicker_field',
    altFormat: 'yy-mm-dd',
    dateFormat: 'D, d M yy',
    minDate: 0,
});

// Sync radio selections to hidden form fields
$('.radio_select input[name="time"]').on('change', function() {
    $('#hidden_time').val($(this).val());
    $('#selected_time').text($(this).val());
});
$('.radio_select input[name="people"]').on('change', function() {
    $('#hidden_guests').val($(this).val());
    $('#selected_people').text($(this).val());
});

// Validate before submit
$('#booking_form').on('submit', function(e) {
    if (!$('#datepicker_field').val()) {
        alert('Please select a date.');
        e.preventDefault();
        return;
    }
    if (!$('#hidden_time').val()) {
        alert('Please select a time.');
        e.preventDefault();
        return;
    }
});
</script>
@endsection
