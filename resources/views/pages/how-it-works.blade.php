@extends('layouts.app')
@section('title', 'How It Works — NyumbaHub')
@section('content')

{{-- Hero --}}
<div style="text-align:center;padding:48px 24px;margin-bottom:48px;">
    <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(27,67,50,0.08);color:var(--primary);padding:6px 14px;border-radius:9999px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:16px;">
        <i class="fa-solid fa-circle-info"></i> Simple Process
    </div>
    <h1 style="font-family:var(--font-display);font-size:42px;font-weight:700;color:var(--gray-900);margin-bottom:12px;">How NyumbaHub Works</h1>
    <p style="font-size:16px;color:var(--gray-500);max-width:500px;margin:0 auto;line-height:1.7;">
        Finding your perfect property in Arusha is easier than ever. Here's everything you need to know.
    </p>
</div>

{{-- For Tenants & Buyers --}}
<div style="margin-bottom:56px;">
    <h2 style="font-family:var(--font-display);font-size:26px;font-weight:700;color:var(--gray-900);margin-bottom:28px;display:flex;align-items:center;gap:10px;">
        <span style="width:36px;height:36px;border-radius:50%;background:var(--primary);color:white;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">
            <i class="fa-solid fa-user"></i>
        </span>
        For Tenants & Buyers
    </h2>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0;position:relative;">
        @foreach([
            ['num'=>'01','icon'=>'fa-magnifying-glass','title'=>'Search','desc'=>'Browse hundreds of verified listings. Filter by type, price, location, and size.','color'=>'#2563EB','bg'=>'#EFF6FF'],
            ['num'=>'02','icon'=>'fa-heart','title'=>'Shortlist','desc'=>'Save your favourite properties. Compare options side by side before deciding.','color'=>'#E11D48','bg'=>'#FFF1F2'],
            ['num'=>'03','icon'=>'fa-calendar-plus','title'=>'Book Viewing','desc'=>'Book a property viewing appointment with the agent at your preferred time.','color'=>'#D97706','bg'=>'#FFFBEB'],
            ['num'=>'04','icon'=>'fa-key','title'=>'Move In','desc'=>'Contact the agent via WhatsApp, finalize the deal and move into your new home.','color'=>'#059669','bg'=>'#ECFDF5'],
        ] as $i => $step)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:28px 24px;margin:0 {{ $i < 3 ? '8px' : '0' }} 0 {{ $i > 0 ? '8px' : '0' }};text-align:center;position:relative;box-shadow:var(--shadow-xs);">
            <div style="font-size:11px;font-weight:800;color:{{ $step['color'] }};letter-spacing:2px;margin-bottom:14px;">STEP {{ $step['num'] }}</div>
            <div style="width:56px;height:56px;border-radius:16px;background:{{ $step['bg'] }};display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;color:{{ $step['color'] }};">
                <i class="fa-solid {{ $step['icon'] }}"></i>
            </div>
            <h3 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">{{ $step['title'] }}</h3>
            <p style="font-size:13px;color:var(--gray-500);line-height:1.7;">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- For Agents --}}
<div style="margin-bottom:56px;">
    <h2 style="font-family:var(--font-display);font-size:26px;font-weight:700;color:var(--gray-900);margin-bottom:28px;display:flex;align-items:center;gap:10px;">
        <span style="width:36px;height:36px;border-radius:50%;background:var(--accent);color:var(--primary-dark);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">
            <i class="fa-solid fa-user-tie"></i>
        </span>
        For Property Agents
    </h2>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
        @foreach([
            ['num'=>'01','icon'=>'fa-user-plus','title'=>'Register as Agent','desc'=>'Create your agent account on NyumbaHub. It takes less than 2 minutes.','color'=>'#2563EB','bg'=>'#EFF6FF'],
            ['num'=>'02','icon'=>'fa-plus-circle','title'=>'Add Your Listings','desc'=>'Upload property details, photos, and pricing. Submit for admin review.','color'=>'#D97706','bg'=>'#FFFBEB'],
            ['num'=>'03','icon'=>'fa-chart-line','title'=>'Get Clients','desc'=>'Once approved, your listings go live. Manage bookings from your dashboard.','color'=>'#059669','bg'=>'#ECFDF5'],
        ] as $step)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:16px;padding:28px;box-shadow:var(--shadow-xs);">
            <div style="font-size:11px;font-weight:800;color:{{ $step['color'] }};letter-spacing:2px;margin-bottom:14px;">STEP {{ $step['num'] }}</div>
            <div style="width:52px;height:52px;border-radius:14px;background:{{ $step['bg'] }};display:flex;align-items:center;justify-content:center;margin-bottom:16px;font-size:20px;color:{{ $step['color'] }};">
                <i class="fa-solid {{ $step['icon'] }}"></i>
            </div>
            <h3 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">{{ $step['title'] }}</h3>
            <p style="font-size:14px;color:var(--gray-500);line-height:1.7;">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- FAQ --}}
<div style="margin-bottom:48px;">
    <h2 style="font-family:var(--font-display);font-size:26px;font-weight:700;color:var(--gray-900);margin-bottom:24px;">Frequently Asked Questions</h2>

    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach([
            ['q'=>'Is NyumbaHub free to use?','a'=>'Yes! Browsing listings and booking viewings is completely free for tenants and buyers. Agents may have listing fees in the future.'],
            ['q'=>'How do I know listings are genuine?','a'=>'Every listing goes through our admin approval process before going live. We verify agent details and property information.'],
            ['q'=>'Can I contact the agent directly?','a'=>'Yes. Once you find a property you like, you can contact the agent via WhatsApp directly from the listing page.'],
            ['q'=>'What areas does NyumbaHub cover?','a'=>'We currently cover all major neighbourhoods in Arusha including Njiro, Sakina, Themi, Kimandolu, Ngarenaro, Kijenge and more.'],
            ['q'=>'How do I become an agent on NyumbaHub?','a'=>'Register an account and select "Agent" as your role. Once registered, you can start adding listings immediately.'],
        ] as $faq)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:12px;padding:20px 24px;box-shadow:var(--shadow-xs);">
            <div style="font-size:15px;font-weight:700;color:var(--gray-900);margin-bottom:8px;display:flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-circle-question" style="color:var(--primary);font-size:14px;"></i>
                {{ $faq['q'] }}
            </div>
            <div style="font-size:14px;color:var(--gray-500);line-height:1.7;padding-left:22px;">{{ $faq['a'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- CTA --}}
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:20px;padding:48px;text-align:center;">
    <h2 style="font-family:var(--font-display);font-size:28px;font-weight:700;color:white;margin-bottom:12px;">Ready to Get Started?</h2>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);margin-bottom:28px;">Join NyumbaHub today — it's free and takes less than a minute.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('register') }}" class="btn-primary" style="background:var(--accent);color:var(--primary-dark);">
            <i class="fa-solid fa-user-plus"></i> Create Free Account
        </a>
        <a href="{{ route('listings.index') }}" class="btn-outline" style="border-color:rgba(255,255,255,0.3);color:white;">
            <i class="fa-solid fa-building"></i> Browse Listings
        </a>
    </div>
</div>

@endsection
