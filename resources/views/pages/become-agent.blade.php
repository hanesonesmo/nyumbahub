@extends('layouts.app')
@section('title', 'Become an Agent — NyumbaHub')
@section('content')

{{-- Hero --}}
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:20px;padding:64px 48px;margin-bottom:48px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-60px;right:-60px;width:240px;height:240px;border-radius:50%;background:rgba(212,168,83,0.1);"></div>
    <div style="position:absolute;bottom:-40px;left:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.05);"></div>
    <div style="position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(212,168,83,0.2);border:1px solid rgba(212,168,83,0.3);color:#D4A853;padding:6px 14px;border-radius:9999px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:16px;">
            <i class="fa-solid fa-user-tie"></i> For Agents
        </div>
        <h1 style="font-family:var(--font-display);font-size:44px;font-weight:700;color:white;margin-bottom:14px;">
            Grow Your Real Estate<br><span style="color:#D4A853;">Business in Arusha</span>
        </h1>
        <p style="font-size:16px;color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto 32px;line-height:1.7;">
            Join 120+ verified agents already using NyumbaHub to reach thousands of buyers and tenants across Arusha.
        </p>
        <a href="{{ route('register') }}" class="btn-primary" style="background:var(--accent);color:var(--primary-dark);padding:14px 36px;font-size:15px;font-weight:700;">
            <i class="fa-solid fa-user-plus"></i> Register as Agent — It's Free
        </a>
    </div>
</div>

{{-- Benefits --}}
<div style="margin-bottom:56px;">
    <h2 style="font-family:var(--font-display);font-size:28px;font-weight:700;color:var(--gray-900);text-align:center;margin-bottom:8px;">Why Join NyumbaHub?</h2>
    <p style="font-size:15px;color:var(--gray-500);text-align:center;margin-bottom:32px;">Everything you need to succeed as a property agent in Arusha</p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
        @foreach([
            ['icon'=>'fa-users','color'=>'#2563EB','bg'=>'#EFF6FF','title'=>'Reach More Clients','desc'=>'Access thousands of verified tenants and buyers actively searching for properties in Arusha.'],
            ['icon'=>'fa-building','color'=>'#059669','bg'=>'#ECFDF5','title'=>'Unlimited Listings','desc'=>'Add as many property listings as you want. Each listing includes up to 5 high-quality photos.'],
            ['icon'=>'fa-calendar-check','color'=>'#D97706','bg'=>'#FFFBEB','title'=>'Manage Bookings','desc'=>'Receive and manage viewing appointment requests directly from your agent dashboard.'],
            ['icon'=>'fa-brands fa-whatsapp','color'=>'#25D366','bg'=>'#F0FFF4','title'=>'WhatsApp Integration','desc'=>'Clients can contact you instantly via WhatsApp directly from your listing page.'],
            ['icon'=>'fa-shield-halved','color'=>'#7C3AED','bg'=>'#F5F3FF','title'=>'Verified Badge','desc'=>'Get a verified agent badge on all your listings — builds trust with potential clients.'],
            ['icon'=>'fa-chart-line','color'=>'#E11D48','bg'=>'#FFF1F2','title'=>'Analytics','desc'=>'Track how many people view your listings and how many bookings you receive each month.'],
        ] as $b)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:24px;box-shadow:var(--shadow-xs);">
            <div style="width:48px;height:48px;border-radius:12px;background:{{ $b['bg'] }};display:flex;align-items:center;justify-content:center;margin-bottom:14px;font-size:20px;color:{{ $b['color'] }};">
                <i class="{{ str_contains($b['icon'],'brands') ? $b['icon'] : 'fa-solid '.$b['icon'] }}"></i>
            </div>
            <h3 style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:6px;">{{ $b['title'] }}</h3>
            <p style="font-size:13px;color:var(--gray-500);line-height:1.7;">{{ $b['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- How to join --}}
<div style="background:var(--gray-50);border-radius:20px;padding:48px;margin-bottom:48px;">
    <h2 style="font-family:var(--font-display);font-size:26px;font-weight:700;color:var(--gray-900);text-align:center;margin-bottom:32px;">How to Get Started</h2>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center;">
        @foreach([
            ['num'=>'1','icon'=>'fa-user-plus','title'=>'Register','desc'=>'Create a free account and select Agent as your role.'],
            ['num'=>'2','icon'=>'fa-id-card','title'=>'Complete Profile','desc'=>'Add your WhatsApp number and profile details.'],
            ['num'=>'3','icon'=>'fa-upload','title'=>'Add Listings','desc'=>'Upload your property listings with photos and details.'],
            ['num'=>'4','icon'=>'fa-check-circle','title'=>'Go Live','desc'=>'Admin approves your listings and they go live instantly.'],
        ] as $step)
        <div>
            <div style="width:52px;height:52px;border-radius:50%;background:var(--primary);color:white;display:flex;align-items:center;justify-content:center;font-size:20px;margin:0 auto 12px;">
                <i class="fa-solid {{ $step['icon'] }}"></i>
            </div>
            <div style="font-size:11px;font-weight:800;color:var(--accent);letter-spacing:1.5px;margin-bottom:6px;">STEP {{ $step['num'] }}</div>
            <h3 style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">{{ $step['title'] }}</h3>
            <p style="font-size:13px;color:var(--gray-500);line-height:1.6;">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- CTA --}}
<div style="text-align:center;padding:20px 0;">
    <h2 style="font-family:var(--font-display);font-size:28px;font-weight:700;color:var(--gray-900);margin-bottom:12px;">Ready to Join?</h2>
    <p style="font-size:15px;color:var(--gray-500);margin-bottom:24px;">Registration is free and takes less than 2 minutes.</p>
    <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 40px;font-size:15px;">
        <i class="fa-solid fa-user-plus"></i> Register as Agent Now
    </a>
</div>

@endsection
