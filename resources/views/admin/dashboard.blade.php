@extends('layouts.admin')

@section('title', 'Dashboard - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"><i class="fa fa-fw fa-list"></i></div>
                <div class="mr-5"><h5>{{ $stats['restaurants'] }} Restaurants</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.restaurants.index') }}">
                <span class="float-left">View All</span>
                <span class="float-right"><i class="fa fa-angle-right"></i></span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"><i class="fa fa-fw fa-calendar-check-o"></i></div>
                <div class="mr-5"><h5>{{ $stats['bookings'] }} Pending Bookings</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.bookings.index') }}">
                <span class="float-left">View Bookings</span>
                <span class="float-right"><i class="fa fa-angle-right"></i></span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"><i class="fa fa-fw fa-star"></i></div>
                <div class="mr-5"><h5>{{ $stats['reviews'] }} Pending Reviews</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.reviews.index') }}">
                <span class="float-left">Moderate Reviews</span>
                <span class="float-right"><i class="fa fa-angle-right"></i></span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card dashboard text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"><i class="fa fa-fw fa-check-circle"></i></div>
                <div class="mr-5"><h5>{{ $stats['active'] }} Active Listings</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.restaurants.index', ['status' => 'active']) }}">
                <span class="float-left">View Active</span>
                <span class="float-right"><i class="fa fa-angle-right"></i></span>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="box_general">
            <div class="header_box version_2">
                <h2><i class="fa fa-calendar-check-o"></i> Recent Bookings</h2>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary float-right">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Restaurant</th><th>Name</th><th>Date</th><th>Guests</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td>{{ $booking->restaurant->name }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->booking_date->format('M d') }}</td>
                            <td>{{ $booking->guests }}</td>
                            <td><span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($booking->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="box_general">
            <div class="header_box version_2">
                <h2><i class="fa fa-star"></i> Recent Reviews</h2>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-primary float-right">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Restaurant</th><th>User</th><th>Rating</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($recentReviews as $review)
                        <tr>
                            <td>{{ $review->restaurant->name }}</td>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ number_format($review->rating, 1) }}/10</td>
                            <td><span class="badge badge-{{ $review->status == 'approved' ? 'success' : ($review->status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($review->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
