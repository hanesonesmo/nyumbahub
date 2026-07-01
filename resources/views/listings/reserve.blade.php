@extends('layouts.app')

@section('title', 'Reserve Property — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
@endpush

@section('content')

<div style="max-width:600px;margin:0 auto;">

    <a href="{{ route('listings.show', $listing->slug) }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);text-decoration:none;font-size:14px;margin-bottom:24px;">
        <i class="fa-solid fa-arrow-left"></i> {{ __('Back to listing') }}
    </a>

    <div class="form-section">
        <h1 class="dashboard-title" style="margin-bottom:4px;">{{ __('Reserve Property') }}</h1>
        <p style="font-size:14px;color:var(--text-muted);margin-bottom:24px;">{{ $listing->title }}</p>

        {{-- Listing summary --}}
        <div style="display:flex;gap:16px;align-items:center;background:var(--bg);border-radius:var(--radius);padding:16px;margin-bottom:24px;">
            @if($listing->images->first())
                <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                    style="width:80px;height:60px;object-fit:cover;border-radius:8px;">
            @endif
            <div>
                <div style="font-weight:700;font-size:15px;">{{ $listing->title }}</div>
                <div style="font-size:13px;color:var(--text-muted);"><i class="fa-solid fa-location-dot" style="color:var(--accent);"></i> {{ $listing->location }}, Arusha</div>
                <div style="font-size:15px;font-weight:700;color:var(--primary);">TZS {{ number_format($listing->price) }}</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <ul style="margin:0;padding-left:16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('listings.process_reserve', $listing->id) }}">
            @csrf

            @php
                $feeAmount = $listing->price * 0.05; // 5% of the listing price
                $currency = \App\Models\Setting::get('currency', 'KES');
                $hours = \App\Models\Setting::get('reservation_hours_validity', 48);
            @endphp

            <div style="background:rgba(212,168,83,0.1); border:1px solid rgba(212,168,83,0.3); border-radius:12px; padding:20px; margin-bottom:24px;">
                <h3 style="font-size:16px; font-weight:700; margin-bottom:8px;"><i class="fa-solid fa-lock" style="color:var(--accent);"></i> {{ __('Reservation Fee Required') }}</h3>
                <p style="font-size:14px; color:var(--gray-700); margin-bottom:16px;">{{ __('A non-refundable reservation fee of') }} <strong>{{ number_format($feeAmount) }} {{ $currency }}</strong> (5% {{ __('of the property price') }}) {{ __('is required to reserve this property for') }} <strong>{{ $hours }} {{ __('hours') }}</strong>. {{ __('Once reserved, no one else can book or reserve this property during this period. You will receive an M-Pesa prompt on your phone.') }}</p>
                
                <div class="field">
                    <label for="phone_number">{{ __('M-Pesa Phone Number') }} <span class="required">*</span></label>
                    <input type="text" id="phone_number" name="phone_number" 
                        placeholder="2547XXXXXXXX or 07XXXXXXXX"
                        value="{{ old('phone_number', auth()->user()->phone) }}"
                        required>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                <i class="fa-solid fa-lock"></i> {{ __('Pay via M-Pesa & Reserve') }}
            </button>
        </form>
    </div>
</div>

@endsection
