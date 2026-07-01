@extends('admin.layouts.app')
@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('content')
<div class="container-fluid" style="padding-top:20px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Review Details</h1>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Reviews
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Review #{{ $review->id }}</h6>
                    <div>
                        @if($review->status === 'approved')
                            <span class="badge bg-success fs-6">Approved</span>
                        @elseif($review->status === 'hidden')
                            <span class="badge bg-danger fs-6">Hidden</span>
                        @else
                            <span class="badge bg-warning text-dark fs-6">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-warning fs-3 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="fs-5 text-dark">{{ $review->comment }}</p>
                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> Submitted on {{ $review->created_at->format('M d, Y h:i A') }}</small>
                    </div>

                    @if($review->agent_response)
                        <hr>
                        <div class="bg-light p-4 rounded ms-4 border-start border-primary border-4 mt-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-reply me-2"></i>Agent Response</h6>
                            <p class="mb-0">{{ $review->agent_response }}</p>
                            <small class="text-muted d-block mt-2">Responded on {{ $review->updated_at->format('M d, Y h:i A') }}</small>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white d-flex gap-2">
                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-success" {{ $review->status === 'approved' ? 'disabled' : '' }}>
                            <i class="fa-solid fa-check me-1"></i> Approve
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="hidden">
                        <button type="submit" class="btn btn-warning" {{ $review->status === 'hidden' ? 'disabled' : '' }}>
                            <i class="fa-solid fa-eye-slash me-1"></i> Hide
                        </button>
                    </form>

                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="ms-auto" onsubmit="return confirm('Delete this review permanently?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash me-1"></i> Delete Permanently
                        </button>
                    </form>
                </div>
            </div>

            @if($review->reports->count() > 0)
                <div class="card shadow mb-4 border-0 border-start border-danger border-4">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-danger">Reports ({{ $review->reports->count() }})</h6>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($review->reports as $report)
                            <div class="list-group-item p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="fw-bold">{{ $report->reporter->first_name }} {{ $report->reporter->last_name }}</div>
                                    <span class="badge bg-{{ $report->status === 'pending' ? 'danger' : 'secondary' }}">{{ ucfirst($report->status) }}</span>
                                </div>
                                <p class="mb-1 text-danger fw-semibold">Reason: {{ $report->reason }}</p>
                                @if($report->details)
                                    <p class="mb-1 text-muted">{{ $report->details }}</p>
                                @endif
                                <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary">Context</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold text-muted text-uppercase small mb-2">Reviewer</h6>
                        <div class="d-flex align-items-center">
                            @if($review->user->avatar)
                                <img src="{{ asset('storage/' . $review->user->avatar) }}" class="rounded-circle me-3" width="40" height="40">
                            @else
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;">
                                    {{ substr($review->user->first_name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $review->user->first_name }} {{ $review->user->last_name }}</div>
                                <div class="small text-muted">{{ $review->user->email }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-muted text-uppercase small mb-2">Agent</h6>
                        <div class="d-flex align-items-center">
                            @if($review->agent->agentProfile && $review->agent->agentProfile->profile_photo)
                                <img src="{{ asset('storage/' . $review->agent->agentProfile->profile_photo) }}" class="rounded-circle me-3" width="40" height="40">
                            @else
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;">
                                    {{ substr($review->agent->first_name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $review->agent->first_name }} {{ $review->agent->last_name }}</div>
                                <a href="{{ route('agent.profile.show', $review->agent->id) }}" target="_blank" class="small">View Profile <i class="fa-solid fa-external-link-alt ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="fw-bold text-muted text-uppercase small mb-2">Listing</h6>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-house text-primary me-2"></i>
                            <a href="{{ route('listings.show', $review->appointment->listing->slug) }}" target="_blank" class="fw-bold text-dark text-truncate">{{ $review->appointment->listing->title }}</a>
                        </div>
                        <div class="small text-muted mb-2"><i class="fa-solid fa-calendar me-1"></i> Appointment ID: #{{ $review->appointment_id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
