@extends('layouts.app')

@section('title', 'Book Viewing — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
@endpush

@section('content')

<div style="max-width:600px;margin:0 auto;">

    <a href="{{ route('listings.show', $listing->slug) }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);text-decoration:none;font-size:14px;margin-bottom:24px;">
        <i class="fa-solid fa-arrow-left"></i> Back to listing
    </a>

    <div class="form-section">
        <h1 class="dashboard-title" style="margin-bottom:4px;">Book a Viewing</h1>
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

        <form method="POST" action="{{ route('appointments.store', $listing->id) }}">
            @csrf

            <div class="field-row">
                <div class="field">
                    <label for="date">Preferred Date <span class="required">*</span></label>
                    <input type="date" id="date" name="date"
                        value="{{ old('date') }}"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        class="{{ $errors->has('date') ? 'is-invalid' : '' }}"
                        required>
                    @error('date') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="time">Preferred Time <span class="required">*</span></label>
                    <select id="time" name="time" class="{{ $errors->has('time') ? 'is-invalid' : '' }}" required>
                        <option value="">Select time</option>
                        @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $t)
                            <option value="{{ $t }}" {{ old('time') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('time') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="field">
                <label for="message">Message to Agent (optional)</label>
                <textarea id="message" name="message" rows="3"
                    placeholder="Any questions or special requests...">{{ old('message') }}</textarea>
                @error('message') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="submit-info">
                <i class="fa-solid fa-circle-info"></i>
                The agent will confirm your appointment. You'll see the status in your dashboard.
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:48px;font-size:15px;">
                <i class="fa-solid fa-calendar-plus"></i> Confirm Booking
            </button>
        </form>
    </div>
</div>

@endsection
