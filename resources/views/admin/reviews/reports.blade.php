@extends('admin.layouts.app')
@section('title', 'Review Reports')
@section('page-title', 'Review Reports')

@section('content')
<div class="container-fluid" style="padding-top:20px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Review Reports</h1>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Reviews
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-danger">Reported Reviews</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Reported By</th>
                            <th>Reason</th>
                            <th>Details</th>
                            <th>Review Context</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-bold">{{ $report->reporter->first_name }} {{ $report->reporter->last_name }}</div>
                                    <small class="text-muted">{{ $report->reporter->email }}</small>
                                </td>
                                <td><span class="badge bg-light text-danger border">{{ $report->reason }}</span></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $report->details }}">
                                        {{ $report->details ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    @if($report->review)
                                        <div class="text-warning small mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $report->review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="text-truncate small text-muted" style="max-width: 200px;">
                                            {{ $report->review->review_text }}
                                        </div>
                                    @else
                                        <span class="text-danger">Review Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($report->status === 'pending')
                                        <span class="badge bg-danger">Pending</span>
                                    @elseif($report->status === 'reviewed')
                                        <span class="badge bg-success">Reviewed</span>
                                    @else
                                        <span class="badge bg-secondary">Dismissed</span>
                                    @endif
                                </td>
                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                                <td class="text-end px-4">
                                    @if($report->review)
                                        <a href="{{ route('admin.reviews.show', $report->review->id) }}" class="btn btn-sm btn-outline-primary" title="View Review Details"><i class="fa-solid fa-eye"></i></a>
                                    @endif
                                    
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        @if($report->status !== 'reviewed')
                                            <li>
                                                <form action="{{ route('admin.reviews.updateReportStatus', $report->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="reviewed">
                                                    <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-check me-2"></i> Mark as Reviewed</button>
                                                </form>
                                            </li>
                                        @endif
                                        @if($report->status !== 'dismissed')
                                            <li>
                                                <form action="{{ route('admin.reviews.updateReportStatus', $report->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="dismissed">
                                                    <button type="submit" class="dropdown-item"><i class="fa-solid fa-times text-muted me-2"></i> Dismiss Report</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No review reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $reports->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
