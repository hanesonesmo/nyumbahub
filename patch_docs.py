import os

LAYOUT = """@extends('layouts.app')
@section('title', __('{title} — NyumbaHub'))
@section('content')

<div class="page-container">
    {{-- Premium Hero --}}
    <div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 60px 40px; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="position:absolute;top:-80px;right:-40px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle, rgba(212,168,83,0.2) 0%, transparent 70%); filter:blur(40px);"></div>
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto; text-align:center;">
            <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:6px 16px; border-radius:99px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; backdrop-filter:blur(10px);">
                <i class="fa-solid {icon}"></i> {badge}
            </div>
            <h1 style="font-family:var(--font-display); font-size:48px; font-weight:800; color:#fff; line-height:1.2; margin-bottom:16px;">{title_i18n}</h1>
            <p style="font-size:16px; color:rgba(255,255,255,0.7); max-width:500px; margin:0 auto;">{subtitle}</p>
        </div>
    </div>

    {{-- Content --}}
    <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:48px; box-shadow:var(--shadow-sm); max-width:880px; margin:0 auto;">
{content}
    </div>
</div>

<style>
.doc-section {{ margin-bottom: 32px; }}
.doc-section h2 {{ font-family:var(--font-display); font-size:22px; font-weight:700; color:var(--gray-900); margin-bottom:12px; display:flex; align-items:center; gap:12px; }}
.doc-section h2::before {{ content:''; display:block; width:24px; height:3px; background:var(--accent); border-radius:2px; }}
.doc-section p {{ font-size:15px; color:var(--gray-600); line-height:1.8; margin-bottom:16px; }}
.doc-section ul {{ padding-left:24px; margin-bottom:16px; }}
.doc-section li {{ font-size:15px; color:var(--gray-600); line-height:1.8; margin-bottom:8px; }}
</style>
@endsection
"""

TERMS = """
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
"""

PRIVACY = """
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
"""

HELP = """
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
"""

with open('resources/views/pages/terms.blade.php', 'w') as f:
    f.write(LAYOUT.format(title="Terms of Service", title_i18n="{{ __('Terms of Service') }}", badge="{{ __('Legal') }}", icon="fa-scale-balanced", subtitle="{{ __('Last updated:') }} {{ date('F d, Y') }}", content=TERMS))

with open('resources/views/pages/privacy-policy.blade.php', 'w') as f:
    f.write(LAYOUT.format(title="Privacy Policy", title_i18n="{{ __('Privacy Policy') }}", badge="{{ __('Privacy') }}", icon="fa-shield", subtitle="{{ __('Last updated:') }} {{ date('F d, Y') }}", content=PRIVACY))

with open('resources/views/pages/help-center.blade.php', 'w') as f:
    f.write(LAYOUT.format(title="Help Center", title_i18n="{{ __('Help Center') }}", badge="{{ __('Support') }}", icon="fa-life-ring", subtitle="{{ __('Frequently asked questions and support guides') }}", content=HELP))

print("Created docs pages.")
