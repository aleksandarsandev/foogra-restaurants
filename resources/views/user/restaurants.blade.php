@extends('layouts.app')

@section('title', 'My Restaurants - Foogra')

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
                        <li>My Restaurants</li>
                    </ul>
                </div>
                <h1>My Restaurants</h1>
            </div>
        </div>
    </div>
</div>

<div class="container margin_30_40">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('restaurants.submit') }}" class="btn_1">Submit a New Restaurant</a>
    </div>

    @forelse($restaurants as $restaurant)
    <div class="box_list wow" style="margin-bottom: 20px;">
        <div class="row no-gutters">
            <div class="col-lg-2 col-md-3">
                <img src="{{ $restaurant->featured_image_url }}" class="img-fluid" alt="{{ $restaurant->name }}" style="width:100%;height:140px;object-fit:cover;">
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="wrapper">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3>{{ $restaurant->name }}</h3>
                            <p class="mb-1 text-muted">
                                @if($restaurant->city)
                                    <i class="icon_pin"></i> {{ $restaurant->city }}
                                    @if($restaurant->state) , {{ $restaurant->state }} @endif
                                    &nbsp;·&nbsp;
                                @endif
                                {{ $restaurant->price_symbol }}
                            </p>
                            <p class="mb-0 text-muted">
                                <small>{{ $restaurant->categories->pluck('name')->join(', ') }}</small>
                            </p>
                        </div>
                        <div class="text-end">
                            @php
                                $badge = match($restaurant->status) {
                                    'active'   => 'success',
                                    'inactive' => 'danger',
                                    default    => 'warning',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }} px-3 py-2" style="font-size:0.85rem">
                                {{ ucfirst($restaurant->status) }}
                            </span>
                            @if($restaurant->status === 'active')
                            <div class="mt-2">
                                <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="btn_1 small">View</a>
                            </div>
                            @endif
                            @if($restaurant->status === 'pending')
                            <p class="text-muted mt-2 mb-0"><small>Awaiting admin approval</small></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="icon_building" style="font-size:3rem;color:#ccc;"></i>
        <h4 class="mt-3">No restaurants submitted yet</h4>
        <p class="text-muted">Submit your restaurant and reach more customers.</p>
        <a href="{{ route('restaurants.submit') }}" class="btn_1">Submit a Restaurant</a>
    </div>
    @endforelse

    {{ $restaurants->links() }}
</div>

@endsection
