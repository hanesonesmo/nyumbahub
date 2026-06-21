@extends('layouts.app')

@section('title', 'Properties in Arusha — NyumbaHub')

@push('styles')
   <link rel="stylesheet" href="{{ asset('css/listings.css') }}?v={{ time() }}">
@endpush

@section('content')

{{-- Hero --}}
<div class="listings-hero">
    <div class="listings-hero-content">
        <h1 class="listings-hero-title">Find Your <span>Perfect</span> Home</h1>
        <p class="listings-hero-sub">Browse verified properties for rent and sale across Arusha</p>

        <form method="GET" action="{{ route('listings.index') }}" class="hero-search">
            <input type="text" name="search" class="hero-search-input"
                placeholder="Search by location or title..."
                value="{{ request('search') }}">
            <div class="hero-search-divider"></div>
            <button type="submit" class="hero-search-btn">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
        </form>
    </div>
</div>

{{-- Filter tabs --}}
<div class="filters-section">
    <div class="filter-tabs">
        <a href="{{ route('listings.index') }}" class="filter-tab {{ !request('type') && !request('category') ? 'active' : '' }}">
            <i class="fa-solid fa-border-all"></i> All
        </a>
        <a href="{{ route('listings.index', ['type' => 'rent']) }}" class="filter-tab {{ request('type') === 'rent' ? 'active' : '' }}">
            <i class="fa-solid fa-key"></i> For Rent
        </a>
        <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="filter-tab {{ request('type') === 'sale' ? 'active' : '' }}">
            <i class="fa-solid fa-tag"></i> For Sale
        </a>
        <a href="{{ route('listings.index', ['category' => 'apartment']) }}" class="filter-tab {{ request('category') === 'apartment' ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i> Apartments
        </a>
        <a href="{{ route('listings.index', ['category' => 'house']) }}" class="filter-tab {{ request('category') === 'house' ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i> Houses
        </a>
        <a href="{{ route('listings.index', ['category' => 'villa']) }}" class="filter-tab {{ request('category') === 'villa' ? 'active' : '' }}">
            <i class="fa-solid fa-house-chimney"></i> Villas
        </a>
        <a href="{{ route('listings.index', ['category' => 'land']) }}" class="filter-tab {{ request('category') === 'land' ? 'active' : '' }}">
            <i class="fa-solid fa-mountain-sun"></i> Land
        </a>
        <a href="{{ route('listings.index', ['category' => 'commercial']) }}" class="filter-tab {{ request('category') === 'commercial' ? 'active' : '' }}">
            <i class="fa-solid fa-store"></i> Commercial
        </a>
    </div>

    {{-- Advanced filters --}}
    <div class="filters-bar">
        <form method="GET" action="{{ route('listings.index') }}" class="filters-form">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <div class="filter-group">
                <label>Min Price (TZS)</label>
                <input type="number" name="min_price" placeholder="0" value="{{ request('min_price') }}">
            </div>

            <div class="filter-group">
                <label>Max Price (TZS)</label>
                <input type="number" name="max_price" placeholder="Any" value="{{ request('max_price') }}">
            </div>

            <div class="filter-group">
                <label>Bedrooms</label>
                <select name="bedrooms">
                    <option value="">Any</option>
                    <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1+</option>
                    <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2+</option>
                    <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+</option>
                    <option value="4" {{ request('bedrooms') === '4' ? 'selected' : '' }}>4+</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Location</label>
                <select name="location">
                    <option value="">All Areas</option>
                    @foreach(['Njiro','Sakina','Themi','Kimandolu','Ngarenaro','Kijenge','Kaloleni','Sekei','Olorien','Lemara','Moshono'] as $area)
                        <option value="{{ $area }}" {{ request('location') === $area ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-sliders"></i> Filter
                </button>
                <a href="{{ route('listings.index') }}" class="btn-outline">
                    <i class="fa-solid fa-xmark"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Results meta --}}
<div class="listings-meta">
    <div class="results-count">
        @if(isset($listings) && $listings->total() > 0)
            {{ number_format($listings->total()) }} properties <span>found in Arusha</span>
        @else
            <span>No properties found</span>
        @endif
    </div>

    <form method="GET" action="{{ route('listings.index') }}" id="sortForm">
        @foreach(request()->except('sort') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
        </select>
    </form>
</div>

{{-- Listings grid --}}
@if(isset($listings) && $listings->count() > 0)
    <div class="listings-grid">
        @foreach($listings as $listing)
        <div class="listing-card" onclick="window.location='{{ route('listings.show', $listing->id) }}'">

            <div class="listing-image">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                        alt="{{ $listing->title }}" loading="lazy">
                @else
                    <div class="listing-image-placeholder">
                        <i class="fa-solid fa-building"></i>
                    </div>
                @endif

                <span class="listing-badge badge-{{ $listing->type }}">
                    {{ $listing->type === 'rent' ? 'For Rent' : 'For Sale' }}
                </span>

                <button class="listing-wishlist" onclick="event.stopPropagation()">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>

            <div class="listing-info">
                <div class="listing-location">
                    <i class="fa-solid fa-location-dot" style="color:var(--accent);"></i>
                    {{ $listing->location }}, Arusha
                </div>

                <h3 class="listing-title">{{ $listing->title }}</h3>
                <div class="listing-category">{{ ucfirst($listing->category) }}</div>

                @if($listing->bedrooms || $listing->bathrooms || $listing->area)
                <div class="listing-features">
                    @if($listing->bedrooms)
                        <div class="feature-item">
                            <i class="fa-solid fa-bed"></i> {{ $listing->bedrooms }} bed
                        </div>
                    @endif
                    @if($listing->bathrooms)
                        <div class="feature-item">
                            <i class="fa-solid fa-shower"></i> {{ $listing->bathrooms }} bath
                        </div>
                    @endif
                    @if($listing->area)
                        <div class="feature-item">
                            <i class="fa-solid fa-ruler-combined"></i> {{ $listing->area }}m²
                        </div>
                    @endif
                </div>
                @endif

                <div class="listing-divider"></div>

                <div class="listing-footer">
                    <div>
                        <div class="listing-price">
                            TZS {{ number_format($listing->price) }}
                            @if($listing->type === 'rent')
                                <span class="price-period">/mo</span>
                            @endif
                        </div>
                    </div>
                    <div class="listing-agent">
                        <div class="agent-avatar">
                            {{ strtoupper(substr($listing->agent->first_name ?? 'A', 0, 1)) }}
                        </div>
                        {{ $listing->agent->first_name ?? 'Agent' }}
                    </div>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    <div class="pagination-wrapper">
        {{ $listings->withQueryString()->links() }}
    </div>

@else
    <div class="listings-empty">
        <i class="fa-solid fa-building-circle-xmark"></i>
        <h2>No properties found</h2>
        <p>Try adjusting your filters or search in a different area.</p>
        <a href="{{ route('listings.index') }}" class="btn-outline">Clear all filters</a>
    </div>
@endif

@endsection
