@extends('layouts.app')

@section('title', 'My Bookings - Foogra')

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
                        <li>My Bookings</li>
                    </ul>
                </div>
                <h1>My Bookings</h1>
            </div>
        </div>
    </div>
</div>

<div class="container margin_30_40">
    @forelse($bookings as $booking)
    <div class="box_list wow" style="margin-bottom: 20px;">
        <div class="row no-gutters">
            <div class="col-lg-2 col-md-3">
                <a href="{{ route('restaurants.show', $booking->restaurant->slug) }}" class="wish_bt"></a>
                <img src="{{ $booking->restaurant->featured_image_url }}" class="img-fluid" alt="{{ $booking->restaurant->name }}" style="width:100%;height:140px;object-fit:cover;">
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="wrapper">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3><a href="{{ route('restaurants.show', $booking->restaurant->slug) }}">{{ $booking->restaurant->name }}</a></h3>
                            <p class="mb-1">
                                <i class="icon_calendar"></i>
                                <strong>{{ $booking->booking_date->format('D, M d Y') }}</strong>
                                at <strong>{{ $booking->booking_time }}</strong>
                                &nbsp;·&nbsp;
                                <i class="icon_group"></i> {{ $booking->guests }} {{ $booking->guests == 1 ? 'guest' : 'guests' }}
                            </p>
                            @if($booking->notes)
                                <p class="text-muted mb-0"><small>Note: {{ $booking->notes }}</small></p>
                            @endif
                        </div>
                        <div class="text-end">
                            @php
                                $badge = match($booking->status) {
                                    'confirmed' => 'success',
                                    'cancelled' => 'danger',
                                    default     => 'warning',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }} px-3 py-2" style="font-size:0.85rem">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <p class="text-muted mt-2 mb-0"><small>Booked {{ $booking->created_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="icon_calendar" style="font-size:3rem;color:#ccc;"></i>
        <h4 class="mt-3">No bookings yet</h4>
        <p class="text-muted">Browse restaurants and make your first reservation.</p>
        <a href="{{ route('restaurants.index') }}" class="btn_1">Find Restaurants</a>
    </div>
    @endforelse

    {{ $bookings->links() }}
</div>

@endsection
