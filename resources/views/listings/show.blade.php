@extends('layouts.app')

@section('title', $listing->title . ' — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}?v={{ time() }}">
    <style>
        .show-grid { display:grid;grid-template-columns:1fr 380px;gap:32px;align-items:start; }
        .show-images { border-radius:16px;overflow:hidden;margin-bottom:16px; }
        .show-main-img { height:420px;overflow:hidden;border-radius:16px;cursor:pointer; }
        .show-main-img img { width:100%;height:100%;object-fit:cover;transition:transform 0.4s; }
        .show-main-img:hover img { transform:scale(1.03); }
        .show-thumbs { display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:8px; }
        .show-thumb { height:90px;border-radius:10px;overflow:hidden;cursor:pointer;border:2px solid transparent;transition:border-color 0.2s; }
        .show-thumb:hover { border-color:var(--primary,#1B4332); }
        .show-thumb img { width:100%;height:100%;object-fit:cover; }
        .show-section { background:var(--surface,#fff);border:1px solid var(--border-light,#EBEBEB);border-radius:16px;padding:24px;margin-bottom:16px; }
        .show-section-title { font-size:16px;font-weight:700;color:var(--text,#222);margin-bottom:16px;display:flex;align-items:center;gap:8px;padding-bottom:12px;border-bottom:1px solid var(--border-light,#EBEBEB); }
        .detail-grid { display:grid;grid-template-columns:1fr 1fr;gap:16px; }
        .detail-item { display:flex;align-items:center;gap:10px; }
        .detail-icon { width:36px;height:36px;border-radius:8px;background:rgba(27,67,50,0.08);display:flex;align-items:center;justify-content:center;color:var(--primary,#1B4332);font-size:14px;flex-shrink:0; }
        .detail-label { font-size:11px;color:var(--text-muted,#717171);text-transform:uppercase;letter-spacing:0.5px; }
        .detail-value { font-size:14px;font-weight:600;color:var(--text,#222);margin-top:1px; }
        .sticky-card { position:sticky;top:96px; }
        @media(max-width:900px){ .show-grid{grid-template-columns:1fr} .sticky-card{position:static} }
    </style>
@endpush

@section('content')

<div style="max-width:1100px;margin:0 auto;">

    {{-- Back --}}
    <a href="{{ route('listings.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted,#717171);text-decoration:none;font-size:14px;font-weight:500;margin-bottom:20px;padding:8px 0;">
        <i class="fa-solid fa-arrow-left"></i> Back to listings
    </a>

    {{-- Sold/Rented banner --}}
    @if(in_array($listing->status, ['sold','rented']))
    <div style="background:{{ $listing->status === 'sold' ? '#FEF9C3' : '#E0F2F1' }};border:1px solid {{ $listing->status === 'sold' ? '#FDE047' : '#80CBC4' }};border-radius:12px;padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:600;color:{{ $listing->status === 'sold' ? '#854D0E' : '#00695C' }};">
        <i class="fa-solid fa-circle-check"></i>
        This property has been {{ $listing->status === 'sold' ? 'sold' : 'rented' }} and is no longer available.
    </div>
    @endif

    <div class="show-grid">

        {{-- LEFT --}}
        <div>
            {{-- Images --}}
            <div class="show-main-img" onclick="openLightbox('{{ $listing->images->first() ? asset('storage/' . $listing->images->first()->image_path) : '' }}')">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}" alt="{{ $listing->title }}">
                @else
                    <div style="width:100%;height:100%;background:var(--bg-soft,#F7F7F7);display:flex;align-items:center;justify-content:center;font-size:64px;color:#ccc;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                @endif
            </div>

            @if($listing->images->count() > 1)
            <div class="show-thumbs">
                @foreach($listing->images as $image)
                <div class="show-thumb" onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}')">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="">
                </div>
                @endforeach
            </div>
            @endif

            {{-- Description --}}
            <div class="show-section" style="margin-top:16px;">
                <h2 class="show-section-title"><i class="fa-solid fa-align-left"></i> Description</h2>
                <p style="font-size:15px;color:var(--text-light,#484848);line-height:1.8;">{{ $listing->description }}</p>
            </div>

            {{-- Property Details --}}
            <div class="show-section">
                <h2 class="show-section-title"><i class="fa-solid fa-house-chimney"></i> Property Details</h2>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fa-solid fa-tag"></i></div>
                        <div>
                            <div class="detail-label">Listing Type</div>
                            <div class="detail-value">{{ ucfirst($listing->type) }}</div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fa-solid fa-building"></i></div>
                        <div>
                            <div class="detail-label">Category</div>
                            <div class="detail-value">{{ ucfirst($listing->category) }}</div>
                        </div>
                    </div>
                    @if($listing->bedrooms)
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fa-solid fa-bed"></i></div>
                        <div>
                            <div class="detail-label">Bedrooms</div>
                            <div class="detail-value">{{ $listing->bedrooms }}</div>
                        </div>
                    </div>
                    @endif
                    @if($listing->bathrooms)
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fa-solid fa-shower"></i></div>
                        <div>
                            <div class="detail-label">Bathrooms</div>
                            <div class="detail-value">{{ $listing->bathrooms }}</div>
                        </div>
                    </div>
                    @endif
                    @if($listing->area)
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fa-solid fa-ruler-combined"></i></div>
                        <div>
                            <div class="detail-label">Area</div>
                            <div class="detail-value">{{ $listing->area }} m²</div>
                        </div>
                    </div>
                    @endif
                    <div class="detail-item">
                        <div class="detail-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <div class="detail-label">Location</div>
                            <div class="detail-value">{{ $listing->location }}, Arusha</div>
                        </div>
                    </div>
                    @if($listing->address)
                    <div class="detail-item" style="grid-column:span 2;">
                        <div class="detail-icon"><i class="fa-solid fa-map-pin"></i></div>
                        <div>
                            <div class="detail-label">Address</div>
                            <div class="detail-value">{{ $listing->address }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Amenities --}}
            @if($listing->amenities && count($listing->amenities) > 0)
            @php
            $amenityMeta = [
                'wifi'          => ['icon' => 'fa-wifi',           'label' => 'WiFi'],
                'parking'       => ['icon' => 'fa-square-parking', 'label' => 'Parking'],
                'security'      => ['icon' => 'fa-shield-halved',  'label' => 'Security Guard'],
                'generator'     => ['icon' => 'fa-bolt',           'label' => 'Generator'],
                'water_tank'    => ['icon' => 'fa-droplet',        'label' => 'Water Tank'],
                'cctv'          => ['icon' => 'fa-video',          'label' => 'CCTV'],
                'garden'        => ['icon' => 'fa-leaf',           'label' => 'Garden'],
                'swimming_pool' => ['icon' => 'fa-water-ladder',   'label' => 'Swimming Pool'],
                'ac'            => ['icon' => 'fa-wind',           'label' => 'Air Conditioning'],
                'balcony'       => ['icon' => 'fa-building',       'label' => 'Balcony'],
                'lift'          => ['icon' => 'fa-elevator',       'label' => 'Lift/Elevator'],
                'furnished'     => ['icon' => 'fa-couch',          'label' => 'Furnished'],
            ];
            @endphp
            <div class="show-section">
                <h2 class="show-section-title"><i class="fa-solid fa-star"></i> Amenities</h2>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    @foreach($listing->amenities as $amenity)
                    @if(isset($amenityMeta[$amenity]))
                    <span style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border:1.5px solid var(--primary,#1B4332);border-radius:9999px;font-size:13px;font-weight:500;color:var(--primary,#1B4332);background:rgba(27,67,50,0.05);">
                        <i class="fa-solid {{ $amenityMeta[$amenity]['icon'] }}"></i>
                        {{ $amenityMeta[$amenity]['label'] }}
                    </span>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT — Sticky card --}}
        <div class="sticky-card">
            <div class="show-section">

                {{-- Badge + Title --}}
                <span style="display:inline-block;padding:5px 14px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;background:{{ $listing->type === 'rent' ? '#1B4332' : '#D4A853' }};color:{{ $listing->type === 'rent' ? '#fff' : '#0F2D1F' }};margin-bottom:12px;">
                    {{ $listing->type === 'rent' ? 'For Rent' : 'For Sale' }}
                </span>

                <h1 style="font-family:'Playfair Display',Georgia,serif;font-size:22px;font-weight:700;color:var(--text,#222);margin-bottom:8px;line-height:1.3;">
                    {{ $listing->title }}
                </h1>

                <div style="display:flex;align-items:center;gap:5px;color:var(--text-muted,#717171);font-size:13px;margin-bottom:20px;">
                    <i class="fa-solid fa-location-dot" style="color:var(--accent,#D4A853);"></i>
                    {{ $listing->location }}, Arusha, Tanzania
                </div>

                {{-- Price --}}
                <div style="padding:16px;background:var(--bg-soft,#F7F7F7);border-radius:12px;margin-bottom:20px;text-align:center;">
                    <div style="font-size:32px;font-weight:800;color:var(--primary,#1B4332);font-family:'Playfair Display',serif;">
                        TZS {{ number_format($listing->price) }}
                    </div>
                    <div style="font-size:13px;color:var(--text-muted,#717171);margin-top:2px;">
                        {{ $listing->type === 'rent' ? 'per month' : 'total purchase price' }}
                    </div>
                </div>

                {{-- Agent --}}
                <div style="display:flex;align-items:center;gap:12px;padding:14px;background:var(--bg-soft,#F7F7F7);border-radius:12px;margin-bottom:20px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--primary,#1B4332);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($listing->agent->first_name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:14px;color:var(--text,#222);">{{ $listing->agent->first_name ?? 'Agent' }}</div>
                        <div style="font-size:12px;color:var(--text-muted,#717171);">
                            <i class="fa-solid fa-circle-check" style="color:#008A05;"></i> Verified Agent
                        </div>
                    </div>
                </div>

                @if($listing->status === 'active')
                    {{-- Check if logged-in user has active booking --}}
                    @auth
                    @php
                        $myAppointment = auth()->check()
                            ? $listing->appointments()
                                ->where('user_id', auth()->id())
                                ->whereIn('status', ['pending', 'confirmed'])
                                ->latest()
                                ->first()
                            : null;
                    @endphp

                    @if($myAppointment)
                        {{-- Post-booking: show contact details --}}
                        <div style="background:linear-gradient(135deg,rgba(27,67,50,0.06),rgba(27,67,50,0.02));border:1.5px solid rgba(27,67,50,0.2);border-radius:14px;padding:18px;margin-bottom:14px;">
                            <div style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;color:var(--primary,#1B4332);margin-bottom:14px;">
                                <i class="fa-solid fa-circle-check"></i>
                                Your viewing is {{ $myAppointment->status }} — Contact Agent
                            </div>
                            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:14px;">
                                {{-- Agent name --}}
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:38px;height:38px;border-radius:50%;background:var(--primary,#1B4332);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                                        {{ strtoupper(substr($listing->agent->first_name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;font-size:14px;color:#222;">{{ $listing->agent->first_name }} {{ $listing->agent->last_name }}</div>
                                        <div style="font-size:12px;color:#717171;"><i class="fa-solid fa-circle-check" style="color:#008A05;"></i> Verified Agent</div>
                                    </div>
                                </div>
                                {{-- Phone --}}
                                @if($listing->agent->phone)
                                <a href="tel:{{ $listing->agent->phone }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:white;border:1px solid #E5E7EB;border-radius:10px;text-decoration:none;color:#222;font-size:13px;font-weight:600;transition:border-color 0.15s;" onmouseover="this.style.borderColor='#1B4332'" onmouseout="this.style.borderColor='#E5E7EB'">
                                    <i class="fa-solid fa-phone" style="color:var(--primary,#1B4332);width:16px;"></i>
                                    {{ $listing->agent->phone }}
                                </a>
                                @endif
                                {{-- Email --}}
                                <a href="mailto:{{ $listing->agent->email }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:white;border:1px solid #E5E7EB;border-radius:10px;text-decoration:none;color:#222;font-size:13px;font-weight:600;transition:border-color 0.15s;" onmouseover="this.style.borderColor='#1B4332'" onmouseout="this.style.borderColor='#E5E7EB'">
                                    <i class="fa-solid fa-envelope" style="color:var(--primary,#1B4332);width:16px;"></i>
                                    {{ $listing->agent->email }}
                                </a>
                                {{-- WhatsApp --}}
                                @if($listing->agent->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $listing->agent->whatsapp) }}?text={{ urlencode('Hi ' . $listing->agent->first_name . ', I have a confirmed booking for: ' . $listing->title . '. — NyumbaHub') }}"
                                   target="_blank"
                                   style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#25D366;border-radius:10px;text-decoration:none;color:white;font-size:13px;font-weight:700;">
                                    <i class="fa-brands fa-whatsapp" style="font-size:16px;"></i>
                                    Chat on WhatsApp
                                </a>
                                @endif
                            </div>

                            {{-- Send message form --}}
                            @if(session('success') && str_contains(session('success'), 'Message sent'))
                            <div style="background:#ECFDF5;border:1px solid #6EE7B7;border-radius:8px;padding:10px 14px;font-size:13px;font-weight:600;color:#065F46;display:flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                            </div>
                            @else
                            <form method="POST" action="{{ route('contact.agent') }}" id="msgForm">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $myAppointment->id }}">
                                <textarea name="message" rows="3" placeholder="Send a message to the agent..." style="width:100%;border:1.5px solid #E5E7EB;border-radius:10px;padding:10px 12px;font-size:13px;font-family:inherit;resize:none;outline:none;box-sizing:border-box;transition:border-color 0.15s;" onfocus="this.style.borderColor='#1B4332'" onblur="this.style.borderColor='#E5E7EB'" required minlength="10" maxlength="1000"></textarea>
                                @error('message')<div style="color:#DC2626;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                                <button type="submit" style="margin-top:10px;width:100%;padding:11px;background:var(--primary,#1B4332);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;transition:opacity 0.15s;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                                    <i class="fa-solid fa-paper-plane"></i> Send Message
                                </button>
                            </form>
                            @endif
                        </div>
                    @else
                        {{-- Not yet booked --}}
                        <a href="{{ route('appointments.create', $listing->id) }}" class="btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;display:flex;height:48px;font-size:15px;">
                            <i class="fa-solid fa-calendar-plus"></i> Book a Viewing
                        </a>
                    @endif
                    @else
                        {{-- Guest --}}
                        <a href="{{ route('login') }}" class="btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;display:flex;height:48px;font-size:15px;">
                            <i class="fa-solid fa-calendar-plus"></i> Login to Book Viewing
                        </a>
                    @endauth

                    {{-- WhatsApp (for non-booked users) --}}
                    @guest
                    @if($listing->agent->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $listing->agent->whatsapp) }}?text={{ urlencode('Hi ' . $listing->agent->first_name . ', I am interested in your listing: ' . $listing->title . ' on NyumbaHub.') }}"
                            target="_blank"
                            style="width:100%;justify-content:center;display:flex;align-items:center;gap:8px;padding:12px 20px;background:#25D366;color:#fff;text-decoration:none;border-radius:9999px;font-size:14px;font-weight:700;transition:background 0.2s;margin-bottom:10px;">
                            <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Contact via WhatsApp
                        </a>
                    @endif
                    @endguest
                @else
                    <div style="text-align:center;padding:16px;background:#F7F7F7;border-radius:12px;color:#717171;font-size:14px;font-weight:500;">
                        <i class="fa-solid fa-circle-xmark" style="font-size:20px;display:block;margin-bottom:6px;opacity:0.4;"></i>
                        This property is no longer available
                    </div>
                @endif

                {{-- Share --}}
                <div style="display:flex;gap:8px;margin-top:12px;justify-content:center;">
                    <button onclick="navigator.share ? navigator.share({title:'{{ $listing->title }}',url:window.location.href}) : alert('Copy: '+window.location.href)"
                        style="flex:1;padding:10px;border:1px solid var(--border,#DDD);border-radius:9999px;background:none;cursor:pointer;font-size:13px;font-weight:600;color:var(--text,#222);font-family:inherit;display:flex;align-items:center;justify-content:center;gap:6px;">
                        <i class="fa-solid fa-share-nodes"></i> Share
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.92);z-index:2000;align-items:center;justify-content:center;">
    <img id="lightbox-img" src="" style="max-width:90vw;max-height:90vh;border-radius:12px;object-fit:contain;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
    <button onclick="closeLightbox()" style="position:absolute;top:20px;right:20px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:50%;color:#fff;font-size:20px;cursor:pointer;width:44px;height:44px;display:flex;align-items:center;justify-content:center;">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

@endsection

@push('scripts')
<script>
function openLightbox(src) {
    if (!src) return;
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endpush
