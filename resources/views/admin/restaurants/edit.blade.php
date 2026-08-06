@extends('layouts.admin')

@section('title', 'Edit Restaurant - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.restaurants.index') }}">Restaurants</a></li>
<li class="breadcrumb-item active">Edit: {{ $restaurant->name }}</li>
@endsection

@section('content')
<div class="box_general">
    <div class="header_box version_2">
        <h2><i class="fa fa-edit"></i> Edit: {{ $restaurant->name }}</h2>
    </div>

    <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-8">
                <h5 class="add_bottom_15">Basic Information</h5>

                <div class="form-group">
                    <label>Restaurant Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $restaurant->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $restaurant->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $restaurant->phone) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $restaurant->email) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Website</label>
                    <input type="url" name="website" class="form-control" value="{{ old('website', $restaurant->website) }}">
                </div>

                <h5 class="add_bottom_15 add_top_30">Location</h5>

                <div class="form-group">
                    <label>Street Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $restaurant->address) }}">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $restaurant->city) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state', $restaurant->state) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ZIP</label>
                            <input type="text" name="zip" class="form-control" value="{{ old('zip', $restaurant->zip) }}">
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
                                    {{ in_array($category->id, old('categories', $restaurant->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                    {{ in_array($cuisine->id, old('cuisines', $restaurant->cuisines->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                        <option value="pending" {{ old('status', $restaurant->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status', $restaurant->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $restaurant->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Price Range *</label>
                    <select name="price_range" class="form-control" required>
                        @foreach([1 => '$ Budget', 2 => '$$ Moderate', 3 => '$$$ Upscale', 4 => '$$$$ Fine Dining'] as $val => $label)
                        <option value="{{ $val }}" {{ old('price_range', $restaurant->price_range) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Average Price ($)</label>
                    <input type="number" name="avg_price" class="form-control" value="{{ old('avg_price', $restaurant->avg_price) }}">
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                            {{ old('is_featured', $restaurant->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured on Homepage</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Featured Image</label>
                    @if($restaurant->featured_image)
                        <div class="mb-2">
                            <img src="{{ $restaurant->featured_image_url }}" alt="" class="img-thumbnail" style="max-height:100px">
                        </div>
                    @endif
                    <input type="file" name="featured_image" class="form-control-file" accept="image/*">
                    <small class="text-muted">Leave empty to keep current image</small>
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.restaurants.index') }}" class="btn btn-secondary btn-block mt-2">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
