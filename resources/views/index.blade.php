@extends('layouts.app')

@section('title', 'Listings — NyumbaHub')

@section('content')

{{-- Page header --}}
<div class="listings-header">
    <div>
        <h1 class="listings-title">Properties in Arusha</h1>
        <p class="listings-subtitle">Find your perfect home — for rent or sale</p>
    </div>
</div>

{{-- Filters --}}
<div class="filters-bar">
    <form method="GET" action="{{ route('listings.index') }}" class="filters-form">

        {{-- Search --}}
        <div class="filter-group">
            <label for="search">Search</label>
            <div class="input-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search" name="search"
                    placeholder="Location, title..."
                    value="{{ request('search') }}">
            </div>
        </div>

        {{-- Type --}}
        <div class="filter-group">
            <label for="type">Type</label>
            <select id="type" name="type">
                <option value="">All Types</option>
                <option value="rent"  {{ request('type') === 'rent'  ? 'selected' : '' }}>For Rent</option>
                <option value="sale"  {{ request('type') === 'sale'  ? 'selected' : '' }}>For Sale</option>
            </select>
        </div>

        {{-- Category --}}
        <div class="filter-group">
            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="">All Categories</option>
                <option value="apartment"  {{ request('category') === 'apartment'  ? 'selected' : '' }}>Apartment</option>
                <option value="house"      {{ request('category') === 'house'      ? 'selected' : '' }}>House</option>
                <option value="villa"      {{ request('category') === 'villa'      ? 'selected' : '' }}>Villa</option>
                <option value="land"       {{ request('category') === 'land'       ? 'selected' : '' }}>Land</option>
                <option value="commercial" {{ request('category') === 'commercial' ? 'selected' : '' }}>Commercial</option>
            </select>
        </div>

        {{-- Min price --}}
        <div class="filter-group">
            <label for="min_price">Min Price (TZS)</label>
            <input type="number" id="min_price" name="min_price"
                placeholder="0"
                value="{{ request('min_price') }}">
        </div>

        {{-- Max price --}}
        <div class="filter-group">
            <label for="max_price">Max Price (TZS)</label>
            <input type="number" id="max_price" name="max_price"
                placeholder="Any"
                value="{{ request('max_price') }}">
        </div>

        {{-- Bedrooms --}}
        <div class="filter-group">
            <label for="bedrooms">Bedrooms</label>
            <select id="bedrooms" name="bedrooms">
                <option value="">Any</option>
                <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1+</option>
                <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2+</option>
                <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+</option>
                <option value="4" {{ request('bedrooms') === '4' ? 'selected' : '' }}>4+</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <a href="{{ route('listings.index') }}" class="btn-outline">
                <i class="fa-solid fa-xmark"></i> Clear
            </a>
        </div>

    </form>
</div>

{{-- Results count --}}
<div class="listings-meta">
    <span class="results-count">
        @if(isset($listings) && $listings->count() > 0)
            {{ $listings->total() }} properties found
        @else
            No properties found
        @endif
    </span>

    {{-- Sort --}}
    <form method="GET" action="{{ route('listings.index') }}" id="sortForm">
        @foreach(request()->except('sort') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="sort-select">
            <option value="newest"    {{ request('sort') === 'newest'    ? 'selected' : '' }}>Newest First</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc"{{ request('sort') === 'price_desc'? 'selected' : '' }}>Price: High to Low</option>
        </select>
    </form>
</div>

{{-- Listings grid --}}
@if(isset($listings) && $listings->count() > 0)
    <div class="listings-grid">
        @foreach($listings as $listing)
        <div class="listing-card">

            {{-- Image --}}
            <div class="listing-image">
                @if($listing->image)
                    <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->title }}">
                @else
                    <div class="listing-image-placeholder">
                        <i class="fa-solid fa-building"></i>
                    </div>
                @endif

                {{-- Badge --}}
                <span class="listing-badge {{ $listing->type === 'rent' ? 'badge-rent' : 'badge-sale' }}">
                    {{ $listing->type === 'rent' ? 'For Rent' : 'For Sale' }}
                </span>
            </div>

            {{-- Info --}}
            <div class="listing-info">
                <h3 class="listing-title">{{ $listing->title }}</h3>

                <div class="listing-location">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $listing->location }}, Arusha
                </div>

                <div class="listing-price">
                    TZS {{ number_format($listing->price) }}
                    @if($listing->type === 'rent')
                        <span class="price-period">/month</span>
                    @endif
                </div>

                <div class="listing-features">
                    @if($listing->bedrooms)
                        <span class="feature-tag">
                            <i class="fa-solid fa-bed"></i> {{ $listing->bedrooms }} Bed
                        </span>
                    @endif
                    @if($listing->bathrooms)
                        <span class="feature-tag">
                            <i class="fa-solid fa-shower"></i> {{ $listing->bathrooms }} Bath
                        </span>
                    @endif
                    @if($listing->area)
                        <span class="feature-tag">
                            <i class="fa-solid fa-ruler-combined"></i> {{ $listing->area }} m²
                        </span>
                    @endif
                </div>

                <div class="listing-footer">
                    <div class="listing-agent">
                        <i class="fa-solid fa-circle-user"></i>
                        {{ $listing->agent->first_name ?? 'Agent' }}
                    </div>
                    <a href="{{ route('listings.show', $listing->id) }}" class="btn-view">
                        View <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        {{ $listings->withQueryString()->links() }}
    </div>

@else
    {{-- Empty state --}}
    <div class="listings-empty">
        <i class="fa-solid fa-building-circle-xmark"></i>
        <h2>No properties found</h2>
        <p>Try adjusting your filters or check back later for new listings.</p>
        <a href="{{ route('listings.index') }}" class="btn-outline">Clear filters</a>
    </div>
@endif

@endsection
