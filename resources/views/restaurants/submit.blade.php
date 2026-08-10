@extends('layouts.app', ['headerClass' => 'header clearfix element_to_stick'])

@section('title', 'Submit Your Restaurant - Foogra')

@section('css')
<link href="{{ asset('css/submit.css') }}" rel="stylesheet">
@endsection

@section('content')

{{-- Hero --}}
<div class="hero_single inner_pages background-image" data-background="url({{ \App\Models\SiteSetting::imageUrl('submit_hero_bg', 'img/hero_submit.jpg') }})">
    <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-10 col-md-8">
                    <h1>Attract New Customers</h1>
                    <p>More bookings from diners around the corner</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Why Submit --}}
<div class="bg_gray">
    <div class="container margin_60_40">
        <div class="main_title center">
            <span><em></em></span>
            <h2>Why Submit to Foogra</h2>
            <p>Grow your restaurant's online presence and fill more tables every day.</p>
        </div>

        <div class="row justify-content-center align-items-center add_bottom_15">
            <div class="col-lg-5">
                <div class="box_about">
                    <h3>Boost your Bookings</h3>
                    <p class="lead">Reach thousands of diners actively looking for their next meal.</p>
                    <p>List your restaurant on Foogra and get discovered by food lovers in your area. Our platform makes it easy for customers to find you, view your menu, and book a table — all in one place.</p>
                    <img src="{{ asset('img/arrow_about.png') }}" alt="" class="arrow_1">
                </div>
            </div>
            <div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
                <img src="{{ \App\Models\SiteSetting::imageUrl('submit_about_1', 'img/about_1.svg') }}" alt="" class="img-fluid" width="250" height="250">
            </div>
        </div>

        <div class="row justify-content-center align-items-center add_bottom_15">
            <div class="col-lg-5 pr-lg-5 text-center d-none d-lg-block">
                <img src="{{ \App\Models\SiteSetting::imageUrl('submit_about_2', 'img/about_2.svg') }}" alt="" class="img-fluid" width="250" height="250">
            </div>
            <div class="col-lg-5">
                <div class="box_about">
                    <h3>Manage Easily</h3>
                    <p class="lead">Keep your listing up to date with zero effort.</p>
                    <p>Update your opening hours, photos, and details any time. Our simple dashboard puts you in control of how your restaurant appears to customers searching on Foogra.</p>
                    <img src="{{ asset('img/arrow_about.png') }}" alt="" class="arrow_2">
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="box_about">
                    <h3>Reach New Customers</h3>
                    <p class="lead">Grow beyond your regular crowd.</p>
                    <p>Foogra puts your restaurant in front of locals and tourists alike who are actively searching for a great place to eat. More visibility means more covers every week.</p>
                </div>
            </div>
            <div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
                <img src="{{ \App\Models\SiteSetting::imageUrl('submit_about_3', 'img/about_3.svg') }}" alt="" class="img-fluid" width="250" height="250">
            </div>
        </div>
    </div>
</div>

{{-- Pricing Plans --}}
<div class="container margin_60_40">
    <div class="main_title center">
        <span><em></em></span>
        <h2>Our Pricing Plans</h2>
        <p>Choose the plan that works best for your restaurant.</p>
    </div>
    <div class="row plans">
        <div class="plan col-md-4">
            <div class="plan-title">
                <h3>1 Month</h3>
                <p>Free of charge one standard listing</p>
            </div>
            <p class="plan-price">Free</p>
            <ul class="plan-features">
                <li><strong>Standard</strong> listing</li>
                <li><strong>1 month</strong> valid</li>
                <li><strong>Unsubscribe</strong> anytime</li>
            </ul>
            <a href="#submit" class="btn_1 gray btn_scroll">Submit</a>
        </div>

        <div class="plan plan-tall col-md-4">
            <div class="plan-title">
                <h3>6 Months</h3>
                <p>Highlighted in search results</p>
            </div>
            <p class="plan-price">$199</p>
            <ul class="plan-features">
                <li><strong>Premium</strong> support</li>
                <li><strong>Featured</strong> placement</li>
                <li><strong>6 months</strong> valid</li>
                <li><strong>Unsubscribe</strong> anytime</li>
            </ul>
            <a href="#submit" class="btn_1 btn_scroll">Submit</a>
        </div>

        <div class="plan col-md-4">
            <div class="plan-title">
                <h3>12 Months</h3>
                <p>Best value for growing restaurants</p>
            </div>
            <p class="plan-price">$299</p>
            <ul class="plan-features">
                <li><strong>Premium</strong> support</li>
                <li><strong>Featured</strong> placement</li>
                <li><strong>12 months</strong> valid</li>
                <li><strong>Unsubscribe</strong> anytime</li>
            </ul>
            <a href="#submit" class="btn_1 gray btn_scroll">Submit</a>
        </div>
    </div>
