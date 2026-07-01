@extends('layouts.app')

@section('title', __('My Reviews'))

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="fa-solid fa-star text-warning me-2"></i>{{ __('My Reviews') }}</h2>
            <p class="text-muted">{{ __('Manage your property viewing reviews and share your feedback.') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Pending Reviews -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">{{ __('Pending Reviews') }}</h5>
                </div>
                <div class="card-body">
                    @forelse($pendingAppointments as $appointment)
                        <div class="border-bottom pb-3 mb-3 last-no-border">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0 text-truncate" style="max-width: 200px;">
                                    <a href="{{ route('listings.show', $appointment->listing->slug) }}" class="text-decoration-none text-dark">
                                        {{ $appointment->listing->title }}
                                    </a>
                                </h6>
                                <span class="badge bg-success">Completed</span>
                            </div>
                            <p class="small text-muted mb-2">
                                <i class="fa-solid fa-user-tie me-1"></i> Agent: {{ $appointment->listing->agent->first_name }} {{ $appointment->listing->agent->last_name }}
                            </p>
                            <a href="{{ route('reviews.create', $appointment->id) }}" class="btn btn-sm btn-primary w-100">
                                <i class="fa-solid fa-pen me-1"></i> Leave a Review
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fa-solid fa-check-circle fs-2 mb-2 text-success opacity-50"></i>
                            <p class="mb-0">{{ __('You have no pending reviews.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Submitted Reviews -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">{{ __('Submitted Reviews') }}</h5>
                </div>
                <div class="card-body p-0">
                    @forelse($reviews as $review)
                        <div class="p-4 border-bottom last-no-border">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="mb-1">
                                        <a href="{{ route('listings.show', $review->listing->slug) }}" class="text-decoration-none text-dark">
                                            {{ $review->listing->title }}
                                        </a>
                                    </h5>
                                    <div class="text-warning small mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted ms-2">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><a class="dropdown-item" href="{{ route('reviews.edit', $review->id) }}"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if($review->review_title)
                                <h6 class="fw-bold">{{ $review->review_title }}</h6>
                            @endif
                            <p class="text-muted mb-0">{{ $review->review_text }}</p>

                            @if($review->agent_response)
                                <div class="bg-light p-3 rounded mt-3 ms-4 border-start border-primary border-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-solid fa-reply text-primary me-2"></i>
                                        <span class="fw-bold">{{ __('Response from Agent:') }} {{ $review->agent->first_name }}</span>
                                    </div>
                                    <p class="mb-0 text-muted">{{ $review->agent_response }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-comment-slash fs-1 mb-3 opacity-50"></i>
                            <h5 class="fw-bold">{{ __('No Reviews Yet') }}</h5>
                            <p>{{ __('You have not submitted any reviews. Once you complete a viewing, you can share your feedback here.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
