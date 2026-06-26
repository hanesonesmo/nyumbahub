@extends('layouts.dashboard')

@section('title', 'My Listings')
@section('page-title', 'My Listings')
@section('page-subtitle', 'Manage all your property listings')

@section('topbar-actions')
    <a href="{{ route('agent.listings.create') }}" class="btn-primary btn-sm">
        <i class="fa-solid fa-plus"></i> Add New Listing
    </a>
@endsection

@push('styles')
<style>
.listing-row { display:flex; gap:14px; align-items:center; padding:14px 20px; border-bottom:1px solid var(--gray-100); transition:background 0.15s; }
.listing-row:last-child { border-bottom:none; }
.listing-row:hover { background:var(--gray-50); }
.listing-thumb { width:72px; height:56px; border-radius:var(--radius-sm); object-fit:cover; flex-shrink:0; background:var(--gray-100); }
.listing-thumb-placeholder { width:72px; height:56px; border-radius:var(--radius-sm); background:var(--gray-100); display:flex; align-items:center; justify-content:center; color:var(--gray-300); font-size:20px; flex-shrink:0; }
.action-btn { display:inline-flex; align-items:center; gap:4px; padding:5px 12px; border-radius:var(--radius-full); font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:var(--font-body); transition:all 0.15s; text-decoration:none; }
.pending-notice { background:var(--warning-bg); border:1px solid var(--warning-border); border-radius:var(--radius); padding:10px 14px; font-size:12px; color:var(--warning); display:flex; align-items:center; gap:8px; margin-top:6px; }
</style>
@endpush

@section('content')

{{-- Status summary --}}
<div class="stats-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:24px;">
    @php
        $statusCounts = $listings->getCollection()->groupBy('status')->map->count();
    @endphp
    @foreach([
        ['status'=>'all',      'label'=>'Total',    'icon'=>'fa-building',      'color'=>'#2563EB','bg'=>'#EFF6FF'],
        ['status'=>'active',   'label'=>'Active',   'icon'=>'fa-circle-dot',    'color'=>'#059669','bg'=>'#ECFDF5'],
        ['status'=>'pending',  'label'=>'Pending',  'icon'=>'fa-clock',         'color'=>'#D97706','bg'=>'#FFFBEB'],
        ['status'=>'rejected', 'label'=>'Rejected', 'icon'=>'fa-circle-xmark',  'color'=>'#DC2626','bg'=>'#FEF2F2'],
        ['status'=>'sold',     'label'=>'Sold/Rented','icon'=>'fa-circle-check','color'=>'#7C3AED','bg'=>'#F5F3FF'],
    ] as $s)
    <div class="stat-card" style="padding:16px;">
        <div class="stat-icon" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};width:38px;height:38px;font-size:15px;">
            <i class="fa-solid {{ $s['icon'] }}"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number" style="font-size:20px;">
                @if($s['status'] === 'all')
                    {{ $listings->total() }}
                @else
                    {{ $statusCounts[$s['status']] ?? 0 }}
                @endif
            </div>
            <div class="stat-label" style="font-size:10px;">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Listings --}}
<div class="card">
    @forelse($listings as $listing)
    <div class="listing-row">

        {{-- Thumbnail --}}
        @if($listing->images->first())
            <img class="listing-thumb"
                src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                alt="{{ $listing->title }}">
        @else
            <div class="listing-thumb-placeholder">
                <i class="fa-solid fa-image"></i>
            </div>
        @endif

        {{-- Info --}}
        <div style="flex:1;min-width:0;">
            <div style="font-size:14px;font-weight:700;color:var(--gray-900);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $listing->title }}
            </div>
            <div style="font-size:12px;color:var(--gray-500);display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <span><i class="fa-solid fa-location-dot" style="color:var(--accent);"></i> {{ $listing->location }}, Arusha</span>
                <span><i class="fa-solid fa-tag"></i> {{ ucfirst($listing->type) }}</span>
                <span><i class="fa-solid fa-building"></i> {{ ucfirst($listing->category) }}</span>
                <span style="font-weight:600;color:var(--gray-700);">TZS {{ number_format($listing->price) }}{{ $listing->type === 'rent' ? '/mo' : '' }}</span>
            </div>

            {{-- Pending notice --}}
            @if($listing->status === 'pending')
            <div class="pending-notice">
                <i class="fa-solid fa-clock"></i>
                <span><strong>Waiting for admin approval.</strong> Your listing will go live once approved. This usually takes less than 24 hours.</span>
            </div>
            @endif

            {{-- Rejection reason --}}
            @if($listing->status === 'rejected' && $listing->rejection_reason)
            <div style="background:var(--error-bg);border:1px solid var(--error-border);border-radius:var(--radius);padding:8px 12px;font-size:12px;color:var(--error);margin-top:6px;display:flex;gap:8px;">
                <i class="fa-solid fa-circle-exclamation" style="margin-top:1px;flex-shrink:0;"></i>
                <span><strong>Rejected:</strong> {{ $listing->rejection_reason }}</span>
            </div>
            @endif
        </div>

        {{-- Status badge --}}
        <div style="flex-shrink:0;text-align:right;">
            <span class="badge badge-{{ $listing->status }}" style="margin-bottom:8px;display:inline-block;">
                {{ ucfirst($listing->status) }}
            </span>
            <div style="font-size:11px;color:var(--gray-400);">
                {{ $listing->created_at->format('d M Y') }}
            </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:6px;flex-shrink:0;align-items:center;">
            @if($listing->status === 'active')
                <a href="{{ route('listings.show', $listing->slug) }}"
                    class="action-btn" style="background:var(--gray-100);color:var(--gray-600);" target="_self">
                    <i class="fa-solid fa-eye"></i> View
                </a>
            @endif

            <a href="{{ route('agent.listings.edit', $listing->id) }}"
                class="action-btn" style="background:#EFF6FF;color:#2563EB;">
                <i class="fa-solid fa-pen"></i> Edit
            </a>

            @if($listing->status === 'active')
                @if($listing->type === 'sale')
                    <form method="POST" action="{{ route('agent.listings.markSold', $listing->id) }}"
                        onsubmit="return confirm('Mark as sold? This will cancel all pending appointments.')">
                        @csrf
                        <button type="submit" class="action-btn" style="background:#F5F3FF;color:#7C3AED;">
                            <i class="fa-solid fa-circle-check"></i> Sold
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('agent.listings.markRented', $listing->id) }}"
                        onsubmit="return confirm('Mark as rented? This will cancel all pending appointments.')">
                        @csrf
                        <button type="submit" class="action-btn" style="background:#ECFDF5;color:#059669;">
                            <i class="fa-solid fa-circle-check"></i> Rented
                        </button>
                    </form>
                @endif
            @endif

            <form method="POST" action="{{ route('agent.listings.destroy', $listing->id) }}"
                onsubmit="return confirm('Delete this listing permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn" style="background:var(--error-bg);color:var(--error);">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>

    </div>
    @empty
    <div class="card-empty" style="padding:60px 24px;">
        <i class="fa-solid fa-building-circle-xmark"></i>
        <p>You haven't added any listings yet</p>
        <a href="{{ route('agent.listings.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add Your First Listing
        </a>
    </div>
    @endforelse
</div>

@if($listings->hasPages())
<div style="margin-top:20px;">{{ $listings->links() }}</div>
@endif

@endsection
