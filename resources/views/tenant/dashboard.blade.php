@extends('layouts.app')

@section('title', 'Dashboard — NyumbaHub')

@section('content')
<div class="dashboard">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="dashboard-subtitle">Find your perfect rental in Arusha</p>
        </div>
        <a href="{{ route('listings.index') }}" class="btn-primary">
            <i class="fa-solid fa-magnifying-glass"></i> Browse Listings
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(27,67,50,0.1);color:#1B4332;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalAppointments }}</div>
                <div class="stat-label">My Bookings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(212,168,83,0.1);color:#D4A853;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $pendingAppointments }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(45,106,79,0.1);color:#2D6A4F;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $confirmedAppointments }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">

        {{-- My appointments --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-calendar"></i> My Bookings</h2>
                <a href="{{ route('appointments.index') }}" class="card-link">View all</a>
            </div>
            @forelse($appointments as $appointment)
            <div style="display:flex;gap:12px;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border);">
                @if($appointment->listing->images->first())
                    <img src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}"
                        style="width:60px;height:45px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                @else
                    <div style="width:60px;height:45px;background:var(--bg);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);flex-shrink:0;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $appointment->listing->title }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted);">
                        <i class="fa-solid fa-calendar" style="color:var(--accent);"></i>
                        {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }} at {{ $appointment->time }}
                    </div>
                </div>
                <span style="padding:3px 8px;border-radius:20px;font-size:10px;font-weight:700;
                    background:{{ $appointment->status === 'confirmed' ? '#D1FAE5' : ($appointment->status === 'cancelled' ? '#FEE2E2' : '#FEF9C3') }};
                    color:{{ $appointment->status === 'confirmed' ? '#065F46' : ($appointment->status === 'cancelled' ? '#991B1B' : '#854D0E') }};">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
            @empty
            <div class="card-empty">
                <i class="fa-solid fa-calendar-xmark"></i>
                <p>No bookings yet</p>
                <a href="{{ route('listings.index') }}" class="btn-outline">Browse listings</a>
            </div>
            @endforelse
        </div>

        {{-- Recent listings --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-building"></i> Recent Listings</h2>
                <a href="{{ route('listings.index') }}" class="card-link">See all</a>
            </div>
            @forelse($recentListings as $listing)
            <div style="display:flex;gap:12px;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border);">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                        style="width:60px;height:45px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                @else
                    <div style="width:60px;height:45px;background:var(--bg);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);flex-shrink:0;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $listing->title }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted);">
                        TZS {{ number_format($listing->price) }}
                        {{ $listing->type === 'rent' ? '/month' : '' }}
                    </div>
                </div>
                <a href="{{ route('listings.show', $listing->id) }}" class="btn-view" style="font-size:12px;padding:5px 10px;">
                    View
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
</div>
@endsection
