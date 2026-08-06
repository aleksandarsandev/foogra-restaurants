@extends('layouts.app')

@section('title', 'My Reviews - Foogra')

@section('css')
<link href="{{ asset('css/listing.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page_header element_to_stick">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>My Reviews</li>
                    </ul>
                </div>
                <h1>My Reviews</h1>
            </div>
        </div>
    </div>
</div>

<div class="container margin_30_40">
    @forelse($reviews as $review)
    <div class="box_list wow" style="margin-bottom: 20px;">
        <div class="row no-gutters">
            <div class="col-lg-2 col-md-3">
                <img src="{{ $review->restaurant->featured_image_url }}" class="img-fluid" alt="{{ $review->restaurant->name }}" style="width:100%;height:140px;object-fit:cover;">
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="wrapper">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3><a href="{{ route('restaurants.show', $review->restaurant->slug) }}">{{ $review->restaurant->name }}</a></h3>
                            @if($review->title)
                                <p class="mb-1"><strong>"{{ $review->title }}"</strong></p>
                            @endif
                            <p class="text-muted mb-1">{{ Str::limit($review->body, 120) }}</p>
                            <p class="mb-0">
                                <strong style="color:#589442;font-size:1.1rem;">{{ number_format($review->rating, 1) }}</strong>
                                <small class="text-muted">/10 &nbsp;·&nbsp; {{ $review->created_at->diffForHumans() }}</small>
                            </p>
                        </div>
                        <div class="text-end">
                            @php
                                $badge = match($review->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default    => 'warning',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }} px-3 py-2" style="font-size:0.85rem">
                                {{ ucfirst($review->status) }}
                            </span>
                            <div class="mt-2 d-flex gap-2 justify-content-end">
                                <a href="{{ route('restaurants.show', $review->restaurant->slug) }}#pane-B" class="btn_1 small">Edit</a>
                                <form action="{{ route('reviews.destroy', [$review->restaurant->slug, $review->id]) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn_1 small" style="background:#e74c3c;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="icon_star" style="font-size:3rem;color:#ccc;"></i>
        <h4 class="mt-3">No reviews yet</h4>
        <p class="text-muted">Visit a restaurant and share your experience.</p>
        <a href="{{ route('restaurants.index') }}" class="btn_1">Find Restaurants</a>
    </div>
    @endforelse

    {{ $reviews->links() }}
</div>

@endsection
