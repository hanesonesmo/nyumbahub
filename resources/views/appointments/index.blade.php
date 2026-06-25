@extends('layouts.dashboard')

@section('title', 'My Bookings')
@section('page-title', 'My Bookings')
@section('page-subtitle', 'All your property viewing appointments')

@section('topbar-actions')
    <a href="{{ route('listings.index') }}" class="btn-primary btn-sm">
        <i class="fa-solid fa-magnifying-glass"></i> Browse More
    </a>
@endsection

@section('content')

@if($appointments->count() > 0)
    {{-- Stats --}}
    <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:24px;">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;"><i class="fa-solid fa-calendar"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $appointments->total() }}</div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFFBEB;color:#D97706;"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $appointments->where('status','pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5;color:#059669;"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $appointments->where('status','confirmed')->count() }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
        </div>
    </div>
@endif

{{-- Appointments list --}}
<div style="display:flex;flex-direction:column;gap:14px;">
    @forelse($appointments as $appointment)
    <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:var(--shadow-xs);">

        <div style="display:flex;gap:16px;padding:18px 20px;align-items:flex-start;flex-wrap:wrap;">

            {{-- Property image --}}
            @if($appointment->listing->images->first())
                <img src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}"
                    style="width:100px;height:76px;object-fit:cover;border-radius:10px;flex-shrink:0;"
                    alt="">
            @else
                <div style="width:100px;height:76px;border-radius:10px;background:var(--gray-100);display:flex;align-items:center;justify-content:center;font-size:24px;color:var(--gray-300);flex-shrink:0;">
                    <i class="fa-solid fa-building"></i>
                </div>
            @endif

            {{-- Info --}}
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:8px;">
                    <div>
                        <h3 style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">
                            {{ $appointment->listing->title }}
                        </h3>
                        <div style="font-size:13px;color:var(--gray-500);display:flex;align-items:center;gap:6px;">
                            <i class="fa-solid fa-location-dot" style="color:var(--accent);"></i>
                            {{ $appointment->listing->location }}, Arusha
                            <span>·</span>
                            TZS {{ number_format($appointment->listing->price) }}
                            {{ $appointment->listing->type === 'rent' ? '/mo' : '' }}
                        </div>
                    </div>
                    <span class="badge badge-{{ $appointment->status }}" style="flex-shrink:0;">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>

                {{-- Date & time --}}
                <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--gray-600);">
                        <i class="fa-solid fa-calendar" style="color:var(--primary);"></i>
                        <strong>{{ \Carbon\Carbon::parse($appointment->date)->format('l, d F Y') }}</strong>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--gray-600);">
                        <i class="fa-solid fa-clock" style="color:var(--primary);"></i>
                        {{ $appointment->time }}
                    </div>
                </div>

                @if($appointment->message)
                <div style="font-size:13px;color:var(--gray-500);background:var(--gray-50);border-radius:8px;padding:8px 12px;margin-bottom:10px;">
                    <i class="fa-solid fa-message" style="color:var(--gray-400);margin-right:6px;"></i>
                    {{ $appointment->message }}
                </div>
                @endif

                {{-- Actions --}}
                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">

                    {{-- View property --}}
                    <a href="{{ route('listings.show', $appointment->listing->slug) }}"
                        style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:var(--gray-100);color:var(--gray-700);border-radius:var(--radius-full);font-size:13px;font-weight:600;text-decoration:none;transition:background 0.15s;"
                        onmouseover="this.style.background='var(--gray-200)'"
                        onmouseout="this.style.background='var(--gray-100)'">
                        <i class="fa-solid fa-eye"></i> View Property
                    </a>

                    {{-- WhatsApp agent --}}
                    @if($appointment->listing->agent && $appointment->listing->agent->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $appointment->listing->agent->whatsapp) }}?text={{ urlencode('Hi ' . $appointment->listing->agent->first_name . ', I have a booking for your listing: ' . $appointment->listing->title . ' on ' . \Carbon\Carbon::parse($appointment->date)->format('d M Y') . ' at ' . $appointment->time . '. Please confirm. — NyumbaHub') }}"
                            target="_blank"
                            style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#25D366;color:white;border-radius:var(--radius-full);font-size:13px;font-weight:700;text-decoration:none;transition:background 0.15s;"
                            onmouseover="this.style.background='#1EBD5A'"
                            onmouseout="this.style.background='#25D366'">
                            <i class="fa-brands fa-whatsapp" style="font-size:15px;"></i> Chat with Agent
                        </a>
                    @endif

                    {{-- Cancel --}}
                    @if($appointment->status === 'pending')
                        <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}"
                            onsubmit="return confirm('Cancel this appointment?')">
                            @csrf
                            <button type="submit"
                                style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:var(--error-bg);color:var(--error);border:1px solid var(--error-border);border-radius:var(--radius-full);font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">
                                <i class="fa-solid fa-xmark"></i> Cancel
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>

    </div>
    @empty
    <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:60px 24px;text-align:center;box-shadow:var(--shadow-xs);">
        <i class="fa-solid fa-calendar-xmark" style="font-size:48px;color:var(--gray-200);margin-bottom:16px;display:block;"></i>
        <h2 style="font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">No bookings yet</h2>
        <p style="font-size:14px;color:var(--gray-500);margin-bottom:24px;">Browse listings and book a viewing to get started.</p>
        <a href="{{ route('listings.index') }}" class="btn-primary">
            <i class="fa-solid fa-magnifying-glass"></i> Browse Listings
        </a>
    </div>
    @endforelse
</div>

@if($appointments->hasPages())
<div style="margin-top:20px;">{{ $appointments->links() }}</div>
@endif

@endsection
