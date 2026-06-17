@extends('layouts.app')

@section('title', 'Agent Dashboard — NyumbaHub')

@section('content')
<div class="dashboard">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="dashboard-subtitle">Manage your listings and appointments</p>
        </div>
        <a href="{{ route('agent.listings.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Listing
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(27,67,50,0.1);color:#1B4332;">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalListings }}</div>
                <div class="stat-label">My Listings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(212,168,83,0.1);color:#D4A853;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalAppointments }}</div>
                <div class="stat-label">Appointments</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(45,106,79,0.1);color:#2D6A4F;">
                <i class="fa-solid fa-circle-dot"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $activeListings }}</div>
                <div class="stat-label">Active Listings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(192,57,43,0.1);color:#C0392B;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $pendingAppointments }}</div>
                <div class="stat-label">Pending Bookings</div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">

        {{-- My listings --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-building"></i> My Listings</h2>
                <a href="{{ route('agent.listings.index') }}" class="card-link">View all</a>
            </div>
            @forelse($listings as $listing)
            <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid var(--border);">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                        style="width:50px;height:40px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                @else
                    <div style="width:50px;height:40px;background:var(--bg);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);flex-shrink:0;">
                        <i class="fa-solid fa-image"></i>
                    </div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $listing->title }}</div>
                    <div style="font-size:12px;color:var(--text-muted);">TZS {{ number_format($listing->price) }}</div>
                </div>
                <span style="padding:3px 8px;border-radius:20px;font-size:10px;font-weight:700;
                    background:{{ $listing->status === 'active' ? '#D1FAE5' : ($listing->status === 'pending' ? '#FEF9C3' : '#FEE2E2') }};
                    color:{{ $listing->status === 'active' ? '#065F46' : ($listing->status === 'pending' ? '#854D0E' : '#991B1B') }};">
                    {{ ucfirst($listing->status) }}
                </span>
            </div>
            @empty
            <div class="card-empty">
                <i class="fa-solid fa-building-circle-xmark"></i>
                <p>No listings yet</p>
                <a href="{{ route('agent.listings.create') }}" class="btn-outline">Add first listing</a>
            </div>
            @endforelse
        </div>

        {{-- Appointments --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-calendar"></i> Pending Appointments</h2>
            </div>
            @forelse($appointments as $appointment)
            <div style="padding:12px 16px;border-bottom:1px solid var(--border);">
                <div style="font-weight:600;font-size:14px;">{{ $appointment->listing->title }}</div>
                <div style="font-size:13px;color:var(--text-muted);margin-top:4px;">
                    <i class="fa-solid fa-user" style="color:var(--accent);"></i>
                    {{ $appointment->user->first_name }} {{ $appointment->user->last_name }}
                </div>
                <div style="font-size:13px;color:var(--text-muted);">
                    <i class="fa-solid fa-calendar" style="color:var(--accent);"></i>
                    {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }} at {{ $appointment->time }}
                </div>
                @if($appointment->message)
                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;font-style:italic;">
                    "{{ $appointment->message }}"
                </div>
                @endif
                <div style="display:flex;gap:8px;margin-top:8px;">
                    <form method="POST" action="{{ route('agent.appointments.confirm', $appointment->id) }}">
                        @csrf
                        <button type="submit" style="padding:4px 12px;background:#1B4332;color:#fff;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600;">
                            <i class="fa-solid fa-check"></i> Confirm
                        </button>
                    </form>
                    <form method="POST" action="{{ route('agent.appointments.cancel', $appointment->id) }}">
                        @csrf
                        <button type="submit" style="padding:4px 12px;background:#C0392B;color:#fff;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600;">
                            <i class="fa-solid fa-xmark"></i> Cancel
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
</div>
@endsection
