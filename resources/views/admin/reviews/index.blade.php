@extends('layouts.admin')

@section('title', 'Reviews - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Reviews</li>
@endsection

@section('content')
<div class="box_general">
    <div class="header_box version_2">
        <h2><i class="fa fa-star"></i> Reviews</h2>
    </div>

    <form method="get" class="form-inline mb-3">
        <select name="status" class="form-control mr-2">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Restaurant</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->restaurant->name }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td><strong>{{ number_format($review->rating, 1) }}/10</strong></td>
                    <td>
                        @if($review->title)<strong>{{ $review->title }}</strong><br>@endif
                        <small>{{ Str::limit($review->body, 80) }}</small>
                    </td>
                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $review->status == 'approved' ? 'success' : ($review->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <select name="status" class="form-control form-control-sm d-inline w-auto" onchange="this.form.submit()">
                                <option value="pending" {{ $review->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $review->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $review->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">No reviews found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reviews->links() }}
</div>
@endsection
