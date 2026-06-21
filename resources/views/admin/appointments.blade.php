<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments — NyumbaHub Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">Nyumba<span>Hub</span><small>Admin Panel</small></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.users') }}" class="sidebar-link"><i class="fa-solid fa-users"></i> Users</a>
        <a href="{{ route('admin.listings') }}" class="sidebar-link"><i class="fa-solid fa-building"></i> Listings</a>
        <a href="{{ route('admin.appointments') }}" class="sidebar-link active"><i class="fa-solid fa-calendar"></i> Appointments</a>
        <div class="sidebar-divider"></div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-topbar">
        <h1 class="topbar-title">All Appointments</h1>
        <div class="topbar-admin"><i class="fa-solid fa-shield-halved"></i> Admin</div>
    </header>

    <div class="admin-content">

        {{-- Stats --}}
        <div class="admin-stats" style="grid-template-columns:repeat(3,1fr);margin-bottom:24px;">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#1B4332;">
                    <i class="fa-solid fa-calendar"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $appointments->total() }}</div>
                    <div class="admin-stat-label">Total</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#D4A853;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $pending }}</div>
                    <div class="admin-stat-label">Pending</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#008A05;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $confirmed }}</div>
                    <div class="admin-stat-label">Confirmed</div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Listing</th>
                        <th>Date & Time</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</div>
                            <div style="font-size:12px;color:#717171;">{{ $appointment->user->email }}</div>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $appointment->listing->title }}</div>
                            <div style="font-size:12px;color:#717171;">{{ $appointment->listing->location }}</div>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}<br>
                            <span style="color:#717171;font-size:12px;">{{ $appointment->time }}</span>
                        </td>
                        <td style="max-width:150px;font-size:13px;color:#717171;">
                            {{ $appointment->message ?? '—' }}
                        </td>
                        <td>
                            <span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;
                                background:{{ $appointment->status === 'confirmed' ? '#D1FAE5' : ($appointment->status === 'cancelled' ? '#FEE2E2' : '#FEF9C3') }};
                                color:{{ $appointment->status === 'confirmed' ? '#065F46' : ($appointment->status === 'cancelled' ? '#991B1B' : '#854D0E') }};">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="table-empty">No appointments yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">{{ $appointments->links() }}</div>

    </div>
</div>

</body>
</html>
