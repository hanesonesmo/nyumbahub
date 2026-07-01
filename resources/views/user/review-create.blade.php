@extends('layouts.dashboard')

@section('title', __('Leave a Review'))
@section('page-title', __('Leave a Review'))
@section('page-subtitle', __('Rate your experience with ') . $appointment->listing->agent->first_name)

@section('content')
<div style="max-width:600px; margin: 0 auto; background:white; border:1px solid var(--gray-200); border-radius:16px; padding:32px; box-shadow:var(--shadow-xs);">
    
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid var(--gray-100);">
        @if($appointment->listing->images->first())
            <img src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}"
                style="width:80px; height:60px; object-fit:cover; border-radius:8px;" alt="">
        @else
            <div style="width:80px; height:60px; background:var(--gray-100); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--gray-400);">
                <i class="fa-solid fa-building"></i>
            </div>
        @endif
        <div>
            <h3 style="font-size:16px; font-weight:700; color:var(--gray-900); margin:0 0 4px 0;">{{ $appointment->listing->title }}</h3>
            <div style="font-size:14px; color:var(--gray-500);">
                {{ __('Viewing on') }} {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
            </div>
        </div>
    </div>

    @if(session('error'))
        <div style="background:#FEF2F2; border:1px solid #F87171; border-radius:8px; padding:16px; color:#B91C1C; margin-bottom:24px; font-size:14px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.store', $appointment->id) }}">
        @csrf

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:14px; font-weight:600; color:var(--gray-900); margin-bottom:12px;">{{ __('Rating') }}</label>
            <div style="display:flex; gap:8px;" id="rating-stars">
                @for($i=1; $i<=5; $i++)
                    <label style="cursor:pointer; display:flex; align-items:center;">
                        <input type="radio" name="rating" value="{{ $i }}" style="display:none;" required>
                        <i class="fa-solid fa-star star-icon" data-value="{{ $i }}" style="font-size:32px; color:var(--gray-300); transition:color 0.2s;"></i>
                    </label>
                @endfor
            </div>
            @error('rating')
                <div style="color:var(--error); font-size:13px; margin-top:8px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label for="comment" style="display:block; font-size:14px; font-weight:600; color:var(--gray-900); margin-bottom:8px;">{{ __('Your Review') }}</label>
            <textarea id="comment" name="comment" rows="5" required minlength="10" maxlength="1000"
                placeholder="{{ __('Tell us about your experience with the agent and the property...') }}"
                style="width:100%; border:1px solid var(--gray-300); border-radius:10px; padding:12px 16px; font-size:14px; font-family:inherit; resize:vertical; outline:none; transition:border-color 0.2s;"
                onfocus="this.style.borderColor='var(--primary)'"
                onblur="this.style.borderColor='var(--gray-300)'">{{ old('comment') }}</textarea>
            @error('comment')
                <div style="color:var(--error); font-size:13px; margin-top:8px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end;">
            <a href="{{ route('appointments.index') }}" 
                style="padding:12px 24px; background:var(--gray-100); color:var(--gray-700); border-radius:10px; font-size:14px; font-weight:600; text-decoration:none;">
                {{ __('Cancel') }}
            </a>
            <button type="submit" 
                style="padding:12px 24px; background:var(--primary); color:white; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer;">
                {{ __('Submit Review') }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-icon');
    const radios = document.querySelectorAll('input[name="rating"]');

    function updateStars(value) {
        stars.forEach(star => {
            if (parseInt(star.dataset.value) <= value) {
                star.style.color = '#F59E0B'; // Gold
            } else {
                star.style.color = 'var(--gray-300)';
            }
        });
    }

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            updateStars(parseInt(this.dataset.value));
        });
        
        star.addEventListener('mouseout', function() {
            const checkedRadio = document.querySelector('input[name="rating"]:checked');
            if (checkedRadio) {
                updateStars(parseInt(checkedRadio.value));
            } else {
                updateStars(0);
            }
        });
    });

    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateStars(parseInt(this.value));
        });
    });
});
</script>
@endpush
