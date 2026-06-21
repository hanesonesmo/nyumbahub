@extends('layouts.app')

@section('title', 'Buyer Dashboard — NyumbaHub')

@section('content')
<div class="dashboard">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="dashboard-subtitle">Find your dream property to buy in Arusha</p>
        </div>
        <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="btn-primary">
            <i class="fa-solid fa-magnifying-glass"></i> Browse Properties
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
            <div class="stat-icon" style="background:rgba(0,138,5,0.1);color:#008A05;">
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
                <h2 class="card-title"><i class="fa-solid fa-calendar"></i> My Viewings</h2>
                <a href="{{ route('appointments.index') }}" class="card-link">View all</a>
            </div>
            @forelse($appointments as $appointment)
            <div style="display:flex;gap:12px;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border-light,#EBEBEB);">
                @if($appointment->listing->images->first())
                    <img src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}"
                        style="width:56px;height:42px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                @else
                    <div style="width:56px;height:42px;background:var(--bg-soft,#F7F7F7);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-building" style="color:#ccc;"></i>
                    </div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $appointment->listing->title }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted,#717171);">
                        {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }} at {{ $appointment->time }}
                    </div>
                </div>
                <span style="padding:3px 8px;border-radius:20px;font-size:10px;font-weight:700;flex-shrink:0;
                    background:{{ $appointment->status === 'confirmed' ? '#D1FAE5' : ($appointment->status === 'cancelled' ? '#FEE2E2' : '#FEF9C3') }};
                    color:{{ $appointment->status === 'confirmed' ? '#065F46' : ($appointment->status === 'cancelled' ? '#991B1B' : '#854D0E') }};">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
            @empty
            <div class="card-empty">
                <i class="fa-solid fa-calendar-xmark"></i>
                <p>No viewings booked yet</p>
                <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="btn-outline">Browse properties</a>
            </div>
            @endforelse
        </div>

        {{-- Properties for sale --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-tag"></i> Latest For Sale</h2>
                <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="card-link">See all</a>
            </div>
            @forelse($recentListings as $listing)
            <div style="display:flex;gap:12px;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border-light,#EBEBEB);">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                        style="width:56px;height:42px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                @else
                    <div style="width:56px;height:42px;background:var(--bg-soft,#F7F7F7);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-building" style="color:#ccc;"></i>
                    </div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $listing->title }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted,#717171);">
                        TZS {{ number_format($listing->price) }}
                    </div>
                </div>
                <a href="{{ route('listings.show', $listing->id) }}" class="btn-view" style="font-size:12px;padding:6px 12px;">
                    View
                </a>
            </div>
            @empty
            <div class="card-empty">
                <i class="fa-solid fa-building-circle-xmark"></i>
                <p>No sale listings yet</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
