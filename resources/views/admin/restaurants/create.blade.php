@extends('layouts.admin')

@section('title', 'Add Restaurant - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.restaurants.index') }}">Restaurants</a></li>
<li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="box_general">
    <div class="header_box version_2">
        <h2><i class="fa fa-plus-circle"></i> Add Restaurant</h2>
    </div>

    <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <h5 class="add_bottom_15">Basic Information</h5>

                <div class="form-group">
                    <label>Restaurant Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Website</label>
                    <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://...">
                </div>

                <h5 class="add_bottom_15 add_top_30">Location</h5>

                <div class="form-group">
                    <label>Street Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ZIP</label>
                            <input type="text" name="zip" class="form-control" value="{{ old('zip') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="number" name="latitude" class="form-control" step="any" value="{{ old('latitude') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="number" name="longitude" class="form-control" step="any" value="{{ old('longitude') }}">
                        </div>
                    </div>
                </div>

                <h5 class="add_bottom_15 add_top_30">Categories & Cuisines</h5>

                <div class="form-group">
                    <label>Categories</label>
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

                <div class="form-group">
                    <label>Cuisines</label>
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
            </div>

            <div class="col-md-4">
                <h5 class="add_bottom_15">Settings</h5>

                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Price Range *</label>
                    <select name="price_range" class="form-control" required>
                        <option value="1" {{ old('price_range') == '1' ? 'selected' : '' }}>$ Budget</option>
                        <option value="2" {{ old('price_range', '2') == '2' ? 'selected' : '' }}>$$ Moderate</option>
                        <option value="3" {{ old('price_range') == '3' ? 'selected' : '' }}>$$$ Upscale</option>
                        <option value="4" {{ old('price_range') == '4' ? 'selected' : '' }}>$$$$ Fine Dining</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Average Price ($)</label>
                    <input type="number" name="avg_price" class="form-control" value="{{ old('avg_price') }}" placeholder="e.g. 25">
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured on Homepage</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Featured Image</label>
                    <input type="file" name="featured_image" class="form-control-file" accept="image/*">
                    <small class="text-muted">Recommended: 800×500px, max 2MB</small>
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-save"></i> Create Restaurant
                </button>
                <a href="{{ route('admin.restaurants.index') }}" class="btn btn-secondary btn-block mt-2">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
