@extends('layouts.admin')

@section('title', 'Bookings - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Bookings</li>
@endsection

@section('content')
<div class="box_general">
    <div class="header_box version_2">
        <h2><i class="fa fa-calendar-check-o"></i> Bookings</h2>
    </div>

    <form method="get" class="form-inline mb-3">
        <select name="status" class="form-control mr-2">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Restaurant</th>
                    <th>Guest</th>
                    <th>Email</th>
                    <th>Date & Time</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->restaurant->name }}</td>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ $booking->booking_date->format('M d, Y') }} at {{ $booking->booking_time }}</td>
                    <td>{{ $booking->guests }}</td>
                    <td>
                        <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <select name="status" class="form-control form-control-sm d-inline w-auto" onchange="this.form.submit()">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this booking?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $bookings->links() }}
</div>
@endsection
