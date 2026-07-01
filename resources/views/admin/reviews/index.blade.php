@extends('admin.layouts.app')
@section('title', 'Manage Reviews')
@section('page-title', 'Manage Reviews')

@section('content')
<div class="container-fluid" style="padding-top:20px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reviews Moderation</h1>
        <a href="{{ route('admin.reviews.reports') }}" class="btn btn-warning shadow-sm">
            <i class="fa-solid fa-flag me-1"></i> View Reports
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between bg-white">
            <h6 class="m-0 fw-bold text-primary">All Reviews</h6>
            
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Hidden</option>
                </select>
                <select name="rating" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">User</th>
                            <th>Agent</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-bold">{{ $review->user->first_name }} {{ $review->user->last_name }}</div>
                                    <small class="text-muted">{{ $review->user->email }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $review->agent->first_name }} {{ $review->agent->last_name }}</div>
                                </td>
                                <td>
                                    <div class="text-warning small">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;">
                                        @if($review->review_title) <strong>{{ $review->review_title }}</strong><br> @endif
                                        {{ $review->review_text }}
                                    </div>
                                </td>
                                <td>
                                    @if($review->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($review->status === 'hidden')
                                        <span class="badge bg-danger">Hidden</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $review->created_at->format('M d, Y') }}</td>
                                <td class="text-end px-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fa-solid fa-eye"></i></a>
                                        
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            @if($review->status !== 'approved')
                                                <li>
                                                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-check me-2"></i> Approve</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($review->status !== 'hidden')
                                                <li>
                                                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="hidden">
                                                        <button type="submit" class="dropdown-item text-warning"><i class="fa-solid fa-eye-slash me-2"></i> Hide</button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this review?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No reviews found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
