@extends('layouts.app')

@section('title', 'NyumbaHub — Your Next Home, Found in Arusha')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ time() }}">
@endpush

@section('content')

{{-- HERO --}}
<div class="hero">
    <div class="hero-bg">
        <img src="{{ asset('images/themes/light.jpg') }}" alt="Arusha Properties">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <div class="hero-badge">
            <i class="fa-solid fa-location-dot"></i> Arusha, Tanzania
        </div>
        <h1 class="hero-title">Find Your Perfect<br><span>Home in Arusha</span></h1>
        <p class="hero-sub">Browse hundreds of verified properties for rent and sale across all neighbourhoods in Arusha.</p>

        {{-- Search --}}
        <form action="{{ route('listings.index') }}" method="GET" class="hero-search-form">
            <div class="hero-search-box">
                <div class="hero-search-field">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Search</label>
                    <input type="text" name="search" placeholder="Location, property name...">
                </div>
                <div class="hero-search-divider"></div>
                <div class="hero-search-field">
                    <label><i class="fa-solid fa-tag"></i> Type</label>
                    <select name="type">
                        <option value="">Rent or Buy</option>
                        <option value="rent">For Rent</option>
                        <option value="sale">For Sale</option>
                    </select>
                </div>
                <div class="hero-search-divider"></div>
                <div class="hero-search-field">
                    <label><i class="fa-solid fa-building"></i> Category</label>
                    <select name="category">
                        <option value="">Any Type</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                        <option value="villa">Villa</option>
                        <option value="land">Land</option>
                        <option value="commercial">Commercial</option>
                    </select>
                </div>
                <button type="submit" class="hero-search-submit">
                    <i class="fa-solid fa-magnifying-glass"></i> Search
                </button>
            </div>
        </form>

        {{-- Quick stats --}}
        <div class="hero-stats">
            <div class="hero-stat">
                <strong>500+</strong>
                <span>Properties</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <strong>120+</strong>
                <span>Verified Agents</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <strong>3,000+</strong>
                <span>Happy Users</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <strong>10+</strong>
                <span>Neighbourhoods</span>
            </div>
        </div>
    </div>
</div>

{{-- BROWSE BY TYPE --}}
<div class="section">
    <div class="section-header">
        <div>
            <h2 class="section-title">Browse by Type</h2>
            <p class="section-sub">Find exactly what you're looking for</p>
        </div>
    </div>

    <div class="type-grid">
        <a href="{{ route('listings.index', ['type' => 'rent']) }}" class="type-card">
            <div class="type-icon" style="background:rgba(27,67,50,0.1);">
                <i class="fa-solid fa-key" style="color:#1B4332;"></i>
            </div>
            <div class="type-name">For Rent</div>
            <div class="type-desc">Monthly rentals across Arusha</div>
            <div class="type-arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </a>
        <a href="{{ route('listings.index', ['type' => 'sale']) }}" class="type-card">
            <div class="type-icon" style="background:rgba(212,168,83,0.1);">
                <i class="fa-solid fa-house" style="color:#D4A853;"></i>
            </div>
            <div class="type-name">For Sale</div>
            <div class="type-desc">Own your dream property</div>
            <div class="type-arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </a>
        <a href="{{ route('listings.index', ['category' => 'apartment']) }}" class="type-card">
            <div class="type-icon" style="background:rgba(45,106,79,0.1);">
                <i class="fa-solid fa-building" style="color:#2D6A4F;"></i>
            </div>
            <div class="type-name">Apartments</div>
            <div class="type-desc">Modern city living</div>
            <div class="type-arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </a>
        <a href="{{ route('listings.index', ['category' => 'villa']) }}" class="type-card">
            <div class="type-icon" style="background:rgba(193,53,21,0.08);">
                <i class="fa-solid fa-house-chimney" style="color:#C13515;"></i>
            </div>
            <div class="type-name">Villas</div>
            <div class="type-desc">Luxury premium homes</div>
            <div class="type-arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </a>
        <a href="{{ route('listings.index', ['category' => 'land']) }}" class="type-card">
            <div class="type-icon" style="background:rgba(0,138,5,0.08);">
                <i class="fa-solid fa-mountain-sun" style="color:#008A05;"></i>
            </div>
            <div class="type-name">Land</div>
            <div class="type-desc">Build your own home</div>
            <div class="type-arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </a>
        <a href="{{ route('listings.index', ['category' => 'commercial']) }}" class="type-card">
            <div class="type-icon" style="background:rgba(200,112,0,0.08);">
                <i class="fa-solid fa-store" style="color:#C87000;"></i>
            </div>
            <div class="type-name">Commercial</div>
            <div class="type-desc">Offices & business spaces</div>
            <div class="type-arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </a>
    </div>
