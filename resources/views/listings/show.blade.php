@extends('layouts.app')

@section('title', $listing->title . ' — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
@endpush

@section('content')

<div style="max-width:1000px;margin:0 auto;">

    <a href="{{ route('listings.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);text-decoration:none;font-size:14px;margin-bottom:24px;">
        <i class="fa-solid fa-arrow-left"></i> Back to listings
    </a>

    <div style="display:grid;grid-template-columns:1fr 380px;gap:32px;">

        {{-- LEFT --}}
        <div>
            {{-- Main image --}}
            <div style="border-radius:var(--radius);overflow:hidden;height:380px;background:var(--bg);margin-bottom:16px;">
                @if($listing->images->first())
                    <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                        style="width:100%;height:100%;object-fit:cover;cursor:pointer;"
                        onclick="openLightbox(this.src)"
                        alt="{{ $listing->title }}">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:64px;opacity:0.3;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($listing->images->count() > 1)
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:24px;">
                @foreach($listing->images->skip(1) as $image)
                    <div style="border-radius:8px;overflow:hidden;height:80px;cursor:pointer;" onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}')">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            style="width:100%;height:100%;object-fit:cover;">
                    </div>
                @endforeach
            </div>
            @endif

            {{-- Description --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:24px;">
                <h2 style="font-size:16px;font-weight:700;margin-bottom:12px;">Description</h2>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.7;">{{ $listing->description }}</p>
            </div>

            {{-- Details --}}
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:24px;">
                <h2 style="font-size:16px;font-weight:700;margin-bottom:16px;">Property Details</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-tag" style="color:var(--accent);width:20px;"></i>
                        <div>
                            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;">Type</div>
                            <div style="font-size:14px;font-weight:600;">{{ ucfirst($listing->type) }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-building" style="color:var(--accent);width:20px;"></i>
                        <div>
                            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;">Category</div>
                            <div style="font-size:14px;font-weight:600;">{{ ucfirst($listing->category) }}</div>
                        </div>
                    </div>
                    @if($listing->bedrooms)
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-bed" style="color:var(--accent);width:20px;"></i>
                        <div>
                            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;">Bedrooms</div>
                            <div style="font-size:14px;font-weight:600;">{{ $listing->bedrooms }}</div>
                        </div>
                    </div>
                    @endif
                    @if($listing->bathrooms)
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-shower" style="color:var(--accent);width:20px;"></i>
                        <div>
                            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;">Bathrooms</div>
                            <div style="font-size:14px;font-weight:600;">{{ $listing->bathrooms }}</div>
                        </div>
                    </div>
                    @endif
                    @if($listing->area)
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-ruler-combined" style="color:var(--accent);width:20px;"></i>
                        <div>
                            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;">Area</div>
                            <div style="font-size:14px;font-weight:600;">{{ $listing->area }} m²</div>
                        </div>
                    </div>
                    @endif
                    <div style="display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-location-dot" style="color:var(--accent);width:20px;"></i>
                        <div>
                            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;">Location</div>
                            <div style="font-size:14px;font-weight:600;">{{ $listing->location }}, Arusha</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div>
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:24px;position:sticky;top:80px;">

                <span style="display:inline-block;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;background:{{ $listing->type === 'rent' ? '#1B4332' : '#D4A853' }};color:{{ $listing->type === 'rent' ? '#fff' : '#1B4332' }};margin-bottom:12px;">
                    {{ $listing->type === 'rent' ? 'For Rent' : 'For Sale' }}
                </span>

                <h1 style="font-family:Georgia,serif;font-size:22px;font-weight:700;margin-bottom:8px;line-height:1.3;">{{ $listing->title }}</h1>

                <div style="display:flex;align-items:center;gap:6px;color:var(--text-muted);font-size:13px;margin-bottom:16px;">
                    <i class="fa-solid fa-location-dot" style="color:var(--accent);"></i>
                    {{ $listing->location }}, Arusha
                </div>

                <div style="font-size:28px;font-weight:700;color:var(--primary);margin-bottom:4px;">
                    TZS {{ number_format($listing->price) }}
                </div>
                <div style="font-size:13px;color:var(--text-muted);margin-bottom:20px;">
                    {{ $listing->type === 'rent' ? 'per month' : 'total price' }}
                </div>

               <div style="border-top:1px solid var(--border);padding-top:20px;margin-bottom:20px;">
    <div style="font-size:13px;color:var(--text-muted);margin-bottom:8px;">Listed by</div>
    <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:40px;height:40px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;font-weight:700;flex-shrink:0;">
            {{ strtoupper(substr($listing->agent->first_name, 0, 1)) }}
        </div>
        <div>
            <div style="font-weight:600;font-size:14px;">{{ $listing->agent->first_name }}</div>
            <div style="font-size:12px;color:var(--text-muted);">Verified Agent</div>
        </div>
    </div>
</div>

{{-- Book viewing --}}
@auth
    <a href="{{ route('appointments.create', $listing->id) }}" class="btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;display:flex;">
        <i class="fa-solid fa-calendar-plus"></i> Book Viewing
    </a>
@else
    <a href="{{ route('login') }}" class="btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;display:flex;">
        <i class="fa-solid fa-calendar-plus"></i> Login to Book Viewing
    </a>
@endauth

{{-- WhatsApp contact --}}
@if($listing->agent->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $listing->agent->whatsapp) }}?text={{ urlencode('Hi ' . $listing->agent->first_name . ', I am interested in your listing: ' . $listing->title . ' on NyumbaHub.') }}"
        target="_blank"
        style="width:100%;justify-content:center;display:flex;align-items:center;gap:8px;padding:10px 20px;background:#25D366;color:#fff;text-decoration:none;border-radius:var(--radius);font-size:14px;font-weight:700;transition:background 0.2s;margin-bottom:10px;">
        <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Contact via WhatsApp
    </a>
@else
    <div style="text-align:center;font-size:12px;color:var(--text-muted);padding:8px;">
        <i class="fa-solid fa-lock" style="margin-right:4px;"></i> Agent contact available after booking
    </div>
@endif
            </div>
        </div>

    </div>
</div>

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:1000;align-items:center;justify-content:center;cursor:pointer;">
    <img id="lightbox-img" src="" style="max-width:90%;max-height:90vh;border-radius:8px;object-fit:contain;">
    <button onclick="closeLightbox()" style="position:absolute;top:20px;right:20px;background:none;border:none;color:#fff;font-size:28px;cursor:pointer;">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

@endsection

@push('scripts')
<script>
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endpush
