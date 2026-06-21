<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Listings — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <style>
        .filter-tab { padding:8px 16px;border-radius:var(--radius);font-size:13px;font-weight:600;text-decoration:none;transition:all 0.2s;display:inline-flex;align-items:center;gap:6px; }
        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; }
        .btn-approve { padding: 5px 12px; background: linear-gradient(135deg, var(--accent), var(--accent-light)); color: #fff; border: none; border-radius: var(--radius-sm); font-size: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s; }
        .btn-approve:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(233,69,96,0.3); }
        .btn-reject  { padding: 5px 12px; background: var(--error); color: #fff; border: none; border-radius: var(--radius-sm); font-size: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s; }
        .btn-reject:hover { transform: translateY(-1px); }
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center; backdrop-filter:blur(4px); }
        .modal-overlay.show { display:flex; }
        .modal { background:var(--surface); border-radius:var(--radius-lg); padding:32px; width:100%; max-width:440px; box-shadow:var(--shadow-xl); }
        .modal h3 { margin-bottom:16px; font-size:18px; color:var(--text); }
        .modal textarea { width:100%; height:100px; padding:10px; border:1.5px solid var(--border); border-radius:var(--radius); font-family:var(--font-body); font-size:14px; resize:none; outline:none; background:var(--surface); color:var(--text); }
        .modal-actions { display:flex; gap:10px; margin-top:16px; justify-content:flex-end; }
        .btn-cancel { padding:8px 18px; border:1.5px solid var(--border); border-radius:var(--radius); background:var(--surface); cursor:pointer; font-size:14px; color:var(--text); transition:background 0.2s; }
        .btn-cancel:hover { background:var(--bg-soft); }
        .alert-success { background:rgba(0,138,5,0.08);border:1px solid rgba(0,138,5,0.15);border-radius:var(--radius);padding:12px 16px;margin-bottom:20px;color:var(--success);font-size:14px; }
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
        <div class="topbar-admin">
            <div class="theme-picker-wrap" style="position:relative">
                <button class="theme-picker-btn" id="themePickerBtn" aria-label="Choose theme">
                    <i class="fa-solid fa-sun"></i>
                </button>
                <div class="theme-picker-dropdown" id="themePickerDropdown"></div>
            </div>
            <span><i class="fa-solid fa-shield-halved"></i> Admin</span>
        </div>
    </header>

    <div class="admin-content">

        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Filter tabs --}}
        <div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
            <a href="{{ route('admin.listings') }}" class="filter-tab" style="background:{{ !request('status') ? 'var(--primary)' : 'var(--surface)' }};color:{{ !request('status') ? '#fff' : 'var(--text-muted)' }};border:1.5px solid var(--border);">All</a>
            <a href="{{ route('admin.listings', ['status' => 'pending']) }}" class="filter-tab" style="background:{{ request('status') === 'pending' ? 'var(--primary)' : 'var(--surface)' }};color:{{ request('status') === 'pending' ? '#fff' : 'var(--text-muted)' }};border:1.5px solid var(--border);">Pending</a>
            <a href="{{ route('admin.listings', ['status' => 'active']) }}" class="filter-tab" style="background:{{ request('status') === 'active' ? 'var(--primary)' : 'var(--surface)' }};color:{{ request('status') === 'active' ? '#fff' : 'var(--text-muted)' }};border:1.5px solid var(--border);">Active</a>
            <a href="{{ route('admin.listings', ['status' => 'rejected']) }}" class="filter-tab" style="background:{{ request('status') === 'rejected' ? 'var(--primary)' : 'var(--surface)' }};color:{{ request('status') === 'rejected' ? '#fff' : 'var(--text-muted)' }};border:1.5px solid var(--border);">Rejected</a>
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
                            <span class="status-badge badge-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span>
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
        <h3><i class="fa-solid fa-xmark" style="color:var(--error);"></i> Reject Listing</h3>
        <form method="POST" id="rejectForm">
            @csrf
            <label style="font-size:13px;font-weight:600;color:var(--text);display:block;margin-bottom:6px;">
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

<style>
.status-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
.badge-pending { background: rgba(245,158,11,0.12); color: #F59E0B; }
.badge-active { background: rgba(0,138,5,0.12); color: var(--success); }
.badge-rejected { background: rgba(193,53,21,0.12); color: var(--error); }
</style>

<script src="{{ asset('js/theme-picker.js') }}?v={{ time() }}"></script>
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
