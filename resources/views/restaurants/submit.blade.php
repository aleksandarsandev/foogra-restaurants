@extends('layouts.app')

@section('title', 'Submit Your Restaurant - Foogra')

@section('css')
<link href="{{ asset('css/contacts.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="page_header element_to_stick">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Submit a Restaurant</li>
                    </ul>
                </div>
                <h1>Submit Your Restaurant</h1>
            </div>
        </div>
    </div>
</div>

<div class="container margin_30_40">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="alert alert-info">
                Your submission will be reviewed by our team and published once approved.
            </div>

            <form action="{{ route('restaurants.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="add_bottom_15">Basic Information</h5>

                <div class="form-group add_bottom_15">
                    <label>Restaurant Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group add_bottom_15">
                    <label>Description *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Tell customers about your restaurant..." required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group add_bottom_15">
                            <label>Phone *</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group add_bottom_15">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group add_bottom_15">
                    <label>Website</label>
                    <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://...">
                    @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <h5 class="add_bottom_15 add_top_30">Location</h5>

                <div class="form-group add_bottom_15">
                    <label>Street Address *</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group add_bottom_15">
                            <label>City *</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group add_bottom_15">
                            <label>State *</label>
                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}" required>
                            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group add_bottom_15">
                            <label>ZIP *</label>
                            <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ old('zip') }}" required>
                            @error('zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <h5 class="add_bottom_15 add_top_30">Details</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group add_bottom_15">
                            <label>Price Range *</label>
                            <select name="price_range" class="form-control @error('price_range') is-invalid @enderror" required>
                                <option value="1" {{ old('price_range') == '1' ? 'selected' : '' }}>$ Budget</option>
                                <option value="2" {{ old('price_range', '2') == '2' ? 'selected' : '' }}>$$ Moderate</option>
                                <option value="3" {{ old('price_range') == '3' ? 'selected' : '' }}>$$$ Upscale</option>
                                <option value="4" {{ old('price_range') == '4' ? 'selected' : '' }}>$$$$ Fine Dining</option>
                            </select>
                            @error('price_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group add_bottom_15">
                            <label>Average Price per Person ($)</label>
                            <input type="number" name="avg_price" class="form-control" value="{{ old('avg_price') }}" placeholder="e.g. 25">
                        </div>
                    </div>
                </div>

                <div class="form-group add_bottom_15">
                    <label>Categories *</label>
                    @error('categories')<div class="text-danger small mb-1">{{ $message }}</div>@enderror
                    <div class="row">
                        @foreach($categories as $category)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group add_bottom_15">
                    <label>Cuisines *</label>
                    @error('cuisines')<div class="text-danger small mb-1">{{ $message }}</div>@enderror
                    <div class="row">
                        @foreach($cuisines as $cuisine)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cuisines[]" value="{{ $cuisine->id }}" id="cui_{{ $cuisine->id }}"
                                    {{ in_array($cuisine->id, old('cuisines', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cui_{{ $cuisine->id }}">{{ $cuisine->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group add_bottom_30">
                    <label>Featured Image *</label>
                    <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*" required>
                    <small class="text-muted">Recommended: 800×500px, max 2MB</small>
                    @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn_1">Submit for Review</button>
                <a href="{{ route('home') }}" class="btn_1 outline ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection
