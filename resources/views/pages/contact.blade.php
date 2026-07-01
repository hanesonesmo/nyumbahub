@extends('layouts.app')
@section('title', __('Contact Us — NyumbaHub'))
@section('content')

{{-- Hero Section --}}
<div style="background: linear-gradient(135deg, var(--primary-dark) 0%, #1a3c2a 100%); border-radius: 24px; padding: 60px 40px; margin-bottom: 40px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
    <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(212,168,83,0.15) 0%, transparent 60%); filter: blur(30px);"></div>
    <div style="position:absolute; bottom:-100px; left:-100px; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%); filter: blur(30px);"></div>
    
    <div style="position:relative; z-index:1; max-width:700px; margin:0 auto;">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(212,168,83,0.15); border:1px solid rgba(212,168,83,0.25); color:var(--accent); padding:8px 20px; border-radius:99px; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px; backdrop-filter:blur(10px);">
            <i class="fa-solid fa-headset"></i> {{ __('We\'re Here to Help') }}
        </div>
        <h1 style="font-family:var(--font-display); font-size:48px; font-weight:800; color:#fff; line-height:1.1; margin-bottom:24px; letter-spacing:-1px;">
            {{ __('Get in') }} <span style="color:var(--accent);">{{ __('Touch') }}</span>
        </h1>
        <p style="font-size:16px; color:rgba(255,255,255,0.7); margin-bottom:0; line-height:1.7;">
            {{ __('Have a question about a property, need help with your account, or want to report an issue? Send us a message and we\'ll get back to you within 24 hours.') }}
        </p>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1.5fr; gap:40px; margin-bottom:80px; max-width:1100px; margin-left:auto; margin-right:auto;">
    
    {{-- Left: Contact Info --}}
    <div>
        <h2 style="font-family:var(--font-display); font-size:28px; font-weight:800; color:var(--gray-900); margin-bottom:24px; letter-spacing:-0.5px;">{{ __('Contact Information') }}</h2>
        
        <div style="display:flex; flex-direction:column; gap:24px; margin-bottom:40px;">
            <div style="display:flex; align-items:flex-start; gap:16px;">
                <div style="width:48px; height:48px; border-radius:12px; background:rgba(212,168,83,0.1); color:var(--accent); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <h3 style="font-size:16px; font-weight:700; color:var(--gray-900); margin-bottom:4px;">{{ __('Our Office') }}</h3>
                    <p style="font-size:14px; color:var(--gray-600); line-height:1.6;">Simeon Road, Clock Tower Area<br>Arusha, Tanzania</p>
                </div>
            </div>
            
            <div style="display:flex; align-items:flex-start; gap:16px;">
                <div style="width:48px; height:48px; border-radius:12px; background:rgba(212,168,83,0.1); color:var(--accent); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <h3 style="font-size:16px; font-weight:700; color:var(--gray-900); margin-bottom:4px;">{{ __('Email Us') }}</h3>
                    <p style="font-size:14px; color:var(--gray-600); line-height:1.6;">
                        <a href="mailto:nyumbahub26@gmail.com" style="color:var(--primary); font-weight:600;">nyumbahub26@gmail.com</a><br>
                        {{ __('We typically reply within 24 hours.') }}
                    </p>
                </div>
            </div>
            
            <div style="display:flex; align-items:flex-start; gap:16px;">
                <div style="width:48px; height:48px; border-radius:12px; background:rgba(212,168,83,0.1); color:var(--accent); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h3 style="font-size:16px; font-weight:700; color:var(--gray-900); margin-bottom:4px;">{{ __('WhatsApp Support') }}</h3>
                    <p style="font-size:14px; color:var(--gray-600); line-height:1.6;">
                        {{ __('Available Mon-Fri, 9am to 6pm EAT.') }}
                    </p>
                </div>
            </div>
        </div>
        
        <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:var(--shadow-sm);">
            <h3 style="font-size:16px; font-weight:700; color:var(--gray-900); margin-bottom:12px;">{{ __('Follow Us') }}</h3>
            <div style="display:flex; gap:12px;">
                <a href="#" style="width:40px; height:40px; border-radius:50%; background:var(--gray-100); color:var(--gray-700); display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--gray-700)';"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" style="width:40px; height:40px; border-radius:50%; background:var(--gray-100); color:var(--gray-700); display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--gray-700)';"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" style="width:40px; height:40px; border-radius:50%; background:var(--gray-100); color:var(--gray-700); display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--gray-700)';"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </div>
    
    {{-- Right: Contact Form --}}
    <div style="background:var(--bg-color); border:1px solid var(--border); border-radius:24px; padding:40px; box-shadow:0 10px 30px rgba(0,0,0,0.05);">
        @if(session('success'))
            <div style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2); color:#059669; padding:16px; border-radius:12px; margin-bottom:24px; display:flex; align-items:center; gap:12px; font-size:14px;">
                <i class="fa-solid fa-circle-check" style="font-size:20px;"></i>
                <div>
                    <strong>{{ __('Message Sent!') }}</strong><br>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label class="form-label">{{ __('Full Name') }}</label>
                    <input type="text" name="name" class="form-control" required placeholder="John Doe">
                </div>
                <div>
                    <label class="form-label">{{ __('Email Address') }}</label>
                    <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                </div>
            </div>
            
            <div style="margin-bottom:20px;">
                <label class="form-label">{{ __('Subject') }}</label>
                <select name="subject" class="form-control" required>
                    <option value="">{{ __('Select a topic') }}</option>
                    <option value="General Inquiry">{{ __('General Inquiry') }}</option>
                    <option value="Agent Support">{{ __('Agent Support') }}</option>
                    <option value="Report a Problem">{{ __('Report a Problem') }}</option>
                    <option value="Feedback">{{ __('Feedback') }}</option>
                </select>
            </div>
            
            <div style="margin-bottom:24px;">
                <label class="form-label">{{ __('Message') }}</label>
                <textarea name="message" class="form-control" rows="5" required placeholder="{{ __('Write your message here...') }}"></textarea>
            </div>
            
            <button type="submit" class="btn-primary" style="width:100%; padding:14px; font-size:16px; border-radius:12px;">
                <i class="fa-solid fa-paper-plane" style="margin-right:8px;"></i> {{ __('Send Message') }}
            </button>
        </form>
    </div>
</div>

@endsection
