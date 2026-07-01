@extends('layouts.dashboard')

@section('title', __('My Listings'))
@section('page-title', __('My Property Portfolio'))
@section('page-subtitle', __('Manage your listings and view their performance'))

@section('topbar-actions')
    <a href="{{ route('agent.listings.create') }}" class="premium-btn">
        <i class="fa-solid fa-plus-circle"></i> {{ __('Add New Listing') }}
    </a>
@endsection

@section('content')

    {{-- Status Filters & Search --}}
    <div class="premium-panel" style="margin-bottom: 32px; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; gap: 8px;">
            <a href="#" class="premium-btn" style="background: var(--dash-primary);"><i class="fa-solid fa-border-all"></i> All</a>
            <a href="#" class="premium-btn" style="background: var(--dash-bg); color: var(--dash-text-muted); border: 1px solid var(--dash-border);"><i class="fa-solid fa-circle-check"></i> Active</a>
            <a href="#" class="premium-btn" style="background: var(--dash-bg); color: var(--dash-text-muted); border: 1px solid var(--dash-border);"><i class="fa-solid fa-clock"></i> Pending</a>
        </div>
        
        <div class="topbar-search" style="width: 300px;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search portfolio..." class="premium-input" style="padding-left: 48px;">
        </div>
    </div>

    {{-- Data Grid --}}
    <div class="data-card-grid">
        @forelse($listings as $listing)
            <div class="data-card">
                <div style="position: relative;">
                    @if($listing->images->first())
                        <img class="data-card-img" src="{{ asset('storage/' . $listing->images->first()->image_path) }}" alt="{{ $listing->title }}">
                    @else
                        <div class="data-card-img" style="background: var(--dash-border); display: flex; align-items: center; justify-content: center; font-size: 40px; color: var(--dash-text-muted);">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif

                    <div style="position: absolute; top: 12px; right: 12px;">
                        @if($listing->status === 'active')
                            <span class="timeline-badge bg-success" style="box-shadow: var(--dash-shadow);"><i class="fa-solid fa-check"></i> Active</span>
                        @elseif($listing->status === 'pending')
                            <span class="timeline-badge bg-warning" style="box-shadow: var(--dash-shadow);"><i class="fa-solid fa-clock"></i> Pending</span>
                        @elseif($listing->status === 'rejected')
                            <span class="timeline-badge bg-danger" style="box-shadow: var(--dash-shadow);"><i class="fa-solid fa-xmark"></i> Rejected</span>
                        @else
                            <span class="timeline-badge bg-primary" style="box-shadow: var(--dash-shadow);"><i class="fa-solid fa-building"></i> {{ ucfirst($listing->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="data-card-body">
                    <h3 class="data-card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $listing->title }}</h3>
                    <div style="color: var(--dash-primary); font-size: 18px; font-weight: 800; font-family: 'Playfair Display', serif; margin-bottom: 12px;">
                        TZS {{ number_format($listing->price) }}<span style="font-size: 14px; color: var(--dash-text-muted); font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;">{{ $listing->type === 'rent' ? '/mo' : '' }}</span>
                    </div>

                    <div class="data-card-stats">
                        <span><i class="fa-solid fa-eye" style="color: var(--dash-info);"></i> 1.2k views</span>
                        <span><i class="fa-solid fa-calendar-check" style="color: var(--dash-success);"></i> {{ \App\Models\Appointment::where('listing_id', $listing->id)->count() }} bookings</span>
                        <span><i class="fa-solid fa-clock"></i> {{ $listing->created_at->diffForHumans() }}</span>
                    </div>

                    @if($listing->status === 'rejected' && $listing->rejection_reason)
                        <div style="background: rgba(239, 68, 68, 0.1); color: var(--dash-danger); padding: 8px 12px; border-radius: var(--dash-radius-sm); font-size: 12px; font-weight: 600; margin-bottom: 16px;">
                            <i class="fa-solid fa-triangle-exclamation"></i> {{ $listing->rejection_reason }}
                        </div>
                    @endif

                    <div class="data-card-actions">
                        @if($listing->status === 'active')
                            <a href="{{ route('listings.show', $listing->slug) }}" class="btn-icon" title="View Public Listing"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        @endif
                        <a href="{{ route('agent.listings.edit', $listing->id) }}" class="btn-icon" title="Edit Listing"><i class="fa-solid fa-pen"></i></a>
                        
                        <div style="flex: 1;"></div>
                        
                        <form method="POST" action="{{ route('agent.listings.destroy', $listing->id) }}" onsubmit="return confirm('Delete this listing permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon danger" title="Delete Listing"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 60px 24px; text-align: center; background: var(--dash-surface); border-radius: var(--dash-radius); border: 1px dashed var(--dash-border);">
                <i class="fa-solid fa-building-circle-xmark" style="font-size: 48px; color: var(--dash-text-muted); margin-bottom: 16px;"></i>
                <h3 style="font-size: 18px; color: var(--dash-text); margin-bottom: 8px;">{{ __('No listings found') }}</h3>
                <p style="color: var(--dash-text-muted); margin-bottom: 24px;">{{ __('You have not added any properties to your portfolio yet.') }}</p>
                <a href="{{ route('agent.listings.create') }}" class="premium-btn">
                    <i class="fa-solid fa-plus"></i> {{ __('Add Your First Listing') }}
                </a>
            </div>
        @endforelse
    </div>

    @if($listings->hasPages())
        <div style="margin-top: 32px;">{{ $listings->links() }}</div>
    @endif

@endsection
