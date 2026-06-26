@extends('layouts.dashboard')

@section('title', 'My Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, {{ auth()->user()->first_name }}')

@section('topbar-actions')
    <a href="{{ route('listings.index') }}" class="btn-primary btn-sm">
        <i class="fa-solid fa-magnifying-glass"></i> Browse Listings
    </a>
@endsection

@section('content')

{{-- Agent Application Status Banner --}}
@if($application)
    @if($application->status === 'pending')
    <div style="background:linear-gradient(135deg,#FFFBEB,#FEF3C7);border:1.5px solid #F59E0B;border-radius:14px;padding:18px 22px;margin-bottom:24px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;background:#F59E0B;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-clock" style="color:white;font-size:18px;"></i>
        </div>
        <div style="flex:1;">
            <div style="font-weight:700;font-size:14px;color:#92400E;">Agent Application Under Review</div>
            <div style="font-size:13px;color:#B45309;margin-top:2px;">Your application was submitted on {{ $application->created_at->format('d M Y') }}. We'll notify you by email within 24–48 hours.</div>
        </div>
        <span style="padding:6px 14px;background:#F59E0B;color:white;border-radius:9999px;font-size:12px;font-weight:700;white-space:nowrap;">Pending Review</span>
    </div>
    @elseif($application->status === 'rejected')
    <div style="background:#FEF2F2;border:1.5px solid #FECACA;border-radius:14px;padding:18px 22px;margin-bottom:24px;display:flex;align-items:flex-start;gap:14px;">
        <div style="width:42px;height:42px;background:#DC2626;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-xmark" style="color:white;font-size:18px;"></i>
        </div>
        <div style="flex:1;">
            <div style="font-weight:700;font-size:14px;color:#991B1B;">Agent Application Not Approved</div>
            <div style="font-size:13px;color:#7F1D1D;margin-top:4px;"><strong>Reason:</strong> {{ $application->admin_notes }}</div>
            <a href="{{ route('become.agent') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:8px 16px;background:#DC2626;color:white;border-radius:9999px;font-size:13px;font-weight:700;text-decoration:none;">
                <i class="fa-solid fa-rotate-right"></i> Resubmit Application
            </a>
        </div>
    </div>
    @elseif($application->status === 'approved')
    <div style="background:linear-gradient(135deg,#ECFDF5,#D1FAE5);border:1.5px solid #6EE7B7;border-radius:14px;padding:18px 22px;margin-bottom:24px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;background:#059669;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-circle-check" style="color:white;font-size:18px;"></i>
        </div>
        <div style="flex:1;">
            <div style="font-weight:700;font-size:14px;color:#065F46;">Your agent application is approved!</div>
            <div style="font-size:13px;color:#047857;">Redirecting you to Agent Dashboard…</div>
        </div>
        <a href="{{ route('agent.dashboard') }}" style="padding:8px 18px;background:#059669;color:white;border-radius:9999px;font-size:13px;font-weight:700;text-decoration:none;">Go to Agent Dashboard →</a>
    </div>
    @endif
@endif

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:28px;">
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
        <div class="stat-icon" style="background:#F5F3FF;color:#7C3AED;">
            <i class="fa-solid fa-building"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $recentListings->count() }}</div>
            <div class="stat-label">New Listings</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

    {{-- Recent Bookings --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fa-solid fa-calendar" style="color:var(--primary);"></i> My Recent Bookings</div>
            <a href="{{ route('appointments.index') }}" class="card-action">View All →</a>
        </div>
        @forelse($appointments as $appt)
        <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid var(--gray-100);">
            @if($appt->listing->images->first())
                <img src="{{ asset('storage/' . $appt->listing->images->first()->image_path) }}"
                    style="width:52px;height:42px;object-fit:cover;border-radius:8px;flex-shrink:0;">
            @else
                <div style="width:52px;height:42px;background:var(--gray-100);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-building" style="color:var(--gray-300);"></i>
                </div>
            @endif
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:700;color:var(--gray-900);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $appt->listing->title }}
                </div>
                <div style="font-size:12px;color:var(--gray-500);">
                    {{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }} at {{ $appt->time }}
                </div>
            </div>
            <span class="badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
        </div>
        @empty
        <div class="card-empty" style="padding:36px 20px;">
            <i class="fa-solid fa-calendar-xmark"></i>
            <p>No bookings yet</p>
            <a href="{{ route('listings.index') }}" class="btn-primary btn-sm">Browse Properties</a>
        </div>
        @endforelse
    </div>

    {{-- Recent Listings + Become Agent CTA --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Become an Agent card (only if not already agent and no pending) --}}
        @if(auth()->user()->role !== 'agent' && (!$application || $application->status === 'rejected'))
        <div style="background:linear-gradient(135deg,var(--primary),#2D6A4F);border-radius:16px;padding:24px;color:white;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-20px;right:-20px;width:120px;height:120px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-30px;right:30px;width:80px;height:80px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;opacity:0.7;margin-bottom:8px;">Career Opportunity</div>
            <div style="font-size:20px;font-weight:800;margin-bottom:8px;line-height:1.2;">Become a Verified<br>NyumbaHub Agent</div>
            <div style="font-size:13px;opacity:0.85;margin-bottom:18px;">List properties, earn commissions, and grow your real estate business on our platform.</div>
            <a href="{{ route('become.agent') }}"
                style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:var(--accent,#D4A017);color:var(--primary);border-radius:9999px;font-size:13px;font-weight:800;text-decoration:none;">
                <i class="fa-solid fa-briefcase"></i> Apply Now
            </a>
        </div>
        @endif

        {{-- Recent Listings --}}
        <div class="card" style="flex:1;">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-building" style="color:var(--primary);"></i> New Listings</div>
                <a href="{{ route('listings.index') }}" class="card-action">Browse All →</a>
            </div>
            @forelse($recentListings->take(4) as $listing)
            <a href="{{ route('listings.show', $listing->slug) }}"
                style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid var(--gray-100);text-decoration:none;transition:background 0.15s;"
                onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background=''">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                        style="width:52px;height:42px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:var(--gray-900);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $listing->title }}
                    </div>
                    <div style="font-size:12px;color:var(--gray-500);">
                        <i class="fa-solid fa-location-dot" style="color:var(--accent);"></i> {{ $listing->location }}
                        · TZS {{ number_format($listing->price) }}
                    </div>
                </div>
            </a>
            @empty
            <div class="card-empty" style="padding:36px 20px;">
                <i class="fa-solid fa-building-circle-xmark"></i>
                <p>No listings available</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
