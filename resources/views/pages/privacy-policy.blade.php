@extends('layouts.app')
@section('title', 'Privacy Policy — NyumbaHub')
@section('content')

<div style="max-width:760px;margin:0 auto;">

    <div style="margin-bottom:40px;">
        <h1 style="font-family:var(--font-display);font-size:38px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">Privacy Policy</h1>
        <p style="font-size:14px;color:var(--gray-500);">Last updated: {{ date('F d, Y') }} · Effective immediately</p>
    </div>

    <div style="background:var(--primary-50);border:1px solid rgba(27,67,50,0.15);border-radius:12px;padding:18px 20px;margin-bottom:32px;font-size:14px;color:var(--primary);line-height:1.7;">
        <i class="fa-solid fa-circle-info" style="margin-right:8px;"></i>
        Your privacy is important to us. This policy explains what data we collect, how we use it, and how we protect it.
    </div>

    @foreach([
        ['title'=>'1. Information We Collect','content'=>'We collect information you provide when registering an account, such as your name, email address, phone number, and WhatsApp number. We also collect information about how you use NyumbaHub, including listings you view and appointments you book.'],
        ['title'=>'2. How We Use Your Information','content'=>'We use your information to provide and improve our services, send you appointment notifications, connect you with property agents, and ensure the security and integrity of our platform. We do not sell your personal data to third parties.'],
        ['title'=>'3. Information Sharing','content'=>'We share limited information with property agents when you book a viewing — specifically your name and contact details so the agent can confirm your appointment. Agents agree to our terms and may not use this information for unsolicited marketing.'],
        ['title'=>'4. Data Security','content'=>'We implement industry-standard security measures to protect your personal information. Your password is encrypted using bcrypt hashing. We use HTTPS encryption for all data transmitted on our platform.'],
        ['title'=>'5. Cookies','content'=>'NyumbaHub uses session cookies to keep you logged in and remember your preferences. We do not use tracking or advertising cookies. You can disable cookies in your browser settings, but this may affect platform functionality.'],
        ['title'=>'6. Your Rights','content'=>'You have the right to access, correct, or delete your personal information at any time. You can update your profile information from your dashboard. To request account deletion, contact us at nyumbahub26@gmail.com.'],
        ['title'=>'7. Children\'s Privacy','content'=>'NyumbaHub is not intended for use by anyone under 18 years of age. We do not knowingly collect personal information from children under 18.'],
        ['title'=>'8. Changes to This Policy','content'=>'We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting the new policy on this page with an updated date. Continued use of NyumbaHub after changes constitutes acceptance of the new policy.'],
        ['title'=>'9. Contact Us','content'=>'If you have any questions about this Privacy Policy, please contact us at nyumbahub26@gmail.com or visit our Contact Us page.'],
    ] as $section)
    <div style="margin-bottom:28px;">
        <h2 style="font-size:17px;font-weight:700;color:var(--gray-900);margin-bottom:10px;display:flex;align-items:center;gap:8px;">
            <span style="width:6px;height:6px;border-radius:50%;background:var(--primary);display:inline-block;flex-shrink:0;"></span>
            {{ $section['title'] }}
        </h2>
        <p style="font-size:14px;color:var(--gray-600);line-height:1.8;padding-left:14px;">{{ $section['content'] }}</p>
    </div>
    @endforeach

    <div style="background:var(--gray-50);border-radius:12px;padding:20px 24px;margin-top:32px;font-size:13px;color:var(--gray-500);text-align:center;">
        Questions? Contact us at <a href="mailto:nyumbahub26@gmail.com" style="color:var(--primary);font-weight:600;">nyumbahub26@gmail.com</a>
        or visit our <a href="{{ route('contact') }}" style="color:var(--primary);font-weight:600;">Contact page</a>.
    </div>

</div>

@endsection
