@extends('layouts.app')
@section('title', __('About Us — NyumbaHub'))
@section('content')

{{-- Hero Section --}}
<div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 80px 40px; margin-bottom: 64px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
    <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(212,168,83,0.15) 0%, transparent 60%); filter: blur(30px);"></div>
    <div style="position:absolute; bottom:-100px; left:-100px; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%); filter: blur(30px);"></div>
    
    <div style="position:relative; z-index:1; max-width:700px; margin:0 auto;">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:8px 20px; border-radius:99px; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px; backdrop-filter:blur(10px);">
            <i class="fa-solid fa-star"></i> {{ __('Our Story') }}
        </div>
        <h1 style="font-family:var(--font-display); font-size:56px; font-weight:800; color:#fff; line-height:1.1; margin-bottom:24px; letter-spacing:-1px;">
            {{ __('Connecting Arusha to') }}<br><span style="color:var(--accent);">{{ __('Better Homes') }}</span>
        </h1>
        <p style="font-size:18px; color:rgba(255,255,255,0.7); margin-bottom:0; line-height:1.7;">
            {{ __('NyumbaHub was built with a simple mission — make finding, renting, and buying property in Arusha easy, transparent, and trustworthy.') }}
        </p>
    </div>
</div>

{{-- Mission & Stats Grid --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; margin-bottom:80px; align-items:center; max-width:1100px; margin-left:auto; margin-right:auto;">
    <div>
        <h2 style="font-family:var(--font-display); font-size:36px; font-weight:800; color:var(--gray-900); margin-bottom:20px; letter-spacing:-0.5px;">{{ __('Our Mission') }}</h2>
        <div style="width:60px; height:4px; background:var(--accent); border-radius:2px; margin-bottom:24px;"></div>
        <p style="font-size:16px; color:var(--gray-600); line-height:1.8; margin-bottom:20px;">
            {{ __('We believe everyone in Arusha deserves access to quality housing. Whether you\'re a first-time renter, a family looking to buy, or an agent wanting to reach more clients — NyumbaHub is the platform built for you.') }}
        </p>
        <p style="font-size:16px; color:var(--gray-600); line-height:1.8;">
            {{ __('We verify every listing, protect user privacy, and make the entire process from search to booking as smooth as possible. Say goodbye to endless searching and unreliable agents.') }}
        </p>
    </div>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        @foreach([
            ['icon'=>'fa-house', 'label'=>'500+', 'desc'=>'Verified Listings'],
            ['icon'=>'fa-users', 'label'=>'3,000+', 'desc'=>'Happy Users'],
            ['icon'=>'fa-user-tie', 'label'=>'120+', 'desc'=>'Active Agents'],
            ['icon'=>'fa-location-dot', 'label'=>'10+', 'desc'=>'Neighbourhoods'],
        ] as $s)
        <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:20px; padding:32px; text-align:center; box-shadow:var(--shadow-sm); transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:56px; height:56px; border-radius:16px; background:rgba(27,67,50,0.08); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:24px; color:var(--primary);">
                <i class="fa-solid {{ $s['icon'] }}"></i>
            </div>
            <div style="font-family:var(--font-display); font-size:32px; font-weight:800; color:var(--gray-900); margin-bottom:4px;">{{ $s['label'] }}</div>
            <div style="font-size:14px; color:var(--gray-500); font-weight:500;">{{ __($s['desc']) }}</div>
        </div>
        @endforeach
    </div>
</div>

@endsection
