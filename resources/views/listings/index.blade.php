@extends('layouts.app')

@section('title', 'Listings — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
@endpush

@section('content')

{{-- Page header --}}
<div class="listings-hero">
    <div class="listings-hero-content">
        <h1 class="listings-hero-title">
            {{ __('Properties in ') }} <span>{{ __('Arusha') }}</span>
        </h1>
        <p class="listings-hero-sub">
            {{ __('Find your ') }} <span>{{ __('perfect home') }}</span> {{ __(' — for rent or sale') }}
        </p>
    </div>
</div>

<div class="container-wide">
{{-- Filters --}}
<div class="filters-bar">
    <form method="GET" action="{{ route('listings.index') }}" class="filters-form">

        <div class="filter-group">
            <label for="search">{{ __('Search') }}</label>
            <div class="input-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search" name="search"
                    placeholder="{{ __('Location, title...') }}"
                    value="{{ request('search') }}">
            </div>
        </div>

        <div class="filter-group">
            <label for="type">{{ __('Type') }}</label>
            <select id="type" name="type">
                <option value="">{{ __('All Types') }}</option>
                <option value="rent"  {{ request('type') === 'rent'  ? 'selected' : '' }}>{{ __('For Rent') }}</option>
                <option value="sale"  {{ request('type') === 'sale'  ? 'selected' : '' }}>{{ __('For Sale') }}</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="category">{{ __('Category') }}</label>
            <select id="category" name="category">
                <option value="">{{ __('All Categories') }}</option>
                <option value="apartment"  {{ request('category') === 'apartment'  ? 'selected' : '' }}>{{ __('Apartment') }}</option>
                <option value="house"      {{ request('category') === 'house'      ? 'selected' : '' }}>{{ __('House') }}</option>
                <option value="villa"      {{ request('category') === 'villa'      ? 'selected' : '' }}>{{ __('Villa') }}</option>
                <option value="land"       {{ request('category') === 'land'       ? 'selected' : '' }}>{{ __('Land') }}</option>
                <option value="commercial" {{ request('category') === 'commercial' ? 'selected' : '' }}>{{ __('Commercial') }}</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="min_price">{{ __('Min Price (TZS)') }}</label>
            <input type="number" id="min_price" name="min_price"
                placeholder="0" value="{{ request('min_price') }}">
        </div>

        <div class="filter-group">
            <label for="max_price">{{ __('Max Price (TZS)') }}</label>
            <input type="number" id="max_price" name="max_price"
                placeholder="{{ __('Any') }}" value="{{ request('max_price') }}">
        </div>

        <div class="filter-group">
            <label for="bedrooms">{{ __('Bedrooms') }}</label>
            <select id="bedrooms" name="bedrooms">
                <option value="">{{ __('Any') }}</option>
                <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1+</option>
                <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2+</option>
                <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+</option>
                <option value="4" {{ request('bedrooms') === '4' ? 'selected' : '' }}>4+</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
            </button>
            <a href="{{ route('listings.index') }}" class="btn-outline">
                <i class="fa-solid fa-xmark"></i> {{ __('Clear') }}
            </a>
        </div>

    </form>
</div>

{{-- Results count + sort --}}
<div class="listings-meta">
    <span class="results-count">
        @if(isset($listings) && $listings->count() > 0)
            {{ $listings->total() }} properties found
        @else
            No properties found
        @endif
    </span>

    <form method="GET" action="{{ route('listings.index') }}" id="sortForm">
        @foreach(request()->except('sort') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="sort-select">
            <option value="newest"     {{ request('sort') === 'newest'     ? 'selected' : '' }}>{{ __('Newest First') }}</option>
            <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
        </select>
    </form>
</div>

{{-- Listings grid --}}
@if(isset($listings) && $listings->count() > 0)
    @php
        $userFavorites = [];
        if (auth()->check()) {
            $userFavorites = auth()->user()->favorites()->pluck('listing_id')->toArray();
        }
    @endphp
    <div class="listings-grid">
        @foreach($listings as $listing)
        <div class="listing-card">

            <div class="listing-image">
               @if($listing->images->first())
    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}" alt="{{ $listing->title }}">
@else
    <div class="listing-image-placeholder">
        <i class="fa-solid fa-building"></i>
    </div>
@endif
                <span class="listing-badge {{ $listing->type === 'rent' ? 'badge-rent' : 'badge-sale' }}">
                    {{ $listing->type === 'rent' ? 'For Rent' : 'For Sale' }}
                </span>
                
                @auth
                    <form action="{{ route('favorites.toggle', $listing->slug) }}" method="POST" class="favorite-form" data-id="{{ $listing->id }}" style="position: absolute; top: 12px; right: 12px; z-index: 2;">
                        @csrf
                        <button type="submit" class="favorite-btn-card" aria-label="Toggle favorite" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255, 255, 255, 0.9); border: none; display: flex; align-items: center; justify-content: center; color: {{ in_array($listing->id, $userFavorites) ? 'var(--error)' : 'var(--text-muted)' }}; font-size: 14px; cursor: pointer; transition: all 0.2s;">
                            <i class="{{ in_array($listing->id, $userFavorites) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('favorites.add_intent', $listing->slug) }}" aria-label="Login to toggle favorite" style="position: absolute; top: 12px; right: 12px; z-index: 2; width: 32px; height: 32px; border-radius: 50%; background: rgba(255, 255, 255, 0.9); border: none; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 14px; cursor: pointer; transition: all 0.2s; text-decoration: none;">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                @endauth
            </div>

            <div class="listing-info">
                <h3 class="listing-title">{{ $listing->title }}</h3>
                <div class="listing-location">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $listing->location }}, Arusha
                </div>
                <div class="listing-price">
                    TZS {{ number_format($listing->price) }}
                    @if($listing->type === 'rent')
                        <span class="price-period">{{ __('/month') }}</span>
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
                    <a href="{{ route('listings.show', $listing->slug) }}" class="btn-view">
                        View <i class="fa-solid fa-arrow-right"></i>
                    </a>
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
        <h2>{{ __('No properties found') }}</h2>
        <p>{{ __('Try adjusting your filters or check back later for new listings.') }}</p>
        <a href="{{ route('listings.index') }}" class="btn-outline">{{ __('Clear filters') }}</a>
    </div>
@endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.favorite-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('button');
            const icon = btn.querySelector('i');
            
            // Optimistic UI update
            if (icon.classList.contains('fa-solid')) {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
                btn.style.color = 'var(--text-muted)';
            } else {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
                btn.style.color = 'var(--error)';
            }
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || this.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url; // Handle unverified email redirect
                    return;
                }
                if (response.status === 403) {
                    window.location.href = "{{ route('verification.notice') }}";
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    // Update exact state from server
                    if (data.is_favorited) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        btn.style.color = 'var(--error)';
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        btn.style.color = 'var(--text-muted)';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endpush
