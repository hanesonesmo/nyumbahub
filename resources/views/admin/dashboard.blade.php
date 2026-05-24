<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — NyumbaHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            Nyumba<span>Hub</span>
            <small>Admin Panel</small>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link">
                <i class="fa-solid fa-users"></i> Users
            </a>
            <a href="{{ route('admin.listings') }}" class="sidebar-link">
                <i class="fa-solid fa-building"></i> Listings
            </a>
            <a href="{{ route('admin.appointments') }}" class="sidebar-link">
                <i class="fa-solid fa-calendar"></i> Appointments
            </a>
            <div class="sidebar-divider"></div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="sidebar-link sidebar-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="admin-main">

        {{-- Top bar --}}
        <header class="admin-topbar">
            <h1 class="topbar-title">Dashboard</h1>
            <div class="topbar-admin">
                <i class="fa-solid fa-shield-halved"></i>
                Admin
            </div>
        </header>

        {{-- Content --}}
        <div class="admin-content">

            {{-- Stats --}}
            <div class="admin-stats">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background:#1B4332;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="admin-stat-number">0</div>
                        <div class="admin-stat-label">Total Users</div>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background:#2D6A4F;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <div class="admin-stat-number">0</div>
                        <div class="admin-stat-label">Total Listings</div>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background:#D4A853;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="admin-stat-number">0</div>
                        <div class="admin-stat-label">Appointments</div>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon" style="background:#C0392B;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="admin-stat-number">0</div>
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
                            <tr>
                                <td colspan="4" class="table-empty">No users yet</td>
                            </tr>
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
                            <tr>
                                <td colspan="4" class="table-empty">No listings yet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</body>
</html>
