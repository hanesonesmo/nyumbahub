@extends('admin.layouts.app')

@section('title', __('Listings — NyumbaHub Admin'))
@section('page-title', __('Manage Listings'))

@push('styles')
<style>
    .filter-bar { background:white; border:1px solid var(--gray-200); border-radius:var(--radius-lg); padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
    .filter-bar select, .filter-bar input { height:38px; padding:0 12px; border:1.5px solid var(--gray-200); border-radius:var(--radius); font-size:13px; font-family:var(--font-body); color:var(--gray-700); background:white; outline:none; appearance:none; min-width:140px; }
    .filter-bar select:focus, .filter-bar input:focus { border-color:var(--primary); }
    .listing-thumb { width:56px; height:44px; border-radius:var(--radius-sm); object-fit:cover; background:var(--gray-100); flex-shrink:0; }
    .listing-no-img { width:56px; height:44px; border-radius:var(--radius-sm); background:var(--gray-100); display:flex; align-items:center; justify-content:center; color:var(--gray-300); font-size:18px; flex-shrink:0; }
    .action-btn { display:inline-flex; align-items:center; gap:4px; padding:5px 12px; border-radius:var(--radius-full); font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:var(--font-body); transition:all 0.15s; }
    .action-approve { background:#ECFDF5; color:#059669; }
    .action-approve:hover { background:#059669; color:white; }
    .action-reject  { background:#FEF2F2; color:#DC2626; }
    .action-reject:hover  { background:#DC2626; color:white; }
    @media(max-width:768px) { .data-table thead { display:none; } .data-table tr { display:block; margin-bottom:16px; background:white; border-radius:var(--radius-lg); border:1px solid var(--gray-200); padding:16px; } .data-table td { display:block; padding:4px 0; border:none; font-size:13px; } }
</style>
@endpush

@section('topbar-actions')
<div style="display:flex;gap:10px;">
    <div style="background:var(--warning-bg);color:var(--warning);border:1px solid var(--warning-border);padding:6px 14px;border-radius:var(--radius-full);font-size:13px;font-weight:600;">
        <i class="fa-solid fa-clock"></i> {{ $pendingCount }} Pending
    </div>
</div>
@endsection

@section('content')

{{-- Filter bar --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.listings') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">
        <i class="fa-solid fa-filter" style="color:var(--gray-400);"></i>
        <select name="status" onchange="this.form.submit()">
            <option value="">{{ __('All Statuses') }}</option>
            @foreach(['pending','active','rejected','sold','rented'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="type" onchange="this.form.submit()">
            <option value="">{{ __('All Types') }}</option>
            <option value="rent"  {{ request('type') === 'rent'  ? 'selected' : '' }}>{{ __('For Rent') }}</option>
            <option value="sale"  {{ request('type') === 'sale'  ? 'selected' : '' }}>{{ __('For Sale') }}</option>
        </select>
        <input type="text" name="search" placeholder="{{ __('Search title or location...') }}" value="{{ request('search') }}">
        <button type="submit" class="btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass"></i> {{ __('Search') }}</button>
        @if(request()->hasAny(['status','type','search']))
            <a href="{{ route('admin.listings') }}" class="btn-outline btn-sm"><i class="fa-solid fa-xmark"></i> {{ __('Clear') }}</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('Property') }}</th>
                    <th>{{ __('Agent') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Location') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listings as $listing)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($listing->images->first())
                                <img class="listing-thumb"
                                    src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                                    alt="">
                            @else
                                <div class="listing-no-img"><i class="fa-solid fa-image"></i></div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--gray-900);font-size:13px;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $listing->title }}
                                </div>
                                <div style="font-size:11px;color:var(--gray-500);">{{ ucfirst($listing->category) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:13px;font-weight:600;color:var(--gray-800);">{{ $listing->agent->first_name ?? '—' }} {{ $listing->agent->last_name ?? '' }}</div>
                        <div style="font-size:11px;color:var(--gray-500);">{{ $listing->agent->email ?? '' }}</div>
                    </td>
                    <td>
                        <span style="padding:3px 10px;border-radius:var(--radius-full);font-size:11px;font-weight:700;background:{{ $listing->type === 'rent' ? '#EFF6FF' : '#FFF7ED' }};color:{{ $listing->type === 'rent' ? '#2563EB' : '#C2410C' }};">
                            {{ $listing->type === 'rent' ? 'Rent' : 'Sale' }}
                        </span>
                    </td>
                    <td style="font-weight:600;font-size:13px;white-space:nowrap;">
                        TZS {{ number_format($listing->price) }}
                    </td>
                    <td style="font-size:13px;color:var(--gray-600);">{{ $listing->location }}</td>
                    <td><span class="badge badge-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span></td>
                    <td style="font-size:12px;color:var(--gray-500);white-space:nowrap;">{{ $listing->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            @if($listing->status === 'pending')
                                <form method="POST" action="{{ route('admin.listings.approve', $listing->id) }}">
                                    @csrf
                                    <button type="submit" class="action-btn action-approve">
                                        <i class="fa-solid fa-check"></i> {{ __('Approve') }}
                                    </button>
                                </form>
                                <button onclick="openRejectModal({{ $listing->id }})"
                                    class="action-btn action-reject">
                                    <i class="fa-solid fa-xmark"></i> {{ __('Reject') }}
                                </button>
                            @elseif($listing->status === 'active')
                                <a href="{{ route('listings.show', $listing->slug) }}"
                                    class="action-btn" style="background:var(--gray-100);color:var(--gray-600);">
                                    <i class="fa-solid fa-eye"></i> {{ __('View') }}
                                </a>
                            @else
                                <span style="font-size:12px;color:var(--gray-400);">{{ ucfirst($listing->status) }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="table-empty">{{ __('No listings found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:20px;">{{ $listings->links() }}</div>

{{-- Reject Modal --}}
<div id="rejectModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:20px;padding:32px;max-width:440px;width:90%;box-shadow:var(--shadow-2xl);">
        <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">{{ __('Reject Listing') }}</h3>
        <p style="font-size:14px;color:var(--gray-500);margin-bottom:20px;">{{ __('Please provide a reason for rejecting this listing. The agent will be notified.') }}</p>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="field">
                <label>{{ __('Rejection Reason') }}</label>
                <textarea name="rejection_reason" rows="4"
                    placeholder="{{ __('e.g. Incomplete information, invalid photos, property already listed...') }}"
                    style="resize:none;" required></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:16px;">
                <button type="submit" class="btn-danger" style="flex:1;justify-content:center;">
                    <i class="fa-solid fa-xmark"></i> {{ __('Reject Listing') }}
                </button>
                <button type="button" onclick="closeRejectModal()" class="btn-outline" style="flex:1;justify-content:center;">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openRejectModal(id) {
    document.getElementById('rejectForm').action = '/admin/listings/' + id + '/reject';
    document.getElementById('rejectModal').style.display = 'flex';
}
function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endpush
