@extends('layouts.app')

@section('title', $restaurant->name . ' - Foogra')

@section('css')
<link href="{{ asset('css/detail-page.css') }}" rel="stylesheet">
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

                                <div class="other_info">
                                    <h2>How to find us</h2>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h3>Address</h3>
                                            <p>
                                                {{ $restaurant->address }}<br>
                                                {{ $restaurant->city }}{{ $restaurant->state ? ', ' . $restaurant->state : '' }} {{ $restaurant->zip }}
                                            </p>
                                            @if($restaurant->phone)
                                                <p><strong>Phone:</strong> {{ $restaurant->phone }}</p>
                                            @endif
                                            @if($restaurant->email)
                                                <p><strong>Email:</strong> <a href="mailto:{{ $restaurant->email }}">{{ $restaurant->email }}</a></p>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Opening Hours</h3>
                                            @if($restaurant->opening_hours)
                                                @foreach($restaurant->opening_hours as $day => $hours)
                                                <p><strong>{{ ucfirst($day) }}</strong><br>{{ $hours }}</p>
                                                @endforeach
                                            @else
                                                <p>Please call for hours.</p>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Price Range</h3>
                                            <p><strong>{{ $restaurant->price_symbol }}</strong></p>
                                            @if($restaurant->avg_price)
                                                <p>Average price: ${{ $restaurant->avg_price }}</p>
                                            @endif
                                            @if($restaurant->cuisines->isNotEmpty())
                                                <h3 class="mt-3">Cuisines</h3>
                                                <p>{{ $restaurant->cuisines->pluck('name')->join(', ') }}</p>
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
                                @if($restaurant->review_count > 0)
                                <div class="row add_bottom_45 d-flex align-items-center">
                                    <div class="col-md-3">
                                        <div id="review_summary">
                                            <strong>{{ number_format($restaurant->avg_rating, 1) }}</strong>
                                            <em>{{ $restaurant->rating_label }}</em>
                                            <small>Based on {{ $restaurant->review_count }} reviews</small>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div id="reviews">
                                    @php $reviewList = $restaurant->approvedReviews; @endphp

                                    {{-- Show user's own pending review only to them --}}
                                    @if($userReview && $userReview->status === 'pending')
                                    <div class="review_card" style="opacity:0.5;">
                                        <div class="row">
                                            <div class="col-md-2 user_info">
                                                @php
                                                    $initials = collect(explode(' ', $userReview->user->name))
                                                        ->map(fn($w) => strtoupper($w[0] ?? ''))
                                                        ->take(2)
                                                        ->implode('');
                                                    $palette = ['#e74c3c','#3498db','#2ecc71','#f39c12','#9b59b6','#1abc9c','#e67e22','#34495e'];
                                                    $bgColor = $palette[ord($userReview->user->name[0]) % count($palette)];
                                                @endphp
                                                <figure class="avatar-initials" style="background-color: {{ $bgColor }}">{{ $initials }}</figure>
                                                <h5>{{ $userReview->user->name }}</h5>
                                            </div>
                                            <div class="col-md-10 review_content">
                                                <div class="clearfix add_bottom_15">
                                                    <span class="rating">{{ number_format($userReview->rating, 1) }}<small>/10</small></span>
                                                    <em>{{ $userReview->created_at->diffForHumans() }}</em>
                                                    <span class="badge bg-warning ms-2" style="font-size:0.75rem;">Pending approval</span>
                                                </div>
                                                @if($userReview->title)
                                                    <h4>"{{ $userReview->title }}"</h4>
                                                @endif
                                                <p>{{ $userReview->body }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @forelse($reviewList as $review)
                                    <div class="review_card">
                                        <div class="row">
                                            <div class="col-md-2 user_info">
                                                @php
                                                    $initials = collect(explode(' ', $review->user->name))
                                                        ->map(fn($w) => strtoupper($w[0] ?? ''))
                                                        ->take(2)
                                                        ->implode('');
                                                    $palette = ['#e74c3c','#3498db','#2ecc71','#f39c12','#9b59b6','#1abc9c','#e67e22','#34495e'];
                                                    $bgColor = $palette[ord($review->user->name[0]) % count($palette)];
                                                @endphp
                                                <figure class="avatar-initials" style="background-color: {{ $bgColor }}">{{ $initials }}</figure>
                                                <h5>{{ $review->user->name }}</h5>
                                            </div>
                                            <div class="col-md-10 review_content">
                                                <div class="clearfix add_bottom_15">
                                                    <span class="rating">{{ number_format($review->rating, 1) }}<small>/10</small></span>
                                                    <em>{{ $review->created_at->diffForHumans() }}</em>
                                                </div>
                                                @if($review->title)
                                                    <h4>"{{ $review->title }}"</h4>
                                                @endif
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

                                {{-- Review Form --}}
                                @auth
                                <div class="add_bottom_30">
                                    @if(session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif
                                    @if($userReview || $hasBooking)
                                        @if($userReview)
                                            <h4>Edit Your Review</h4>
                                        @else
                                            <h4>Leave a Review</h4>
                                        @endif
                                        @if($userReview)
                                            <form id="review-form" action="{{ route('reviews.update', [$restaurant->slug, $userReview->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                        @else
                                            <form id="review-form" action="{{ route('reviews.store', $restaurant->slug) }}" method="POST">
                                                @csrf
                                        @endif
                                            <div class="form-group">
                                                <label>Rating (1–10)</label>
                                                <input type="number" name="rating" class="form-control @error('rating') is-invalid @enderror" min="1" max="10" step="0.5" value="{{ old('rating', $userReview->rating ?? 8) }}" required>
                                                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Title (optional)</label>
                                                <input type="text" name="title" class="form-control" value="{{ old('title', $userReview->title ?? '') }}" placeholder="Summarize your experience">
                                            </div>
                                            <div class="form-group">
                                                <label>Your Review</label>
                                                <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="4" required placeholder="Tell others about your experience...">{{ old('body', $userReview->body ?? '') }}</textarea>
                                                @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </form>
                                        @if($userReview)
                                        <form id="delete-form" action="{{ route('reviews.destroy', [$restaurant->slug, $userReview->id]) }}" method="POST" onsubmit="return confirm('Delete your review?')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endif
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="submit" form="review-form" class="btn_1">{{ $userReview ? 'Update Review' : 'Submit Review' }}</button>
                                            @if($userReview)
                                            <button type="submit" form="delete-form" class="btn_1" style="background:#e74c3c;">Delete Review</button>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted">Only guests who have booked this restaurant can leave a review. <a href="{{ route('restaurants.show', $restaurant->slug) }}">Make a booking</a> to share your experience.</p>
                                    @endif
                                </div>
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
                    <form action="{{ route('bookings.store', $restaurant->slug) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name', auth()->user()?->name) }}" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', auth()->user()?->email) }}" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone (optional)" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date', now()->addDay()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <select name="booking_time" class="form-control" required>
                                <option value="">Select time</option>
                                @foreach(['12:00', '12:30', '13:00', '13:30', '14:00', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30'] as $time)
                                    <option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="guests" class="form-control">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('guests', 2) == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'person' : 'people' }}</option>
                                @endfor
                            </select>
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
<script src="{{ asset('js/specific_detail.js') }}"></script>
@endsection
