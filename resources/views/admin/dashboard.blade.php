<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">Nyumba<span>Hub</span><small>Admin Panel</small></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.users') }}" class="sidebar-link"><i class="fa-solid fa-users"></i> Users</a>
        <a href="{{ route('admin.listings') }}" class="sidebar-link"><i class="fa-solid fa-building"></i> Listings</a>
        <a href="{{ route('admin.appointments') }}" class="sidebar-link"><i class="fa-solid fa-calendar"></i> Appointments</a>
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
        <h1 class="topbar-title">Dashboard</h1>
        <div class="topbar-admin"><i class="fa-solid fa-shield-halved"></i> Admin</div>
    </header>

    <div class="admin-content">

        {{-- Stats --}}
        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#1B4332;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $stats['total_users'] }}</div>
                    <div class="admin-stat-label">Total Users</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#2D6A4F;">
                    <i class="fa-solid fa-building"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $stats['total_listings'] }}</div>
                    <div class="admin-stat-label">Total Listings</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#D4A853;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $stats['pending'] }}</div>
                    <div class="admin-stat-label">Pending Listings</div>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#C0392B;">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <div class="admin-stat-number">{{ $stats['active_agents'] }}</div>
                    <div class="admin-stat-label">Active Agents</div>
                </div>
            </div>
        </div>

        {{-- Tables --}}
        <div class="admin-grid">

            {{-- Recent users --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2><i class="fa-solid fa-users"></i> Recent Users</h2>
                    <a href="{{ route('admin.users') }}">View all</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span style="padding:3px 8px;border-radius:20px;font-size:11px;font-weight:700;
                                    background:{{ $user->role === 'agent' ? '#1B4332' : '#E0DBD3' }};
                                    color:{{ $user->role === 'agent' ? '#fff' : '#6B6B6B' }};">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="table-empty">No users yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Recent listings --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2><i class="fa-solid fa-building"></i> Recent Listings</h2>
                    <a href="{{ route('admin.listings') }}">View all</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentListings as $listing)
                        <tr>
                            <td>{{ $listing->title }}</td>
                            <td>{{ ucfirst($listing->type) }}</td>
                            <td>TZS {{ number_format($listing->price) }}</td>
                            <td>
                                <span style="padding:3px 8px;border-radius:20px;font-size:11px;font-weight:700;
                                    background:{{ $listing->status === 'active' ? '#D1FAE5' : ($listing->status === 'pending' ? '#FEF9C3' : '#FEE2E2') }};
                                    color:{{ $listing->status === 'active' ? '#065F46' : ($listing->status === 'pending' ? '#854D0E' : '#991B1B') }};">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="table-empty">No listings yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

</body>
</html>
