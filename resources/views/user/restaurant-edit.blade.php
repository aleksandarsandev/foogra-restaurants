@extends('layouts.app')

@section('title', 'Edit ' . $restaurant->name . ' - Foogra')

@section('css')
<link href="{{ asset('css/submit.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center add_bottom_15">
                    <h4>Edit Restaurant</h4>
                    <p>Update the details for <strong>{{ $restaurant->name }}</strong>.</p>
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

                <form action="{{ route('user.restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h6>Restaurant data</h6>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Restaurant Name" value="{{ old('name', $restaurant->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3" placeholder="Describe your restaurant..." required>{{ old('description', $restaurant->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Phone" value="{{ old('phone', $restaurant->phone) }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                                       placeholder="Website (optional)" value="{{ old('website', $restaurant->website) }}">
                                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Street Address" value="{{ old('address', $restaurant->address) }}" required>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row add_bottom_15">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                       placeholder="City" value="{{ old('city', $restaurant->city) }}" required>
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                       placeholder="State" value="{{ old('state', $restaurant->state) }}" required>
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror"
                                       placeholder="ZIP" value="{{ old('zip', $restaurant->zip) }}" required>
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
                                    <option value="1" {{ old('price_range', $restaurant->price_range) == '1' ? 'selected' : '' }}>$ Budget</option>
                                    <option value="2" {{ old('price_range', $restaurant->price_range) == '2' ? 'selected' : '' }}>$$ Moderate</option>
                                    <option value="3" {{ old('price_range', $restaurant->price_range) == '3' ? 'selected' : '' }}>$$$ Upscale</option>
                                    <option value="4" {{ old('price_range', $restaurant->price_range) == '4' ? 'selected' : '' }}>$$$$ Fine Dining</option>
                                </select>
                                @error('price_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" name="avg_price" class="form-control"
                                       placeholder="Avg price per person ($)" value="{{ old('avg_price', $restaurant->avg_price) }}">
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
                                        {{ in_array($category->id, old('categories', $restaurant->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                        {{ in_array($cuisine->id, old('cuisines', $restaurant->cuisines->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <h6>Menu</h6>
                    <p class="text-muted" style="font-size:0.85rem;">Add sections (e.g. Starters, Main Course) and items within each.</p>
                    @include('partials.menu-form', ['sections' => $restaurant->menuSections])
                    <div class="mb-3"></div>

                    <h6>Featured Image</h6>
                    <div class="form-group add_bottom_25">
                        @if($restaurant->featured_image)
                        <div class="mb-2">
                            <img src="{{ $restaurant->featured_image_url }}" alt="" style="max-height:120px; border-radius:6px;">
                            <small class="d-block text-muted mt-1">Current image — upload a new one to replace it.</small>
                        </div>
                        @endif
                        <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Recommended: 800×500px, max 2MB</small>
                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" class="btn_1" value="Save Changes">
                        <a href="{{ route('user.restaurants') }}" class="btn_1 gray ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
