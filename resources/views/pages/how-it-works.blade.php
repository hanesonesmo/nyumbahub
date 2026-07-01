@extends('layouts.app')
@section('title', __('How It Works — NyumbaHub'))
@section('content')

{{-- Hero Section --}}
<div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 80px 40px; margin-bottom: 64px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
    <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(212,168,83,0.15) 0%, transparent 60%); filter: blur(30px);"></div>
    <div style="position:absolute; bottom:-100px; left:-100px; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%); filter: blur(30px);"></div>
    
    <div style="position:relative; z-index:1; max-width:700px; margin:0 auto;">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:8px 20px; border-radius:99px; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px; backdrop-filter:blur(10px);">
            <i class="fa-solid fa-lightbulb"></i> {{ __('Simple & Transparent') }}
        </div>
        <h1 style="font-family:var(--font-display); font-size:56px; font-weight:800; color:#fff; line-height:1.1; margin-bottom:24px; letter-spacing:-1px;">
            {{ __('How NyumbaHub') }} <span style="color:var(--accent);">{{ __('Works') }}</span>
        </h1>
        <p style="font-size:18px; color:rgba(255,255,255,0.7); margin-bottom:0; line-height:1.7;">
            {{ __('Whether you are looking for your dream home or trying to reach more clients as an agent, we make the process effortless.') }}
        </p>
    </div>
</div>

<div style="max-width:1000px; margin:0 auto 80px;">

    {{-- For Renters & Buyers --}}
    <div style="margin-bottom:64px;">
        <h2 style="font-family:var(--font-display); font-size:32px; font-weight:800; color:var(--gray-900); margin-bottom:40px; text-align:center;">{{ __('For Renters & Buyers') }}</h2>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:32px; position:relative;">
            {{-- Connecting Line (visible only on desktop usually, but we'll use a neat trick with CSS if possible, else keep it clean) --}}
            
            <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px 32px; text-align:center; box-shadow:var(--shadow-sm); position:relative;">
                <div style="width:48px; height:48px; border-radius:50%; background:var(--primary-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:20px; font-weight:800; position:absolute; top:-24px; left:50%; transform:translateX(-50%); box-shadow:0 8px 16px rgba(15,45,31,0.2);">1</div>
                <div style="font-size:32px; color:var(--accent); margin-bottom:20px; margin-top:16px;"><i class="fa-solid fa-magnifying-glass-location"></i></div>
                <h3 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:12px;">{{ __('Search & Filter') }}</h3>
                <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __('Browse hundreds of verified listings across all neighbourhoods in Arusha. Filter by type, price, and size.') }}</p>
            </div>
            
            <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px 32px; text-align:center; box-shadow:var(--shadow-sm); position:relative;">
                <div style="width:48px; height:48px; border-radius:50%; background:var(--primary-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:20px; font-weight:800; position:absolute; top:-24px; left:50%; transform:translateX(-50%); box-shadow:0 8px 16px rgba(15,45,31,0.2);">2</div>
                <div style="font-size:32px; color:var(--accent); margin-bottom:20px; margin-top:16px;"><i class="fa-regular fa-calendar-check"></i></div>
                <h3 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:12px;">{{ __('Schedule a Tour') }}</h3>
                <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __('Book a viewing appointment online directly from the platform. Meet the agent and inspect the property.') }}</p>
            </div>
            
            <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px 32px; text-align:center; box-shadow:var(--shadow-sm); position:relative;">
                <div style="width:48px; height:48px; border-radius:50%; background:var(--primary-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:20px; font-weight:800; position:absolute; top:-24px; left:50%; transform:translateX(-50%); box-shadow:0 8px 16px rgba(15,45,31,0.2);">3</div>
                <div style="font-size:32px; color:var(--accent); margin-bottom:20px; margin-top:16px;"><i class="fa-solid fa-handshake"></i></div>
                <h3 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:12px;">{{ __('Make an Offer') }}</h3>
                <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __('Connect with the agent via WhatsApp, complete the deal, and move into your new home in Arusha.') }}</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('listings.index') }}" class="btn-primary" style="padding:14px 32px; border-radius:99px; font-size:15px;"><i class="fa-solid fa-search" style="margin-right:8px;"></i> {{ __('Start Searching') }}</a>
        </div>
    </div>

    <div style="height:1px; background:var(--border); margin:64px 0;"></div>

    {{-- For Agents --}}
    <div>
        <h2 style="font-family:var(--font-display); font-size:32px; font-weight:800; color:var(--gray-900); margin-bottom:40px; text-align:center;">{{ __('For Agents') }}</h2>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:32px;">
            
            <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px 32px; text-align:center; box-shadow:var(--shadow-sm); position:relative;">
                <div style="width:48px; height:48px; border-radius:50%; background:var(--primary-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:20px; font-weight:800; position:absolute; top:-24px; left:50%; transform:translateX(-50%); box-shadow:0 8px 16px rgba(15,45,31,0.2);">1</div>
                <div style="font-size:32px; color:var(--accent); margin-bottom:20px; margin-top:16px;"><i class="fa-solid fa-id-card"></i></div>
                <h3 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:12px;">{{ __('Create Profile') }}</h3>
                <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __('Register an agent account and get verified by our admin team to start listing properties.') }}</p>
            </div>
            
            <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px 32px; text-align:center; box-shadow:var(--shadow-sm); position:relative;">
                <div style="width:48px; height:48px; border-radius:50%; background:var(--primary-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:20px; font-weight:800; position:absolute; top:-24px; left:50%; transform:translateX(-50%); box-shadow:0 8px 16px rgba(15,45,31,0.2);">2</div>
                <div style="font-size:32px; color:var(--accent); margin-bottom:20px; margin-top:16px;"><i class="fa-solid fa-images"></i></div>
                <h3 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:12px;">{{ __('Post Listings') }}</h3>
                <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __('Upload high-quality photos, detailed descriptions, and precise locations for your properties.') }}</p>
            </div>
            
            <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px 32px; text-align:center; box-shadow:var(--shadow-sm); position:relative;">
                <div style="width:48px; height:48px; border-radius:50%; background:var(--primary-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:20px; font-weight:800; position:absolute; top:-24px; left:50%; transform:translateX(-50%); box-shadow:0 8px 16px rgba(15,45,31,0.2);">3</div>
                <div style="font-size:32px; color:var(--accent); margin-bottom:20px; margin-top:16px;"><i class="fa-solid fa-comments-dollar"></i></div>
                <h3 style="font-size:20px; font-weight:800; color:var(--gray-900); margin-bottom:12px;">{{ __('Close Deals') }}</h3>
                <p style="font-size:15px; color:var(--gray-600); line-height:1.7;">{{ __('Receive viewing requests and WhatsApp messages directly from interested clients.') }}</p>
            </div>
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('become-agent') }}" class="btn-primary" style="padding:14px 32px; border-radius:99px; font-size:15px; background:var(--accent); color:var(--primary-dark);"><i class="fa-solid fa-arrow-right" style="margin-right:8px;"></i> {{ __('Become an Agent') }}</a>
        </div>
    </div>

</div>

@endsection
