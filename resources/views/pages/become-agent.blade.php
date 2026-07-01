@extends('layouts.app')
@section('title', __('Become an Agent — NyumbaHub'))
@section('content')

{{-- Hero Section --}}
<div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 80px 40px; margin-bottom: 64px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
    <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(212,168,83,0.15) 0%, transparent 60%); filter: blur(30px);"></div>
    <div style="position:absolute; bottom:-100px; left:-100px; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%); filter: blur(30px);"></div>
    
    <div style="position:relative; z-index:1; max-width:700px; margin:0 auto;">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:8px 20px; border-radius:99px; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px; backdrop-filter:blur(10px);">
            <i class="fa-solid fa-user-tie"></i> {{ __('For Agents') }}
        </div>
        <h1 style="font-family:var(--font-display); font-size:56px; font-weight:800; color:#fff; line-height:1.1; margin-bottom:24px; letter-spacing:-1px;">
            {{ __('Grow Your Real Estate') }}<br><span style="color:var(--accent);">{{ __('Business in Arusha') }}</span>
        </h1>
        <p style="font-size:18px; color:rgba(255,255,255,0.7); margin-bottom:40px; line-height:1.7;">
            {{ __('Join 120+ verified agents already using NyumbaHub to reach thousands of buyers and tenants across Arusha.') }}
        </p>
        <div style="display:flex; justify-content:center; gap:16px;">
            <a href="{{ route('register') }}" class="btn-primary" style="padding:16px 40px; font-size:16px; border-radius:99px; box-shadow:0 10px 25px rgba(212,168,83,0.3);">
                <i class="fa-solid fa-user-plus" style="margin-right:8px;"></i> {{ __('Register as Agent — It\'s Free') }}
            </a>
        </div>
    </div>
</div>

{{-- Benefits Grid --}}
<div style="margin-bottom:80px; max-width:1100px; margin-left:auto; margin-right:auto;">
    <div style="text-align:center; margin-bottom:48px;">
        <h2 style="font-family:var(--font-display); font-size:36px; font-weight:800; color:var(--gray-900); margin-bottom:16px; letter-spacing:-0.5px;">{{ __('Why Join NyumbaHub?') }}</h2>
        <p style="font-size:16px; color:var(--gray-500); max-width:500px; margin:0 auto;">{{ __('Everything you need to succeed as a property agent in Arusha') }}</p>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:24px;">
        @foreach([
            ['icon'=>'fa-users', 'color'=>'#2563EB', 'bg'=>'#EFF6FF', 'title'=>'Reach More Clients', 'desc'=>'Access thousands of verified tenants and buyers actively searching for properties in Arusha.'],
            ['icon'=>'fa-building', 'color'=>'#059669', 'bg'=>'#ECFDF5', 'title'=>'Unlimited Listings', 'desc'=>'Add as many property listings as you want. Each listing includes up to 5 high-quality photos.'],
            ['icon'=>'fa-calendar-check', 'color'=>'#D97706', 'bg'=>'#FFFBEB', 'title'=>'Manage Bookings', 'desc'=>'Receive and manage viewing appointment requests directly from your agent dashboard.'],
            ['icon'=>'fa-brands fa-whatsapp', 'color'=>'#25D366', 'bg'=>'#F0FFF4', 'title'=>'WhatsApp Integration', 'desc'=>'Clients can contact you instantly via WhatsApp directly from your listing page.'],
            ['icon'=>'fa-shield-halved', 'color'=>'#7C3AED', 'bg'=>'#F5F3FF', 'title'=>'Verified Badge', 'desc'=>'Get a verified agent badge on all your listings — builds trust with potential clients.'],
            ['icon'=>'fa-chart-line', 'color'=>'#E11D48', 'bg'=>'#FFF1F2', 'title'=>'Analytics Dashboard', 'desc'=>'Track how many people view your listings and how many bookings you receive each month.'],
        ] as $b)
        <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:32px; box-shadow:var(--shadow-sm); transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor:default;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)';">
            <div style="width:56px; height:56px; border-radius:16px; background:{{ $b['bg'] }}; display:flex; align-items:center; justify-content:center; margin-bottom:20px; font-size:24px; color:{{ $b['color'] }}; box-shadow:0 4px 12px {{ str_replace(')', ', 0.15)', str_replace('rgb', 'rgba', $b['color'])) }};">
                <i class="{{ str_contains($b['icon'], 'brands') ? $b['icon'] : 'fa-solid '.$b['icon'] }}"></i>
            </div>
            <h3 style="font-family:var(--font-display); font-size:20px; font-weight:700; color:var(--gray-900); margin-bottom:12px;">{{ __($b['title']) }}</h3>
            <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __($b['desc']) }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- Subscription Plans --}}
