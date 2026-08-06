@extends('layouts.admin')

@section('title', 'Restaurants - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Restaurants</li>
@endsection

@section('content')
<div class="box_general">
    <div class="header_box version_2">
        <h2><i class="fa fa-list"></i> Restaurants</h2>
        <a href="{{ route('admin.restaurants.create') }}" class="btn btn-sm btn-success float-right">
            <i class="fa fa-plus"></i> Add New
        </a>
    </div>

    <form method="get" class="form-inline mb-3">
        <input type="text" name="q" class="form-control mr-2" placeholder="Search..." value="{{ request('q') }}">
        <select name="status" class="form-control mr-2">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Categories</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($restaurants as $restaurant)
                <tr>
                    <td>{{ $restaurant->id }}</td>
                    <td>
                        <strong>{{ $restaurant->name }}</strong><br>
                        <small class="text-muted">{{ $restaurant->price_symbol }}</small>
                    </td>
                    <td>{{ $restaurant->city }}</td>
                    <td>{{ $restaurant->categories->pluck('name')->join(', ') }}</td>
                    <td>{{ number_format($restaurant->avg_rating, 1) }} ({{ $restaurant->review_count }})</td>
                    <td>
                        <span class="badge badge-{{ $restaurant->status == 'active' ? 'success' : ($restaurant->status == 'inactive' ? 'danger' : 'warning') }}">
                            {{ ucfirst($restaurant->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="btn btn-sm btn-info" target="_blank" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this restaurant?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">No restaurants found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $restaurants->links() }}
</div>
@endsection
