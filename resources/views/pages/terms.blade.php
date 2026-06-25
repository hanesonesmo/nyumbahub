@extends('layouts.app')
@section('title', 'Terms of Service — NyumbaHub')
@section('content')

<div style="max-width:760px;margin:0 auto;">

    <div style="margin-bottom:40px;">
        <h1 style="font-family:var(--font-display);font-size:38px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">Terms of Service</h1>
        <p style="font-size:14px;color:var(--gray-500);">Last updated: {{ date('F d, Y') }} · Please read carefully before using NyumbaHub.</p>
    </div>

    <div style="background:var(--warning-bg);border:1px solid var(--warning-border);border-radius:12px;padding:18px 20px;margin-bottom:32px;font-size:14px;color:var(--warning);line-height:1.7;">
        <i class="fa-solid fa-triangle-exclamation" style="margin-right:8px;"></i>
        By using NyumbaHub, you agree to these Terms of Service. If you do not agree, please do not use our platform.
    </div>

    @foreach([
        ['title'=>'1. Acceptance of Terms','content'=>'By accessing or using NyumbaHub ("the Platform"), you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using the platform.'],
        ['title'=>'2. User Accounts','content'=>'You must register an account to access certain features. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You must provide accurate and complete information when creating your account.'],
        ['title'=>'3. Agent Responsibilities','content'=>'Property agents are responsible for ensuring all listing information is accurate, up-to-date, and not misleading. Agents must not post properties they are not authorized to list. All listings are subject to admin approval before going live on the platform.'],
        ['title'=>'4. Prohibited Activities','content'=>'Users may not: post false or misleading property information, use the platform for illegal purposes, attempt to circumvent our security measures, harass or contact other users without their consent, or use automated tools to scrape or extract data from our platform.'],
        ['title'=>'5. Listing Approval','content'=>'All property listings submitted by agents are reviewed by our admin team before being published. We reserve the right to reject or remove any listing that violates our guidelines, contains false information, or is deemed inappropriate.'],
        ['title'=>'6. Appointments & Viewings','content'=>'NyumbaHub facilitates booking of property viewing appointments but is not a party to any rental or sale agreement. Any transaction between users and agents occurs outside of our platform and is the sole responsibility of those parties.'],
        ['title'=>'7. Limitation of Liability','content'=>'NyumbaHub provides the platform "as is" without warranties of any kind. We are not responsible for the accuracy of listings, the conduct of agents or users, or any losses arising from use of the platform. Our liability is limited to the maximum extent permitted by law.'],
        ['title'=>'8. Intellectual Property','content'=>'All content on NyumbaHub, including logos, design, text, and software, is owned by NyumbaHub and protected by intellectual property laws. You may not copy, modify, or distribute our content without written permission.'],
        ['title'=>'9. Termination','content'=>'We reserve the right to suspend or terminate your account at any time if you violate these terms or engage in conduct we deem harmful to the platform or other users.'],
        ['title'=>'10. Changes to Terms','content'=>'We may update these Terms of Service at any time. Continued use of NyumbaHub after changes constitutes acceptance of the new terms. We will notify users of significant changes via email or platform notification.'],
        ['title'=>'11. Governing Law','content'=>'These Terms of Service are governed by the laws of the United Republic of Tanzania. Any disputes arising from use of NyumbaHub shall be resolved in the courts of Arusha, Tanzania.'],
        ['title'=>'12. Contact','content'=>'For questions about these Terms, contact us at nyumbahub26@gmail.com.'],
    ] as $section)
    <div style="margin-bottom:24px;">
        <h2 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:8px;display:flex;align-items:center;gap:8px;">
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
