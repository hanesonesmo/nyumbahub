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
</div>{{-- BROWSE BY TYPE --}}
<div class="section">
    <div class="section-header">
        <div>
            <h2 class="section-title">Browse Properties</h2>
            <p class="section-sub">Find exactly what you're looking for in Arusha</p>
        </div>
        <a href="{{ route('listings.index') }}" class="btn-outline">
            View All <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">

        {{-- Large card — For Rent --}}
        <a href="{{ route('listings.index', ['type' => 'rent']) }}"
            style="background:linear-gradient(135deg,#1B4332,#2D6A4F);border-radius:20px;padding:28px;text-decoration:none;display:flex;flex-direction:column;justify-content:space-between;min-height:160px;position:relative;overflow:hidden;transition:transform 0.2s,box-shadow 0.2s;"
            onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(27,67,50,0.3)'"
            onmouseout="this.style.transform='';this.style.boxShadow=''">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,0.06);"></div>
            <div style="position:absolute;bottom:-30px;left:-10px;width:80px;height:80px;border-radius:50%;background:rgba(212,168,83,0.1);"></div>
            <div style="position:relative;z-index:1;">
                <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;font-size:20px;color:white;margin-bottom:14px;">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div style="font-size:18px;font-weight:700;color:white;margin-bottom:4px;">For Rent</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.65);">Monthly rentals across Arusha</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px;color:#D4A853;font-size:13px;font-weight:600;position:relative;z-index:1;margin-top:16px;">
                Browse Rentals <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        {{-- Large card — For Sale --}}
        <a href="{{ route('listings.index', ['type' => 'sale']) }}"
            style="background:linear-gradient(135deg,#B8922E,#D4A853);border-radius:20px;padding:28px;text-decoration:none;display:flex;flex-direction:column;justify-content:space-between;min-height:160px;position:relative;overflow:hidden;transition:transform 0.2s,box-shadow 0.2s;"
            onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(212,168,83,0.4)'"
            onmouseout="this.style.transform='';this.style.boxShadow=''">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,0.1);"></div>
            <div style="position:relative;z-index:1;">
                <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:20px;color:white;margin-bottom:14px;">
                    <i class="fa-solid fa-house"></i>
                </div>
                <div style="font-size:18px;font-weight:700;color:white;margin-bottom:4px;">For Sale</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.75);">Own your dream property</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px;color:white;font-size:13px;font-weight:600;position:relative;z-index:1;margin-top:16px;">
                Browse Sales <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        {{-- Category grid --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            @foreach([
                ['href'=>route('listings.index',['category'=>'apartment']),'icon'=>'fa-building','label'=>'Apartments','color'=>'#2563EB','bg'=>'#EFF6FF'],
                ['href'=>route('listings.index',['category'=>'villa']),'icon'=>'fa-house-chimney','label'=>'Villas','color'=>'#7C3AED','bg'=>'#F5F3FF'],
                ['href'=>route('listings.index',['category'=>'land']),'icon'=>'fa-mountain-sun','label'=>'Land','color'=>'#059669','bg'=>'#ECFDF5'],
                ['href'=>route('listings.index',['category'=>'commercial']),'icon'=>'fa-store','label'=>'Commercial','color'=>'#D97706','bg'=>'#FFFBEB'],
            ] as $cat)
            <a href="{{ $cat['href'] }}"
                style="background:white;border:1px solid var(--gray-200);border-radius:14px;padding:16px;text-decoration:none;display:flex;flex-direction:column;align-items:flex-start;gap:8px;transition:all 0.2s;box-shadow:var(--shadow-xs);"
                onmouseover="this.style.borderColor='{{ $cat['color'] }}';this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 16px rgba(0,0,0,0.1)'"
                onmouseout="this.style.borderColor='';this.style.transform='';this.style.boxShadow='var(--shadow-xs)'">
                <div style="width:36px;height:36px;border-radius:10px;background:{{ $cat['bg'] }};display:flex;align-items:center;justify-content:center;font-size:16px;color:{{ $cat['color'] }};">
                    <i class="fa-solid {{ $cat['icon'] }}"></i>
                </div>
                <div style="font-size:13px;font-weight:700;color:var(--gray-800);">{{ $cat['label'] }}</div>
            </a>
            @endforeach
        </div>

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
        <div class="listing-card" onclick="window.location='{{ route('listings.show', $listing->slug) }}'">
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
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:24px;padding:56px 48px;text-align:center;margin-bottom:0;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-60px;right:-60px;width:240px;height:240px;border-radius:50%;background:rgba(212,168,83,0.08);"></div>
    <div style="position:absolute;bottom:-40px;left:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
    <div style="position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(212,168,83,0.2);border:1px solid rgba(212,168,83,0.3);color:#D4A853;padding:6px 14px;border-radius:9999px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:20px;">
            <i class="fa-solid fa-user-tie"></i> For Property Agents
        </div>
        <h2 style="font-family:var(--font-display);font-size:36px;font-weight:700;color:white;margin-bottom:12px;line-height:1.2;">
            Grow Your Real Estate<br>Business in Arusha
        </h2>
        <p style="font-size:16px;color:rgba(255,255,255,0.7);margin-bottom:32px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;">
            Join 120+ verified agents already using NyumbaHub to reach thousands of buyers and tenants across Arusha. It's completely free to register.
        </p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}"
                style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:var(--accent);color:var(--primary-dark);border-radius:9999px;font-size:15px;font-weight:700;text-decoration:none;transition:all 0.2s;"
                onmouseover="this.style.background='#E8C47A';this.style.transform='translateY(-2px)'"
                onmouseout="this.style.background='var(--accent)';this.style.transform=''">
                <i class="fa-solid fa-user-tie"></i> Register as Agent — Free
            </a>
            <a href="{{ route('listings.index') }}"
                style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:transparent;color:white;border:2px solid rgba(255,255,255,0.3);border-radius:9999px;font-size:15px;font-weight:600;text-decoration:none;transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.6)'"
                onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.3)'">
                <i class="fa-solid fa-building"></i> Browse Properties
            </a>
        </div>
        <div style="display:flex;align-items:center;justify-content:center;gap:28px;margin-top:32px;flex-wrap:wrap;">
            @foreach(['Free to register','Admin verified','WhatsApp integration','Easy dashboard'] as $feature)
            <div style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.65);font-size:13px;">
                <i class="fa-solid fa-circle-check" style="color:#D4A853;font-size:12px;"></i>
                {{ $feature }}
            </div>
            @endforeach
        </div>
    </div>
</div>
@endguest

@endsection