<div style="margin-bottom:80px; max-width:1100px; margin-left:auto; margin-right:auto;">
    <div style="text-align:center; margin-bottom:48px;">
        <h2 style="font-family:var(--font-display); font-size:36px; font-weight:800; color:var(--gray-900); margin-bottom:16px; letter-spacing:-0.5px;">{{ __('Choose Your Plan') }}</h2>
        <p style="font-size:16px; color:var(--gray-500); max-width:500px; margin:0 auto;">{{ __('Select a subscription plan to become a verified agent') }}</p>
    </div>

    @if(session('success'))
        <div style="background:#ECFDF5; color:#059669; padding:16px; border-radius:12px; margin-bottom:24px; text-align:center; border:1px solid #A7F3D0;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#FEF2F2; color:#DC2626; padding:16px; border-radius:12px; margin-bottom:24px; text-align:center; border:1px solid #FECACA;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:24px;">
        @foreach($plans ?? [] as $plan)
        <div style="background:#fff; border:1px solid var(--border); border-radius:24px; padding:40px; box-shadow:var(--shadow-sm); width:100%; max-width:350px; display:flex; flex-direction:column; position:relative;">
            <h3 style="font-family:var(--font-display); font-size:24px; font-weight:700; color:var(--gray-900); margin-bottom:8px;">{{ $plan->name }}</h3>
            <p style="font-size:15px; color:var(--gray-500); margin-bottom:24px;">{{ $plan->description }}</p>
            <div style="margin-bottom:32px;">
                <span style="font-size:40px; font-weight:800; color:var(--gray-900);">TZS {{ number_format($plan->price) }}</span>
                <span style="font-size:16px; color:var(--gray-500);">/{{ $plan->billing_cycle }}</span>
            </div>
            
            <ul style="list-style:none; padding:0; margin:0 0 32px 0; flex-grow:1;">
                <li style="display:flex; align-items:center; gap:12px; margin-bottom:16px; font-size:15px; color:var(--gray-700);">
                    <i class="fa-solid fa-check" style="color:var(--accent);"></i> {{ $plan->maximum_listings }} Property Listings
                </li>
                <li style="display:flex; align-items:center; gap:12px; margin-bottom:16px; font-size:15px; color:var(--gray-700);">
                    <i class="fa-solid fa-check" style="color:var(--accent);"></i> Verified Agent Badge
                </li>
                <li style="display:flex; align-items:center; gap:12px; font-size:15px; color:var(--gray-700);">
                    <i class="fa-solid fa-check" style="color:var(--accent);"></i> Dashboard Analytics
                </li>
            </ul>

            @auth
                @if(auth()->user()->role === 'agent')
                    <div style="text-align:center; padding:16px; background:#F3F4F6; border-radius:12px; color:var(--gray-500); font-weight:600;">
                        You are already an Agent
                    </div>
                @else
                    <form action="{{ route('become-agent.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <div style="margin-bottom:16px;">
                            <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:var(--gray-700);">M-Pesa Phone Number</label>
                            <input type="text" name="phone_number" placeholder="254700000000" required style="width:100%; padding:12px 16px; border:1px solid var(--border); border-radius:12px; font-family:var(--font-body); font-size:15px;">
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%; padding:16px; border-radius:12px; font-size:16px; font-weight:600;">
                            Subscribe via M-Pesa
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-primary" style="display:block; text-align:center; padding:16px; border-radius:12px; font-size:16px; font-weight:600;">
                    Log in to Subscribe
                </a>
            @endauth
        </div>
        @endforeach

        @if(isset($plans) && $plans->isEmpty())
            <div style="text-align:center; color:var(--gray-500); padding:40px; width:100%;">
                No subscription plans are currently available. Please check back later.
            </div>
        @endif
    </div>
</div>

@endsection
