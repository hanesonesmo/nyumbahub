<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Listings — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-pending  { background: #FEF9C3; color: #854D0E; }
        .badge-active   { background: #D1FAE5; color: #065F46; }
        .badge-rejected { background: #FEE2E2; color: #991B1B; }
        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; }
        .btn-approve { padding: 5px 12px; background: #1B4332; color: #fff; border: none; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 600; }
        .btn-reject  { padding: 5px 12px; background: #C0392B; color: #fff; border: none; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 600; }
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center; }
        .modal-overlay.show { display:flex; }
        .modal { background:#fff; border-radius:12px; padding:32px; width:100%; max-width:440px; }
        .modal h3 { margin-bottom:16px; font-size:18px; }
        .modal textarea { width:100%; height:100px; padding:10px; border:1.5px solid #E0DBD3; border-radius:8px; font-family:Arial,sans-serif; font-size:14px; resize:none; outline:none; }
        .modal-actions { display:flex; gap:10px; margin-top:16px; justify-content:flex-end; }
        .btn-cancel { padding:8px 18px; border:1.5px solid #E0DBD3; border-radius:8px; background:#fff; cursor:pointer; font-size:14px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">Nyumba<span>Hub</span><small>Admin Panel</small></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.users') }}" class="sidebar-link"><i class="fa-solid fa-users"></i> Users</a>
        <a href="{{ route('admin.listings') }}" class="sidebar-link active"><i class="fa-solid fa-building"></i> Listings</a>
        <a href="{{ route('admin.appointments') }}" class="sidebar-link"><i class="fa-solid fa-calendar"></i> Appointments</a>
        <div class="sidebar-divider"></div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-topbar">
        <h1 class="topbar-title">Manage Listings</h1>
        <div class="topbar-admin"><i class="fa-solid fa-shield-halved"></i> Admin</div>
    </header>

    <div class="admin-content">

        @if(session('success'))
            <div style="background:#D1FAE5;border:1px solid #A7F3D0;border-radius:8px;padding:12px 16px;margin-bottom:20px;color:#065F46;font-size:14px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Filter tabs --}}
        <div style="display:flex;gap:8px;margin-bottom:20px;">
            <a href="{{ route('admin.listings') }}" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;background:{{ !request('status') ? '#1B4332' : '#fff' }};color:{{ !request('status') ? '#fff' : '#6B6B6B' }};border:1px solid #E0DBD3;">All</a>
            <a href="{{ route('admin.listings', ['status' => 'pending']) }}" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;background:{{ request('status') === 'pending' ? '#1B4332' : '#fff' }};color:{{ request('status') === 'pending' ? '#fff' : '#6B6B6B' }};border:1px solid #E0DBD3;">Pending</a>
            <a href="{{ route('admin.listings', ['status' => 'active']) }}" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;background:{{ request('status') === 'active' ? '#1B4332' : '#fff' }};color:{{ request('status') === 'active' ? '#fff' : '#6B6B6B' }};border:1px solid #E0DBD3;">Active</a>
            <a href="{{ route('admin.listings', ['status' => 'rejected']) }}" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;background:{{ request('status') === 'rejected' ? '#1B4332' : '#fff' }};color:{{ request('status') === 'rejected' ? '#fff' : '#6B6B6B' }};border:1px solid #E0DBD3;">Rejected</a>
        </div>

        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Agent</th>
                        <th>Type</th>
                        <th>Price (TZS)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $listing)
                    <tr>
                        <td>{{ $listing->id }}</td>
                        <td>{{ $listing->title }}</td>
                        <td>{{ $listing->agent->first_name ?? '-' }} {{ $listing->agent->last_name ?? '' }}</td>
                        <td>{{ ucfirst($listing->type) }}</td>
                        <td>{{ number_format($listing->price) }}</td>
                        <td>
                            <span class="badge badge-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span>
                        </td>
                        <td>
                            <div class="action-btns">
                                @if($listing->status !== 'active')
                                    <form method="POST" action="{{ route('admin.listings.approve', $listing->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-approve">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </button>
                                    </form>
                                @endif
                                @if($listing->status !== 'rejected')
                                    <button class="btn-reject" onclick="openReject({{ $listing->id }})">
                                        <i class="fa-solid fa-xmark"></i> Reject
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="table-empty">No listings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">{{ $listings->links() }}</div>

    </div>
</div>

{{-- Reject modal --}}
<div class="modal-overlay" id="rejectModal">
    <div class="modal">
        <h3><i class="fa-solid fa-xmark" style="color:#C0392B;"></i> Reject Listing</h3>
        <form method="POST" id="rejectForm">
            @csrf
            <label style="font-size:13px;font-weight:600;color:#1A1A1A;display:block;margin-bottom:6px;">
                Reason for rejection
            </label>
            <textarea name="rejection_reason" placeholder="Explain why this listing is being rejected..." required></textarea>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeReject()">Cancel</button>
                <button type="submit" class="btn-reject">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
function openReject(id) {
    document.getElementById('rejectForm').action = '/admin/listings/' + id + '/reject';
    document.getElementById('rejectModal').classList.add('show');
}
function closeReject() {
    document.getElementById('rejectModal').classList.remove('show');
}
</script>

</body>
</html>
