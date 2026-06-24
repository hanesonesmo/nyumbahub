<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
</head>
<body style="background:var(--gray-50);">

<div class="dashboard-wrapper">

    {{-- Sidebar --}}
    @include('admin.partials.sidebar', ['active' => 'dashboard'])

    {{-- Main --}}
    <div class="dashboard-main">

        {{-- Topbar --}}
        <header class="dashboard-topbar">
            <div>
                <div class="topbar-title">Dashboard</div>
                <div class="topbar-subtitle">Welcome back, Admin</div>
            </div>
            <div class="topbar-right">
                <div class="topbar-user">
                    <div class="topbar-avatar">A</div>
                    NyumbaHub Admin
                </div>
            </div>
        </header>

        <div class="dashboard-content">

            @if(session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif

            {{-- Stats --}}
            <div class="stats-grid" style="margin-bottom:24px;">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['total_users'] }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#F0FDF4;color:#16A34A;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['total_listings'] }}</div>
                        <div class="stat-label">Total Listings</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#FFFBEB;color:#D97706;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['pending'] }}</div>
                        <div class="stat-label">Pending Approval</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#FFF1F2;color:#E11D48;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['active_agents'] }}</div>
                        <div class="stat-label">Active Agents</div>
                    </div>
                </div>
            </div>

            {{-- Tables --}}
            <div class="content-grid">

                {{-- Recent Users --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fa-solid fa-users"></i> Recent Users</h2>
                        <a href="{{ route('admin.users') }}" class="card-action">View all</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--gray-900);">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div style="font-size:12px;color:var(--gray-500);">{{ $user->email }}</div>
                                </td>
                                <td><span class="badge badge-active">{{ ucfirst($user->role) }}</span></td>
                                <td style="color:var(--gray-500);font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="table-empty">No users yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Recent Listings --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fa-solid fa-building"></i> Recent Listings</h2>
                        <a href="{{ route('admin.listings') }}" class="card-action">View all</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentListings as $listing)
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--gray-900);">{{ Str::limit($listing->title, 25) }}</div>
                                    <div style="font-size:12px;color:var(--gray-500);">{{ ucfirst($listing->type) }} · {{ $listing->location }}</div>
                                </td>
                                <td style="font-weight:600;font-size:13px;">TZS {{ number_format($listing->price) }}</td>
                                <td><span class="badge badge-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="table-empty">No listings yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>
