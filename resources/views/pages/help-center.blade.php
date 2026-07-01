@extends('layouts.app')
@section('title', __('Help Center — NyumbaHub'))
@section('content')

<div class="page-container">
    {-- Premium Hero --}
    <div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 60px 40px; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="position:absolute;top:-80px;right:-40px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle, rgba(212,168,83,0.2) 0%, transparent 70%); filter:blur(40px);"></div>
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto; text-align:center;">
            <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:6px 16px; border-radius:99px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; backdrop-filter:blur(10px);">
                <i class="fa-solid fa-life-ring"></i> {{ __('Support') }}
            </div>
            <h1 style="font-family:var(--font-display); font-size:48px; font-weight:800; color:#fff; line-height:1.2; margin-bottom:16px;">{{ __('Help Center') }}</h1>
            <p style="font-size:16px; color:rgba(255,255,255,0.7); max-width:500px; margin:0 auto;">{{ __('Frequently asked questions and support guides') }}</p>
        </div>
    </div>

    {-- Content --}
    <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:48px; box-shadow:var(--shadow-sm); max-width:880px; margin:0 auto;">

        <div class="doc-section">
            <h2>{{ __('How do I contact an agent?') }}</h2>
            <p>{{ __('You can contact an agent directly from any property listing page by clicking the "Contact Agent" or "WhatsApp" buttons. You can also schedule a viewing appointment through our platform.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('How do I become a verified agent?') }}</h2>
            <p>{{ __('To become an agent, click the "Become an Agent" link in the footer, fill out the registration form, and submit your application. Our admin team will review your details within 24 hours.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('Is it free to list properties?') }}</h2>
            <p>{{ __('Yes! Registered agents can list an unlimited number of properties for free on NyumbaHub.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('How are listings verified?') }}</h2>
            <p>{{ __('Our admin team reviews every listing submitted by agents to ensure it meets our quality standards and contains accurate information before it is published.') }}</p>
        </div>
        
        <div style="background:rgba(212,168,83,0.1); border:1px solid rgba(212,168,83,0.2); border-radius:16px; padding:24px; text-align:center; margin-top:40px;">
            <i class="fa-solid fa-life-ring" style="font-size:24px; color:var(--accent); margin-bottom:12px;"></i>
            <h3 style="font-size:18px; font-weight:700; color:var(--gray-900); margin-bottom:8px;">{{ __('Need more help?') }}</h3>
            <p style="font-size:14px; color:var(--gray-600); margin-bottom:16px;">{{ __('Our support team is available Monday to Friday.') }}</p>
            <a href="{{ route('contact') }}" class="btn-primary" style="padding:10px 24px; font-size:14px; display:inline-flex; border-radius:99px;">{{ __('Contact Support') }}</a>
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
