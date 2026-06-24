@extends('layouts.dashboard')

@section('title', 'Agent Dashboard')
@section('page-title', 'Agent Dashboard')
@section('page-subtitle', 'Manage your listings and appointments')

@section('topbar-actions')
    <a href="{{ route('agent.listings.create') }}" class="btn-primary btn-sm">
        <i class="fa-solid fa-plus"></i> Add Listing
    </a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;color:#16A34A;">
            <i class="fa-solid fa-building"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalListings }}</div>
            <div class="stat-label">Total Listings</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;color:#059669;">
            <i class="fa-solid fa-circle-dot"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $activeListings }}</div>
            <div class="stat-label">Active</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;">
            <i class="fa-solid fa-calendar"></i>
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
            <div class="stat-label">Pending Bookings</div>
        </div>
    </div>
</div>

<div class="content-grid">

    {{-- My listings --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-building"></i> My Listings</h2>
            <a href="{{ route('agent.listings.index') }}" class="card-action">View all</a>
        </div>
        @forelse($listings as $listing)
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
                    · {{ ucfirst($listing->type) }}
                </div>
            </div>
            <span class="badge badge-{{ $listing->status }}">
                {{ ucfirst($listing->status) }}
            </span>
        </div>
        @empty
        <div class="card-empty">
            <i class="fa-solid fa-building-circle-xmark"></i>
            <p>No listings yet</p>
            <a href="{{ route('agent.listings.create') }}" class="btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Add first listing
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pending appointments --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-calendar-clock"></i> Pending Appointments</h2>
            <a href="{{ route('appointments.index') }}" class="card-action">View all</a>
        </div>
        @forelse($appointments as $appointment)
        <div class="list-item">
            <div class="list-item-icon" style="background:#EFF6FF;color:#2563EB;border-radius:50%;">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="list-item-info">
                <div class="list-item-title">
                    {{ $appointment->user->first_name }} {{ $appointment->user->last_name }}
                </div>
                <div class="list-item-sub">
                    {{ $appointment->listing->title }} ·
                    {{ \Carbon\Carbon::parse($appointment->date)->format('d M') }}
                    at {{ $appointment->time }}
                </div>
            </div>
            <div style="display:flex;gap:6px;flex-shrink:0;">
                <form method="POST" action="{{ route('agent.appointments.confirm', $appointment->id) }}">
                    @csrf
                    <button type="submit" class="btn-primary btn-sm" title="Confirm">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </form>
                <form method="POST" action="{{ route('agent.appointments.cancel', $appointment->id) }}">
                    @csrf
                    <button type="submit" class="btn-danger btn-sm" title="Cancel">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="card-empty">
            <i class="fa-solid fa-calendar-xmark"></i>
            <p>No pending appointments</p>
        </div>
        @endforelse
    </div>

</div>

@endsection
