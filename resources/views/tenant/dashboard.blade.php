@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Welcome back, ' . auth()->user()->first_name . '!')
@section('page-subtitle', 'Here\'s what\'s happening with your rentals')

@section('topbar-actions')
    <a href="{{ route('listings.index') }}" class="btn-primary btn-sm">
        <i class="fa-solid fa-magnifying-glass"></i> Browse Listings
    </a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalAppointments }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFFBEB;color:#D97706;">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $pendingAppointments }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;color:#059669;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $confirmedAppointments }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;color:#16A34A;">
            <i class="fa-solid fa-house"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $recentListings->count() }}</div>
            <div class="stat-label">New Listings</div>
        </div>
    </div>
</div>

{{-- Content grid --}}
<div class="content-grid">

    {{-- My appointments --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-calendar"></i> My Bookings</h2>
            <a href="{{ route('appointments.index') }}" class="card-action">View all</a>
        </div>
        @forelse($appointments as $appointment)
        <div class="list-item">
            @if($appointment->listing->images->first())
                <img class="list-item-img"
                    src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}"
                    alt="">
            @else
                <div class="list-item-icon"><i class="fa-solid fa-building"></i></div>
            @endif
            <div class="list-item-info">
                <div class="list-item-title">{{ $appointment->listing->title }}</div>
                <div class="list-item-sub">
                    <i class="fa-solid fa-calendar" style="color:var(--primary);"></i>
                    {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                    at {{ $appointment->time }}
                </div>
            </div>
            <span class="badge badge-{{ $appointment->status }}">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>
        @empty
        <div class="card-empty">
            <i class="fa-solid fa-calendar-xmark"></i>
            <p>No bookings yet</p>
            <a href="{{ route('listings.index') }}" class="btn-outline btn-sm">Browse listings</a>
        </div>
        @endforelse
    </div>

    {{-- Recent listings --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-building"></i> Latest in Arusha</h2>
            <a href="{{ route('listings.index') }}" class="card-action">See all</a>
        </div>
        @forelse($recentListings as $listing)
        <div class="list-item">
            @if($listing->images->first())
                <img class="list-item-img"
                    src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                    alt="">
            @else
                <div class="list-item-icon"><i class="fa-solid fa-building"></i></div>
            @endif
            <div class="list-item-info">
                <div class="list-item-title">{{ $listing->title }}</div>
                <div class="list-item-sub">
                    TZS {{ number_format($listing->price) }}
                    {{ $listing->type === 'rent' ? '/mo' : '' }}
                    · {{ $listing->location }}
                </div>
            </div>
            <a href="{{ route('listings.show', $listing->id) }}"
                style="font-size:12px;color:var(--primary);font-weight:600;white-space:nowrap;">
                View <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        @empty
        <div class="card-empty">
            <i class="fa-solid fa-building-circle-xmark"></i>
            <p>No listings available</p>
        </div>
        @endforelse
    </div>

</div>

@endsection
