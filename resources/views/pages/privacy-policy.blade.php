@extends('layouts.app')
@section('title', __('Privacy Policy — NyumbaHub'))
@section('content')

<div class="page-container">
    {-- Premium Hero --}
    <div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 60px 40px; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="position:absolute;top:-80px;right:-40px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle, rgba(212,168,83,0.2) 0%, transparent 70%); filter:blur(40px);"></div>
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto; text-align:center;">
            <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:6px 16px; border-radius:99px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; backdrop-filter:blur(10px);">
                <i class="fa-solid fa-shield"></i> {{ __('Privacy') }}
            </div>
            <h1 style="font-family:var(--font-display); font-size:48px; font-weight:800; color:#fff; line-height:1.2; margin-bottom:16px;">{{ __('Privacy Policy') }}</h1>
            <p style="font-size:16px; color:rgba(255,255,255,0.7); max-width:500px; margin:0 auto;">{{ __('Last updated:') }} {{ date('F d, Y') }}</p>
        </div>
    </div>

    {-- Content --}
    <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:48px; box-shadow:var(--shadow-sm); max-width:880px; margin:0 auto;">

        <div class="doc-section">
            <h2>{{ __('1. Information We Collect') }}</h2>
            <p>{{ __('We collect information you provide directly to us, such as when you create or modify your account, request services, contact customer support, or otherwise communicate with us. This information may include: name, email, phone number, postal address, and profile picture.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('2. How We Use Your Information') }}</h2>
            <p>{{ __('We may use the information we collect about you to:') }}</p>
            <ul>
                <li>{{ __('Provide, maintain, and improve our Services.') }}</li>
                <li>{{ __('Process and facilitate property inquiries and viewing appointments.') }}</li>
                <li>{{ __('Send you related information, including confirmations and administrative messages.') }}</li>
                <li>{{ __('Respond to your comments, questions, and requests.') }}</li>
            </ul>
        </div>
        <div class="doc-section">
            <h2>{{ __('3. Sharing of Information') }}</h2>
            <p>{{ __('We may share the information we collect about you as described in this Statement or as described at the time of collection or sharing, including as follows:') }}</p>
            <ul>
                <li>{{ __('With property agents when you request to view a property or contact them.') }}</li>
                <li>{{ __('In response to a request for information by a competent authority if we believe disclosure is in accordance with, or is otherwise required by, any applicable law.') }}</li>
            </ul>
        </div>
        <div class="doc-section">
            <h2>{{ __('4. Security') }}</h2>
            <p>{{ __('We take reasonable measures to help protect information about you from loss, theft, misuse and unauthorized access, disclosure, alteration and destruction.') }}</p>
        </div>
        <div style="background:rgba(212,168,83,0.1); border:1px solid rgba(212,168,83,0.2); border-radius:16px; padding:24px; text-align:center; margin-top:40px;">
            <i class="fa-solid fa-shield-halved" style="font-size:24px; color:var(--accent); margin-bottom:12px;"></i>
            <h3 style="font-size:18px; font-weight:700; color:var(--gray-900); margin-bottom:8px;">{{ __('Your Privacy is our Priority') }}</h3>
            <p style="font-size:14px; color:var(--gray-600); margin-bottom:16px;">{{ __('We never sell your personal data to third parties.') }}</p>
        </div>

    </div>
</div>

<style>
.doc-section { margin-bottom: 32px; }
.doc-section h2 { font-family:var(--font-display); font-size:22px; font-weight:700; color:var(--gray-900); margin-bottom:12px; display:flex; align-items:center; gap:12px; }
.doc-section h2::before { content:''; display:block; width:24px; height:3px; background:var(--accent); border-radius:2px; }
.doc-section p { font-size:15px; color:var(--gray-600); line-height:1.8; margin-bottom:16px; }
.doc-section ul { padding-left:24px; margin-bottom:16px; }
.doc-section li { font-size:15px; color:var(--gray-600); line-height:1.8; margin-bottom:8px; }
</style>
@endsection
