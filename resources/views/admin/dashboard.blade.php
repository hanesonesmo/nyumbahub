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

                {{-- Pending Agent Applications --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fa-solid fa-id-card-clip"></i> Pending Agent Applications</h2>
                        <a href="{{ route('admin.agent-applications') }}" class="card-action">Review All</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Experience</th>
                                <th>Submitted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingApplications as $application)
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--gray-900);">{{ $application->full_name }}</div>
                                    <div style="font-size:12px;color:var(--gray-500);">{{ $application->email }}</div>
                                </td>
                                <td style="font-size:13px;">{{ $application->years_experience }} years</td>
                                <td style="color:var(--gray-500);font-size:13px;">{{ $application->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.agent-applications') }}" class="btn-primary btn-sm" style="padding:4px 10px;font-size:11px;">Review</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="table-empty">No pending agent applications</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pending Property Listings --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fa-solid fa-building"></i> Pending Property Listings</h2>
                        <a href="{{ route('admin.listings') }}" class="card-action">Review All</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Agent</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingListings as $listing)
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--gray-900);">{{ Str::limit($listing->title, 25) }}</div>
                                    <div style="font-size:12px;color:var(--gray-500);">{{ ucfirst($listing->type) }} · {{ $listing->location }}</div>
                                </td>
                                <td>
                                    <div style="font-weight:600;font-size:13px;">{{ $listing->agent->first_name }} {{ $listing->agent->last_name }}</div>
                                </td>
                                <td style="font-weight:600;font-size:13px;">TZS {{ number_format($listing->price) }}</td>
                                <td>
                                    <a href="{{ route('admin.listings') }}" class="btn-primary btn-sm" style="padding:4px 10px;font-size:11px;">Review</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="table-empty">No pending property listings</td></tr>
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
