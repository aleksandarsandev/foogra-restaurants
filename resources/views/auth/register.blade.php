@extends('layouts.app')

@section('title', 'Sign Up - Foogra')

@section('css')
<link href="{{ asset('css/booking-sign_up.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="sign_up">
                    <div class="head">
                        <div class="title">
                            <h3>Sign Up</h3>
                        </div>
                    </div>
                    <div class="main">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <h6>Personal details</h6>
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                                <i class="icon_pencil"></i>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                                <i class="icon_mail"></i>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                                <i class="icon_lock"></i>
                            </div>
                            <div class="form-group add_bottom_15">
                                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                                <i class="icon_lock"></i>
                            </div>
                            <button type="submit" class="btn_1 full-width mb_5">Sign up Now</button>
                            <div class="text-center">
                                Already have an account? <a href="{{ route('login') }}">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