</div>

{{-- FEATURED LISTINGS --}}
@if(isset($featuredListings) && $featuredListings->count() > 0)
<div class="section">
    <div class="section-header">
        <div>
            <h2 class="section-title">Featured Properties</h2>
            <p class="section-sub">Hand-picked properties just for you</p>
        </div>
        <a href="{{ route('listings.index') }}" class="btn-outline">
            View All <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="listings-grid">
        @foreach($featuredListings as $listing)
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
                    <i class="fa-solid fa-location-dot" style="color:var(--accent,#D4A853);"></i>
                    {{ $listing->location }}, Arusha
                </div>
                <h3 class="listing-title">{{ $listing->title }}</h3>
                <div class="listing-category">{{ ucfirst($listing->category) }}</div>
                @if($listing->bedrooms || $listing->bathrooms || $listing->area)
                <div class="listing-features">
                    @if($listing->bedrooms)
                        <div class="feature-item"><i class="fa-solid fa-bed"></i> {{ $listing->bedrooms }} bed</div>
                    @endif
                    @if($listing->bathrooms)
                        <div class="feature-item"><i class="fa-solid fa-shower"></i> {{ $listing->bathrooms }} bath</div>
                    @endif
                    @if($listing->area)
                        <div class="feature-item"><i class="fa-solid fa-ruler-combined"></i> {{ $listing->area }}m²</div>
                    @endif
                </div>
                @endif
                <div class="listing-divider"></div>
                <div class="listing-footer">
                    <div class="listing-price">
                        TZS {{ number_format($listing->price) }}
                        @if($listing->type === 'rent')
                            <span class="price-period">/mo</span>
                        @endif
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
</div>
@endif

{{-- HOW IT WORKS --}}
<div class="section how-section">
    <div class="section-header" style="text-align:center;display:block;">
        <h2 class="section-title" style="text-align:center;">How NyumbaHub Works</h2>
        <p class="section-sub" style="text-align:center;">Find your home in 3 simple steps</p>
    </div>

    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number">01</div>
            <div class="step-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
            <h3 class="step-title">Search Properties</h3>
            <p class="step-desc">Browse hundreds of verified listings across all neighbourhoods in Arusha. Filter by type, price, and size.</p>
        </div>
        <div class="step-connector"><i class="fa-solid fa-arrow-right"></i></div>
        <div class="step-card">
            <div class="step-number">02</div>
            <div class="step-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <h3 class="step-title">Book a Viewing</h3>
            <p class="step-desc">Found something you like? Book a viewing appointment directly with the agent at your preferred time.</p>
        </div>
        <div class="step-connector"><i class="fa-solid fa-arrow-right"></i></div>
        <div class="step-card">
            <div class="step-number">03</div>
            <div class="step-icon"><i class="fa-solid fa-key"></i></div>
            <h3 class="step-title">Move In</h3>
            <p class="step-desc">Connect with the agent via WhatsApp, complete the deal, and move into your new home in Arusha.</p>
        </div>
    </div>
</div>

{{-- NEIGHBOURHOODS --}}
<div class="section">
    <div class="section-header">
        <div>
            <h2 class="section-title">Popular Neighbourhoods</h2>
            <p class="section-sub">Explore properties by area</p>
        </div>
    </div>

    <div class="neighbourhood-grid">
        @foreach(['Njiro','Sakina','Themi','Kimandolu','Ngarenaro','Kijenge','Kaloleni','Sekei'] as $area)
        <a href="{{ route('listings.index', ['location' => $area]) }}" class="neighbourhood-card">
            <i class="fa-solid fa-location-dot"></i>
            <span>{{ $area }}</span>
            <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:11px;opacity:0.5;"></i>
        </a>
        @endforeach
    </div>
</div>

{{-- CTA --}}
@guest
<div class="cta-section">
    <div class="cta-content">
        <h2 class="cta-title">Are You a Property Agent?</h2>
        <p class="cta-desc">List your properties on NyumbaHub and reach thousands of buyers and tenants across Arusha.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;font-size:15px;">
                <i class="fa-solid fa-user-plus"></i> Register as Agent
            </a>
            <a href="{{ route('listings.index') }}" class="btn-outline" style="padding:14px 32px;font-size:15px;border-color:rgba(255,255,255,0.3);color:#fff;">
                <i class="fa-solid fa-building"></i> Browse Properties
            </a>
        </div>
    </div>
</div>
@endguest

@endsection