</div>

{{-- Form --}}
<div class="bg_gray pattern" id="submit">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center add_bottom_15">
                    <h4>Please fill the form below</h4>
                    <p>Your submission will be reviewed by our team and published once approved.</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('restaurants.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h6>Personal data</h6>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Restaurant Owner Name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row add_bottom_15">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address"
                                       value="{{ auth()->user()->email }}" readonly>
                            </div>
                        </div>
                    </div>

                    <h6>Restaurant data</h6>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" name="restaurant_name" class="form-control @error('restaurant_name') is-invalid @enderror"
                                       placeholder="Restaurant Name" value="{{ old('restaurant_name') }}" required>
                                @error('restaurant_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3" placeholder="Describe your restaurant..." required>{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Phone" value="{{ old('phone') }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                                       placeholder="Website (optional)" value="{{ old('website') }}">
                                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Street Address" value="{{ old('address') }}" required>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row add_bottom_15">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                       placeholder="City" value="{{ old('city') }}" required>
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                       placeholder="State" value="{{ old('state') }}" required>
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror"
                                       placeholder="ZIP" value="{{ old('zip') }}" required>
                                @error('zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <h6>Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="price_range" class="form-control @error('price_range') is-invalid @enderror" required>
                                    <option value="">Price Range</option>
                                    <option value="1" {{ old('price_range') == '1' ? 'selected' : '' }}>$ Budget</option>
                                    <option value="2" {{ old('price_range', '2') == '2' ? 'selected' : '' }}>$$ Moderate</option>
                                    <option value="3" {{ old('price_range') == '3' ? 'selected' : '' }}>$$$ Upscale</option>
                                    <option value="4" {{ old('price_range') == '4' ? 'selected' : '' }}>$$$$ Fine Dining</option>
                                </select>
                                @error('price_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" name="avg_price" class="form-control"
                                       placeholder="Avg price per person ($)" value="{{ old('avg_price') }}">
                            </div>
                        </div>
                    </div>

                    <h6>Categories</h6>
                    <div class="form-group add_bottom_15">
                        @error('categories')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                        <div class="row">
                            @foreach($categories as $category)
                            <div class="col-md-4">
                                <label class="container_check">{{ $category->name }}
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <h6>Cuisines</h6>
                    <div class="form-group add_bottom_15">
                        @error('cuisines')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                        <div class="row">
                            @foreach($cuisines as $cuisine)
                            <div class="col-md-4">
                                <label class="container_check">{{ $cuisine->name }}
                                    <input type="checkbox" name="cuisines[]" value="{{ $cuisine->id }}"
                                        {{ in_array($cuisine->id, old('cuisines', [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <h6>Menu</h6>
                    <p class="text-muted" style="font-size:0.85rem;">Add sections (e.g. Starters, Main Course) and items within each.</p>
                    @include('partials.menu-form', ['sections' => collect()])
                    <div class="mb-3"></div>

                    <h6>Featured Image</h6>
                    <div class="form-group add_bottom_25">
                        <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror"
                               accept="image/*" required>
                        <small class="text-muted">Recommended: 800×500px, max 2MB</small>
                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" class="btn_1" value="Submit for Review">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
