@extends('layouts.app')
@section('title', __('Terms of Service — NyumbaHub'))
@section('content')

<div class="page-container">
    {-- Premium Hero --}
    <div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 60px 40px; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="position:absolute;top:-80px;right:-40px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle, rgba(212,168,83,0.2) 0%, transparent 70%); filter:blur(40px);"></div>
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto; text-align:center;">
            <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:6px 16px; border-radius:99px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; backdrop-filter:blur(10px);">
                <i class="fa-solid fa-scale-balanced"></i> {{ __('Legal') }}
            </div>
            <h1 style="font-family:var(--font-display); font-size:48px; font-weight:800; color:#fff; line-height:1.2; margin-bottom:16px;">{{ __('Terms of Service') }}</h1>
            <p style="font-size:16px; color:rgba(255,255,255,0.7); max-width:500px; margin:0 auto;">{{ __('Last updated:') }} {{ date('F d, Y') }}</p>
        </div>
    </div>

    {-- Content --}
    <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:48px; box-shadow:var(--shadow-sm); max-width:880px; margin:0 auto;">

        <div class="doc-section">
            <h2>{{ __('1. Acceptance of Terms') }}</h2>
            <p>{{ __('By accessing or using NyumbaHub ("the Platform"), you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using the platform.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('2. User Accounts') }}</h2>
            <p>{{ __('You must register an account to access certain features. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('3. Agent Responsibilities') }}</h2>
            <p>{{ __('Property agents are responsible for ensuring all listing information is accurate, up-to-date, and not misleading. Agents must not post properties they are not authorized to list.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('4. Prohibited Activities') }}</h2>
            <p>{{ __('Users may not: post false or misleading property information, use the platform for illegal purposes, attempt to circumvent our security measures, or harass other users.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('5. Listing Approval') }}</h2>
            <p>{{ __('All property listings submitted by agents are reviewed by our admin team before being published. We reserve the right to reject or remove any listing that violates our guidelines.') }}</p>
        </div>
        <div class="doc-section">
            <h2>{{ __('6. Appointments & Viewings') }}</h2>
            <p>{{ __('NyumbaHub facilitates booking of property viewing appointments but is not a party to any rental or sale agreement. Any transaction between users and agents occurs outside of our platform.') }}</p>
        </div>
        
        <div style="background:rgba(212,168,83,0.1); border:1px solid rgba(212,168,83,0.2); border-radius:16px; padding:24px; text-align:center; margin-top:40px;">
            <i class="fa-solid fa-envelope" style="font-size:24px; color:var(--accent); margin-bottom:12px;"></i>
            <h3 style="font-size:18px; font-weight:700; color:var(--gray-900); margin-bottom:8px;">{{ __('Questions about these terms?') }}</h3>
            <p style="font-size:14px; color:var(--gray-600); margin-bottom:16px;">{{ __('Contact our legal team for clarification on any of the points above.') }}</p>
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
