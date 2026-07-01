@extends('layouts.dashboard')

@section('title', __('My Reviews'))
@section('page-title', __('My Reviews'))
@section('page-subtitle', __('Reviews you have left for agents'))

@section('content')

@if(session('success'))
    <div style="background:#ECFDF5; border:1px solid #6EE7B7; border-radius:8px; padding:16px; color:#065F46; margin-bottom:24px; font-size:14px; font-weight:600;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div style="display:flex; flex-direction:column; gap:16px;">
    @forelse($reviews as $review)
        <div style="background:white; border:1px solid var(--gray-200); border-radius:16px; padding:24px; box-shadow:var(--shadow-xs);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
                <div style="display:flex; gap:16px; align-items:center;">
                    <div style="width:48px; height:48px; background:var(--primary); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:700;">
                        {{ strtoupper(substr($review->agent->first_name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <h4 style="font-size:16px; font-weight:700; color:var(--gray-900); margin:0 0 4px 0;">
                            {{ $review->agent->first_name }} {{ $review->agent->last_name }}
                        </h4>
                        <div style="font-size:13px; color:var(--gray-500);">
                            {{ __('For property:') }} <a href="{{ route('listings.show', $review->appointment->listing->slug) }}" style="color:var(--primary); text-decoration:none; font-weight:600;">{{ $review->appointment->listing->title }}</a>
                        </div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="display:flex; gap:2px; color:#F59E0B; font-size:14px; margin-bottom:4px; justify-content:flex-end;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star" style="color:var(--gray-300);"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="badge badge-{{ $review->status }}">
                        {{ ucfirst($review->status) }}
                    </span>
                </div>
            </div>
            
            <p style="font-size:14px; color:var(--gray-700); line-height:1.6; margin-bottom:16px; background:var(--gray-50); padding:16px; border-radius:12px;">
                "{{ $review->comment }}"
            </p>

            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--gray-100); padding-top:16px;">
                <div style="font-size:12px; color:var(--gray-400);">
                    <i class="fa-solid fa-clock"></i> {{ $review->created_at->format('M d, Y H:i') }}
                </div>
                <div style="display:flex; gap:12px;">
                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this review?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:var(--error); font-size:13px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:4px;">
                            <i class="fa-solid fa-trash"></i> {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="background:white; border:1px solid var(--gray-200); border-radius:16px; padding:60px 24px; text-align:center; box-shadow:var(--shadow-xs);">
            <i class="fa-regular fa-star" style="font-size:48px; color:var(--gray-200); margin-bottom:16px; display:block;"></i>
            <h2 style="font-size:20px; font-weight:700; color:var(--gray-900); margin-bottom:8px;">{{ __('No reviews yet') }}</h2>
            <p style="font-size:14px; color:var(--gray-500); margin-bottom:24px;">{{ __('You have not written any reviews for agents yet. Complete a viewing to leave a review.') }}</p>
        </div>
    @endforelse
</div>

@if($reviews->hasPages())
    <div style="margin-top:24px;">
        {{ $reviews->links() }}
    </div>
@endif

@endsection
