@extends('layouts.app')

@section('title', $agent->first_name . ' ' . $agent->last_name . ' - Agent Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Agent Info Sidebar -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    @if($agent->agentProfile && $agent->agentProfile->profile_photo)
                        <img src="{{ asset('storage/' . $agent->agentProfile->profile_photo) }}" alt="{{ $agent->first_name }}" class="rounded-circle mb-3 object-fit-cover" width="150" height="150">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:150px; height:150px; font-size:48px;">
                            {{ substr($agent->first_name, 0, 1) }}
                        </div>
                    @endif
                    
                    <h3 class="card-title">{{ $agent->first_name }} {{ $agent->last_name }}</h3>
                    
                    @if($agent->agentProfile && $agent->agentProfile->agency_name)
                        <p class="text-muted mb-2"><i class="fa-solid fa-briefcase me-2"></i>{{ $agent->agentProfile->agency_name }}</p>
                    @endif

                    @if($agent->agentProfile && $agent->agentProfile->total_reviews > 0)
                        <div class="mb-3 d-flex align-items-center justify-content-center">
                            <div class="text-warning me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($agent->agentProfile->average_rating))
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="fw-bold">{{ number_format($agent->agentProfile->average_rating, 1) }}</span>
                            <span class="text-muted ms-1">({{ $agent->agentProfile->total_reviews }} reviews)</span>
                        </div>
                    @endif
                    
                    <span class="badge bg-success mb-3"><i class="fa-solid fa-check-circle me-1"></i> {{ __('Verified Agent') }}</span>
                    
                    <div class="d-flex flex-column gap-2 mt-3">
                        <a href="mailto:{{ $agent->email }}" class="btn btn-outline-primary"><i class="fa-solid fa-envelope me-2"></i>{{ __('Email Agent') }}</a>
                        @if($agent->phone)
                            <a href="tel:{{ $agent->phone }}" class="btn btn-outline-success"><i class="fa-solid fa-phone me-2"></i>{{ __('Call Agent') }}</a>
                        @endif
                        @if($agent->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->whatsapp) }}" target="_blank" class="btn btn-success"><i class="fa-brands fa-whatsapp me-2"></i>{{ __('WhatsApp') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Agent Stats') }}</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Active Listings') }}
                            <span class="badge bg-primary rounded-pill">{{ $listings->total() }}</span>
                        </li>
                        @if($agent->agentProfile)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Experience') }}
                            <span class="badge bg-info rounded-pill">{{ $agent->agentProfile->years_experience }} Years</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">About {{ $agent->first_name }}</h4>
                    @if($agent->agentProfile && $agent->agentProfile->bio)
                        <p class="card-text text-muted" style="white-space: pre-line;">{{ $agent->agentProfile->bio }}</p>
                    @else
                        <p class="text-muted fst-italic">{{ __('This agent hasn\'t provided a bio yet.') }}</p>
                    @endif
                    
                    @if($agent->agentProfile && $agent->agentProfile->service_regions)
                        <h5 class="mt-4 mb-2">{{ __('Service Areas') }}</h5>
                        <div>
                            @foreach(explode(',', $agent->agentProfile->service_regions) as $region)
                                <span class="badge bg-light text-dark border me-1">{{ trim($region) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <h4 class="mb-4">Listings by {{ $agent->first_name }}</h4>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @forelse($listings as $listing)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 listing-card">
                            <img src="{{ $listing->images->where('is_primary', true)->first() ? asset('storage/' . $listing->images->where('is_primary', true)->first()->image_path) : asset('images/placeholder.jpg') }}" class="card-img-top object-fit-cover" alt="{{ $listing->title }}" height="200">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title text-truncate mb-0" title="{{ $listing->title }}">{{ $listing->title }}</h5>
                                </div>
                                <p class="card-text text-muted small mb-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $listing->location }}</p>
                                <div class="fs-5 fw-bold text-primary mb-3">TZS {{ number_format($listing->price) }} <span class="fs-6 text-muted fw-normal">{{ $listing->type === 'rent' ? '/month' : '' }}</span></div>
                                <div class="d-flex gap-3 text-muted small mb-3">
                                    @if($listing->bedrooms)
                                        <span title="{{ __('Bedrooms') }}"><i class="fa-solid fa-bed me-1"></i>{{ $listing->bedrooms }}</span>
                                    @endif
                                    @if($listing->bathrooms)
                                        <span title="{{ __('Bathrooms') }}"><i class="fa-solid fa-bath me-1"></i>{{ $listing->bathrooms }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('listings.show', $listing->slug ?? $listing->id) }}" class="btn btn-outline-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="fa-solid fa-info-circle me-2"></i> {{ __('This agent currently has no active listings.') }}
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $listings->links('pagination::bootstrap-5') }}
            </div>
            
            <hr class="my-5">

            <!-- Reviews Section -->
            <h4 class="mb-4" id="reviews">Client Reviews</h4>
            @if($reviews->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-4 text-center border-end">
                        <h1 class="display-4 fw-bold mb-0 text-primary">{{ number_format($agent->agentProfile->average_rating, 1) }}</h1>
                        <div class="text-warning fs-4 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($agent->agentProfile->average_rating))
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted">Based on {{ $agent->agentProfile->total_reviews }} reviews</p>
                    </div>
                    <div class="col-md-8">
                        @foreach([5, 4, 3, 2, 1] as $star)
                            @php
                                $count = $reviews->where('rating', $star)->count();
                                $percentage = $reviews->count() > 0 ? ($count / $reviews->count()) * 100 : 0;
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2 text-muted" style="width: 40px;">{{ $star }} Star</span>
                                <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2 text-muted" style="width: 30px;">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-list">
                    @foreach($reviews as $review)
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">{{ $review->user->first_name }} {{ $review->user->last_name }}</h5>
                                    <div class="text-warning small">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted small mb-2"><i class="fa-regular fa-clock me-1"></i> {{ $review->created_at->format('M d, Y') }}</p>
                                <p class="card-text">{{ $review->comment }}</p>

                                @if($review->agent_response)
                                    <div class="bg-light p-3 rounded mt-3 ms-4 border-start border-primary border-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa-solid fa-reply text-primary me-2"></i>
                                            <span class="fw-bold">{{ __('Response from Agent') }}</span>
                                        </div>
                                        <p class="mb-0 text-muted">{{ $review->agent_response }}</p>
                                    </div>
                                @endif

                                @auth
                                    @if(auth()->user()->id === $agent->id && !$review->agent_response)
                                        <div class="mt-3">
                                            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm{{ $review->id }}" aria-expanded="false" aria-controls="replyForm{{ $review->id }}">
                                                <i class="fa-solid fa-reply me-1"></i> Reply
                                            </button>
                                            <div class="collapse mt-2" id="replyForm{{ $review->id }}">
                                                <form action="{{ route('agent.reviews.respond', $review->id) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-2">
                                                        <textarea name="agent_response" class="form-control" rows="3" placeholder="Write your official response..." required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-primary">Submit Response</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-light border-0 shadow-sm text-center py-4">
                    <i class="fa-solid fa-star text-muted fs-1 mb-3"></i>
                    <h5>{{ __('No reviews yet') }}</h5>
                    <p class="text-muted mb-0">{{ __('This agent has not received any reviews yet.') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
