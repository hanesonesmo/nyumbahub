@extends('layouts.app')

@section('title', __('Edit Review'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-pen-to-square text-primary fs-1 mb-3"></i>
                        <h3 class="fw-bold">{{ __('Edit Review') }}</h3>
                        <p class="text-muted">{{ __('Update your feedback for ') }} {{ $review->listing->title }}</p>
                    </div>

                    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold d-block">{{ __('Rate your experience') }}</label>
                            <div class="rating-input d-flex justify-content-center flex-row-reverse gap-2">
                                <input type="radio" id="star5" name="rating" value="5" class="d-none" required {{ old('rating', $review->rating) == 5 ? 'checked' : '' }}/>
                                <label for="star5" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="5 stars"></label>
                                
                                <input type="radio" id="star4" name="rating" value="4" class="d-none" {{ old('rating', $review->rating) == 4 ? 'checked' : '' }}/>
                                <label for="star4" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="4 stars"></label>
                                
                                <input type="radio" id="star3" name="rating" value="3" class="d-none" {{ old('rating', $review->rating) == 3 ? 'checked' : '' }}/>
                                <label for="star3" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="3 stars"></label>
                                
                                <input type="radio" id="star2" name="rating" value="2" class="d-none" {{ old('rating', $review->rating) == 2 ? 'checked' : '' }}/>
                                <label for="star2" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="2 stars"></label>
                                
                                <input type="radio" id="star1" name="rating" value="1" class="d-none" {{ old('rating', $review->rating) == 1 ? 'checked' : '' }}/>
                                <label for="star1" class="fa-solid fa-star fs-2 text-muted cursor-pointer" title="1 star"></label>
                            </div>
                            @error('rating') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="review_title" class="form-label fw-bold">{{ __('Title (Optional)') }}</label>
                            <input type="text" class="form-control" id="review_title" name="review_title" value="{{ old('review_title', $review->review_title) }}">
                            @error('review_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="review_text" class="form-label fw-bold">{{ __('Review') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="review_text" name="review_text" rows="5" required>{{ old('review_text', $review->review_text) }}</textarea>
                            <div class="form-text">{{ __('Minimum 10 characters.') }}</div>
                            @error('review_text') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reviews.my') }}" class="btn btn-light border">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary px-4">{{ __('Save Changes') }}</button>
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
