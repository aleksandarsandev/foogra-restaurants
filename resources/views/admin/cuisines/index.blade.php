@extends('layouts.admin')

@section('title', 'Cuisines - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Cuisines</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-plus"></i> Add Cuisine</h2>
            </div>
            <form method="POST" action="{{ route('admin.cuisines.store') }}">
                @csrf
                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="e.g. Italian">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-save"></i> Save Cuisine
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="box_general">
            <div class="header_box version_2">
                <h2><i class="fa fa-list"></i> All Cuisines</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Restaurants</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuisines as $cuisine)
                        <tr>
                            <td><strong>{{ $cuisine->name }}</strong></td>
                            <td><small class="text-muted">{{ $cuisine->slug }}</small></td>
                            <td>{{ $cuisine->restaurants_count }}</td>
                            <td>
                                <form action="{{ route('admin.cuisines.destroy', $cuisine) }}" method="POST"
                                      onsubmit="return confirm('Delete \'{{ $cuisine->name }}\'? It will be removed from all restaurants.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">No cuisines yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
