@extends('layouts.admin')

@section('title', 'Categories - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-plus"></i> Add Category</h2>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="e.g. Pizza & Italian">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Icon class</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon') }}"
                           placeholder="e.g. icon-food_icon_pizza">
                    <small class="form-text text-muted">CSS icon class used on the home page carousel.</small>
                </div>
<button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-save"></i> Save Category
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="box_general">
            <div class="header_box version_2">
                <h2><i class="fa fa-list"></i> All Categories</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Icon</th>
                            <th>Restaurants</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><small class="text-muted">{{ $category->slug }}</small></td>
                            <td><i class="{{ $category->icon }}"></i> <small>{{ $category->icon }}</small></td>
                            <td>{{ $category->restaurants_count }}</td>
                            <td>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Delete \'{{ $category->name }}\'? It will be removed from all restaurants.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">No categories yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
