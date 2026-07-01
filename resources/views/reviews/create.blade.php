@extends('layouts.app')

@section('title', __('Leave a Review'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-star text-warning fs-1 mb-3"></i>
                        <h3 class="fw-bold">{{ __('Leave a Review') }}</h3>
                        <p class="text-muted">{{ __('How was your experience with ') }} {{ $appointment->listing->agent->first_name }}?</p>
                    </div>

                    <div class="d-flex align-items-center p-3 bg-light rounded mb-4">
                        @if($appointment->listing->images->first())
                            <img src="{{ asset('storage/' . $appointment->listing->images->first()->image_path) }}" alt="{{ $appointment->listing->title }}" class="rounded me-3 object-fit-cover" width="60" height="60">
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $appointment->listing->title }}</h6>
                            <span class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> Viewing Date: {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('reviews.store', $appointment->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold d-block">{{ __('Rate your experience') }}</label>
                            <div class="rating-input d-flex justify-content-center flex-row-reverse gap-2">
                                <input type="radio" id="star5" name="rating" value="5" class="d-none" required {{ old('rating') == 5 ? 'checked' : '' }}/>
                                <label for="star5" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="5 stars"></label>
                                
                                <input type="radio" id="star4" name="rating" value="4" class="d-none" {{ old('rating') == 4 ? 'checked' : '' }}/>
                                <label for="star4" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="4 stars"></label>
                                
                                <input type="radio" id="star3" name="rating" value="3" class="d-none" {{ old('rating') == 3 ? 'checked' : '' }}/>
                                <label for="star3" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="3 stars"></label>
                                
                                <input type="radio" id="star2" name="rating" value="2" class="d-none" {{ old('rating') == 2 ? 'checked' : '' }}/>
                                <label for="star2" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="2 stars"></label>
                                
                                <input type="radio" id="star1" name="rating" value="1" class="d-none" {{ old('rating') == 1 ? 'checked' : '' }}/>
                                <label for="star1" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="1 star"></label>
                            </div>
                            @error('rating') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="review_title" class="form-label fw-bold">{{ __('Title (Optional)') }}</label>
                            <input type="text" class="form-control" id="review_title" name="review_title" value="{{ old('review_title') }}" placeholder="Summarize your experience">
                            @error('review_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="review_text" class="form-label fw-bold">{{ __('Review') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="review_text" name="review_text" rows="5" placeholder="Share details of your experience with the agent and the property..." required>{{ old('review_text') }}</textarea>
                            <div class="form-text">{{ __('Minimum 10 characters.') }}</div>
                            @error('review_text') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reviews.my') }}" class="btn btn-light border">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary px-4">{{ __('Submit Review') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS to handle star rating hover and select states */
.rating-input label:hover,
.rating-input label:hover ~ label,
.rating-input input:checked ~ label {
    color: #ffc107 !important;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
@endsection
