@extends('layouts.app')
@section('title', 'About Us — NyumbaHub')
@section('content')

{{-- Hero --}}
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:20px;padding:64px 48px;margin-bottom:48px;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(212,168,83,0.1);"></div>
    <div style="position:absolute;bottom:-60px;left:-30px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.05);"></div>
    <div style="position:relative;z-index:1;max-width:600px;">
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(212,168,83,0.2);border:1px solid rgba(212,168,83,0.3);color:#D4A853;padding:6px 14px;border-radius:9999px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:16px;">
            <i class="fa-solid fa-star"></i> Our Story
        </div>
        <h1 style="font-family:var(--font-display);font-size:44px;font-weight:700;color:white;line-height:1.2;margin-bottom:16px;">
            Connecting Arusha to<br><span style="color:#D4A853;">Better Homes</span>
        </h1>
        <p style="font-size:16px;color:rgba(255,255,255,0.75);line-height:1.7;max-width:480px;">
            NyumbaHub was built with a simple mission — make finding, renting, and buying property in Arusha easy, transparent, and trustworthy.
        </p>
    </div>
</div>

{{-- Mission --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-bottom:48px;align-items:center;">
    <div>
        <h2 style="font-family:var(--font-display);font-size:32px;font-weight:700;color:var(--gray-900);margin-bottom:16px;">Our Mission</h2>
        <p style="font-size:15px;color:var(--gray-600);line-height:1.8;margin-bottom:16px;">
            We believe everyone in Arusha deserves access to quality housing. Whether you're a first-time renter, a family looking to buy, or an agent wanting to reach more clients — NyumbaHub is the platform built for you.
        </p>
        <p style="font-size:15px;color:var(--gray-600);line-height:1.8;">
            We verify every listing, protect user privacy, and make the entire process from search to booking as smooth as possible.
        </p>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        @foreach([
            ['icon'=>'fa-house','label'=>'500+','desc'=>'Verified Listings'],
            ['icon'=>'fa-users','label'=>'3,000+','desc'=>'Happy Users'],
            ['icon'=>'fa-user-tie','label'=>'120+','desc'=>'Active Agents'],
            ['icon'=>'fa-location-dot','label'=>'10+','desc'=>'Neighbourhoods'],
        ] as $s)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:14px;padding:20px;text-align:center;box-shadow:var(--shadow-xs);">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(27,67,50,0.08);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-size:18px;color:var(--primary);">
                <i class="fa-solid {{ $s['icon'] }}"></i>
            </div>
            <div style="font-family:var(--font-display);font-size:24px;font-weight:700;color:var(--gray-900);">{{ $s['label'] }}</div>
            <div style="font-size:12px;color:var(--gray-500);margin-top:2px;">{{ $s['desc'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Values --}}
<div style="margin-bottom:48px;">
    <h2 style="font-family:var(--font-display);font-size:28px;font-weight:700;color:var(--gray-900);text-align:center;margin-bottom:8px;">Our Values</h2>
    <p style="font-size:15px;color:var(--gray-500);text-align:center;margin-bottom:32px;">What drives everything we do</p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
        @foreach([
            ['icon'=>'fa-shield-halved','color'=>'#2563EB','bg'=>'#EFF6FF','title'=>'Trust & Safety','desc'=>'Every listing is verified by our admin team before going live. We protect both tenants and agents.'],
            ['icon'=>'fa-eye','color'=>'#059669','bg'=>'#ECFDF5','title'=>'Transparency','desc'=>'No hidden fees, no surprises. What you see is what you get — honest pricing and honest agents.'],
            ['icon'=>'fa-handshake','color'=>'#D97706','bg'=>'#FFFBEB','title'=>'Community First','desc'=>'We\'re built for Arusha by people who understand Arusha. Local knowledge, global standards.'],
        ] as $v)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:28px;box-shadow:var(--shadow-xs);text-align:center;">
            <div style="width:56px;height:56px;border-radius:16px;background:{{ $v['bg'] }};display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;color:{{ $v['color'] }};">
                <i class="fa-solid {{ $v['icon'] }}"></i>
            </div>
            <h3 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">{{ $v['title'] }}</h3>
            <p style="font-size:14px;color:var(--gray-500);line-height:1.7;">{{ $v['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- CTA --}}
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:20px;padding:48px;text-align:center;">
    <h2 style="font-family:var(--font-display);font-size:32px;font-weight:700;color:white;margin-bottom:12px;">Ready to Find Your Home?</h2>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);margin-bottom:28px;">Join thousands of Arusha residents who found their perfect property on NyumbaHub.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('listings.index') }}" class="btn-primary" style="background:var(--accent);color:var(--primary-dark);">
            <i class="fa-solid fa-building"></i> Browse Listings
        </a>
        <a href="{{ route('register') }}" class="btn-outline" style="border-color:rgba(255,255,255,0.3);color:white;">
            <i class="fa-solid fa-user-plus"></i> Create Account
        </a>
    </div>
</div>

@endsection
