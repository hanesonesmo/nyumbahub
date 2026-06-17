@extends('layouts.app')

@section('title', 'My Appointments — NyumbaHub')

@section('content')

<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">My Appointments</h1>
        <p class="dashboard-subtitle">Track your property viewing bookings</p>
    </div>
    <a href="{{ route('listings.index') }}" class="btn-primary">
        <i class="fa-solid fa-magnifying-glass"></i> Browse More
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="dashboard-card">
    @forelse($appointments as $appointment)
    <div style="display:flex;gap:16px;align-items:center;padding:16px 20px;border-bottom:1px solid var(--border);">

        {{-- Image --}}
        @if($appointment->listing->images->first())
            <img src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}"
                style="width:80px;height:60px;object-fit:cover;border-radius:8px;flex-shrink:0;">
        @else
            <div style="width:80px;height:60px;background:var(--bg);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);flex-shrink:0;">
                <i class="fa-solid fa-building"></i>
            </div>
        @endif

        {{-- Info --}}
        <div style="flex:1;">
            <div style="font-weight:700;font-size:15px;">{{ $appointment->listing->title }}</div>
            <div style="font-size:13px;color:var(--text-muted);">
                <i class="fa-solid fa-calendar" style="color:var(--accent);"></i>
                {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                at {{ $appointment->time }}
            </div>
            <div style="font-size:13px;color:var(--text-muted);">
                <i class="fa-solid fa-circle-user" style="color:var(--primary-light);"></i>
                Agent: {{ $appointment->listing->agent->first_name }}
            </div>
        </div>

        {{-- Status --}}
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
            <span style="padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;
                background:{{ $appointment->status === 'confirmed' ? '#D1FAE5' : ($appointment->status === 'cancelled' ? '#FEE2E2' : '#FEF9C3') }};
                color:{{ $appointment->status === 'confirmed' ? '#065F46' : ($appointment->status === 'cancelled' ? '#991B1B' : '#854D0E') }};">
                {{ ucfirst($appointment->status) }}
            </span>

            @if($appointment->status === 'pending')
                <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}">
                    @csrf
                    <button type="submit" style="font-size:12px;color:var(--error);background:none;border:none;cursor:pointer;font-weight:600;"
                        onclick="return confirm('Cancel this appointment?')">
                        Cancel
                    </button>
                </form>
            @endif
        </div>

    </div>
    @empty
    <div class="card-empty">
        <i class="fa-solid fa-calendar-xmark"></i>
        <p>No appointments yet</p>
        <a href="{{ route('listings.index') }}" class="btn-outline">Browse listings</a>
    </div>
    @endforelse
</div>

<div style="margin-top:20px;">{{ $appointments->links() }}</div>

@endsection
