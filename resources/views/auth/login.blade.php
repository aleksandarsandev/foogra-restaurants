@extends('layouts.app')

@section('title', 'Sign In - Foogra')

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
                            <h3>Sign In</h3>
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

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                                <i class="icon_mail"></i>
                            </div>
                            <div class="form-group add_bottom_15">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                                <i class="icon_lock"></i>
                            </div>
                            <div class="clearfix add_bottom_15">
                                <div class="checkboxes float-start">
                                    <label class="container_check">Remember me
                                        <input type="checkbox" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn_1 full-width mb_5">Sign In</button>
                            <div class="text-center">
                                Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
