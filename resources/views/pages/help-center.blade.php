@extends('layouts.app')
@section('title', 'Help Center — NyumbaHub')
@section('content')

<div style="max-width:800px;margin:0 auto;">

    {{-- Header --}}
    <div style="text-align:center;margin-bottom:48px;">
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(27,67,50,0.08);color:var(--primary);padding:6px 14px;border-radius:9999px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:16px;">
            <i class="fa-solid fa-circle-question"></i> Help Center
        </div>
        <h1 style="font-family:var(--font-display);font-size:40px;font-weight:700;color:var(--gray-900);margin-bottom:12px;">How Can We Help?</h1>
        <p style="font-size:16px;color:var(--gray-500);">Find answers to the most common questions about NyumbaHub.</p>
    </div>

    {{-- Categories --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:48px;">
        @foreach([
            ['icon'=>'fa-user','color'=>'#2563EB','bg'=>'#EFF6FF','title'=>'Account & Profile','count'=>'8 articles'],
            ['icon'=>'fa-building','color'=>'#059669','bg'=>'#ECFDF5','title'=>'Listings','count'=>'12 articles'],
            ['icon'=>'fa-calendar','color'=>'#D97706','bg'=>'#FFFBEB','title'=>'Bookings','count'=>'6 articles'],
            ['icon'=>'fa-shield-halved','color'=>'#7C3AED','bg'=>'#F5F3FF','title'=>'Safety & Trust','count'=>'5 articles'],
            ['icon'=>'fa-user-tie','color'=>'#E11D48','bg'=>'#FFF1F2','title'=>'For Agents','count'=>'10 articles'],
            ['icon'=>'fa-envelope','color'=>'#0891B2','bg'=>'#ECFEFF','title'=>'Contact Support','count'=>'Get help'],
        ] as $cat)
        <div style="background:white;border:1px solid var(--gray-200);border-radius:14px;padding:20px;text-align:center;cursor:pointer;transition:all 0.2s;box-shadow:var(--shadow-xs);">
            <div style="width:48px;height:48px;border-radius:12px;background:{{ $cat['bg'] }};display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:20px;color:{{ $cat['color'] }};">
                <i class="fa-solid {{ $cat['icon'] }}"></i>
            </div>
            <div style="font-size:14px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">{{ $cat['title'] }}</div>
            <div style="font-size:12px;color:var(--gray-500);">{{ $cat['count'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- FAQs --}}
    @foreach([
        ['section'=>'Account & Profile','faqs'=>[
            ['q'=>'How do I create an account?','a'=>'Click "Register" in the top navigation. Fill in your name, email, phone, and choose your role (Tenant, Buyer, or Agent). It takes less than 2 minutes.'],
            ['q'=>'How do I reset my password?','a'=>'Click "Forgot Password" on the login page. Enter your email and we\'ll send you a reset link. The link expires in 60 minutes.'],
            ['q'=>'Can I change my role after registering?','a'=>'Currently role changes require contacting our support team. Email us at nyumbahub26@gmail.com with your request.'],
        ]],
        ['section'=>'Listings','faqs'=>[
            ['q'=>'How do I search for a property?','a'=>'Use the search bar at the top of any page or go to the Listings page. You can filter by type (rent/sale), category, price, bedrooms, and location.'],
            ['q'=>'How do I know a listing is genuine?','a'=>'Every listing is reviewed and approved by our admin team before going live. We verify agent credentials and property information.'],
            ['q'=>'Can I save listings I like?','a'=>'The favourites/save feature is coming soon. For now, you can bookmark the listing page in your browser.'],
        ]],
        ['section'=>'Bookings & Appointments','faqs'=>[
            ['q'=>'How do I book a property viewing?','a'=>'Open the listing you\'re interested in and click "Book a Viewing". Choose your preferred date and time. The agent will confirm your appointment.'],
            ['q'=>'Can I cancel an appointment?','a'=>'Yes. Go to "My Bookings" in your dashboard and click Cancel next to the appointment you want to remove.'],
            ['q'=>'How will I know if my booking is confirmed?','a'=>'Your booking status will update in your dashboard. The agent confirms or cancels your request from their dashboard.'],
        ]],
    ] as $section)
    <div style="margin-bottom:36px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid var(--gray-200);">
            {{ $section['section'] }}
        </h2>
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($section['faqs'] as $faq)
            <div style="background:white;border:1px solid var(--gray-200);border-radius:12px;padding:18px 20px;box-shadow:var(--shadow-xs);">
                <div style="font-size:14px;font-weight:700;color:var(--gray-900);margin-bottom:6px;display:flex;gap:8px;">
                    <i class="fa-solid fa-circle-question" style="color:var(--primary);margin-top:2px;flex-shrink:0;"></i>
                    {{ $faq['q'] }}
                </div>
                <div style="font-size:14px;color:var(--gray-500);line-height:1.7;padding-left:22px;">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Still need help --}}
    <div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:20px;padding:40px;text-align:center;">
        <h2 style="font-family:var(--font-display);font-size:24px;font-weight:700;color:white;margin-bottom:10px;">Still Need Help?</h2>
        <p style="font-size:14px;color:rgba(255,255,255,0.7);margin-bottom:24px;">Our support team responds within 24 hours on business days.</p>
        <a href="{{ route('contact') }}" class="btn-primary" style="background:var(--accent);color:var(--primary-dark);">
            <i class="fa-solid fa-envelope"></i> Contact Support
        </a>
    </div>

</div>

@endsection
