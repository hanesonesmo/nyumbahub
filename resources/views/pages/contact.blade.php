@extends('layouts.app')
@section('title', 'Contact Us — NyumbaHub')
@section('content')

<div style="max-width:900px;margin:0 auto;">

    {{-- Header --}}
    <div style="text-align:center;margin-bottom:48px;">
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(27,67,50,0.08);color:var(--primary);padding:6px 14px;border-radius:9999px;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:16px;">
            <i class="fa-solid fa-envelope"></i> Get In Touch
        </div>
        <h1 style="font-family:var(--font-display);font-size:40px;font-weight:700;color:var(--gray-900);margin-bottom:12px;">Contact Us</h1>
        <p style="font-size:16px;color:var(--gray-500);max-width:480px;margin:0 auto;line-height:1.7;">
            Have a question, feedback, or need help? We're here for you. Our team responds within 24 hours.
        </p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1.4fr;gap:32px;align-items:start;">

        {{-- Contact info --}}
        <div>
            <div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:20px;padding:32px;color:white;margin-bottom:20px;">
                <h2 style="font-family:var(--font-display);font-size:22px;font-weight:700;margin-bottom:20px;">Contact Information</h2>

                @foreach([
                    ['icon'=>'fa-location-dot','title'=>'Address','value'=>'Arusha, Tanzania\nNear Njiro Hub, Arusha City'],
                    ['icon'=>'fa-phone','title'=>'Phone','value'=>'+255 752 000 000'],
                    ['icon'=>'fa-envelope','title'=>'Email','value'=>'nyumbahub26@gmail.com'],
                    ['icon'=>'fa-clock','title'=>'Working Hours','value'=>'Mon – Fri: 8:00 AM – 6:00 PM\nSat: 9:00 AM – 2:00 PM'],
                ] as $info)
                <div style="display:flex;gap:14px;margin-bottom:20px;align-items:flex-start;">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;color:#D4A853;">
                        <i class="fa-solid {{ $info['icon'] }}"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">{{ $info['title'] }}</div>
                        <div style="font-size:14px;color:rgba(255,255,255,0.85);line-height:1.6;">{!! nl2br(e($info['value'])) !!}</div>
                    </div>
                </div>
                @endforeach

                {{-- Social --}}
                <div style="margin-top:24px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.1);">
                    <div style="font-size:12px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Follow Us</div>
                    <div style="display:flex;gap:10px;">
                        <a href="#" style="width:36px;height:36px;border-radius:50%;background:#1877F2;display:flex;align-items:center;justify-content:center;color:white;font-size:14px;text-decoration:none;">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" style="width:36px;height:36px;border-radius:50%;background:linear-gradient(45deg,#F58529,#DD2A7B,#8134AF);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;text-decoration:none;">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" style="width:36px;height:36px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;color:white;font-size:14px;text-decoration:none;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="#" style="width:36px;height:36px;border-radius:50%;background:#000;display:flex;align-items:center;justify-content:center;color:white;font-size:14px;text-decoration:none;">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact form --}}
        <div style="background:white;border:1px solid var(--gray-200);border-radius:20px;padding:36px;box-shadow:var(--shadow-sm);">
            <h2 style="font-family:var(--font-display);font-size:22px;font-weight:700;color:var(--gray-900);margin-bottom:24px;">Send us a Message</h2>

            @if(session('contact_success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    Message sent successfully! We'll get back to you within 24 hours.
                </div>
            @endif

            <form method="POST" action="{{ route('contact.send') }}">
                @csrf
                <div class="field-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                    <div class="field" style="margin-bottom:0;">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="Amina" required>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Last Name</label>
                        <input type="text" name="last_name" placeholder="Mwangi" required>
                    </div>
                </div>

                <div class="field">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="field">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="+255 7XX XXX XXX">
                </div>

                <div class="field">
                    <label>Subject</label>
                    <select name="subject">
                        <option value="">Select a subject</option>
                        <option>General Inquiry</option>
                        <option>Listing Issue</option>
                        <option>Account Problem</option>
                        <option>Agent Support</option>
                        <option>Report a Problem</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="field">
                    <label>Message</label>
                    <textarea name="message" rows="5" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:46px;font-size:15px;">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
